<?php

namespace PhpForge\Core;

abstract class Controller
{
    /**
     * @var App Application instance
     */
    protected $app;

    /**
     * @var array Request data
     */
    protected $request;

    /**
     * @var Database Database instance
     */
    protected $db;

    /**
     * Debug log helper
     */
    protected function debug($message, $data = null): void
    {
        if (function_exists('debug')) {
            debug($message, $data);
        } elseif (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG']) {
            error_log($message . ($data ? ': ' . print_r($data, true) : ''));
        }
    }

    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->debug('Initializing controller: ' . get_class($this));
        
        $this->app = App::getInstance();
        $this->db = $this->app->service('db');
        
        // Initialize basic request data first
        $this->request = [
            'method' => $_SERVER['REQUEST_METHOD'],
            'uri' => $_SERVER['REQUEST_URI']
        ];
        
        // Then add additional request data
        $this->initializeRequest();
    }

    /**
     * Initialize request data
     */
    protected function initializeRequest(): void
    {
        $this->request = array_merge($this->request, [
            'params' => $_REQUEST,
            'headers' => $this->getRequestHeaders(),
            'body' => $this->getRequestBody()
        ]);

        $this->debug('Request initialized', $this->request);
    }

    /**
     * Get request headers
     */
    protected function getRequestHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
                $headers[$header] = $value;
            }
        }
        return $headers;
    }

    /**
     * Get request body
     */
    protected function getRequestBody(): array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        
        if ($method === 'POST' || $method === 'PUT') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            
            if (strpos($contentType, 'application/json') !== false) {
                $input = file_get_contents('php://input');
                return json_decode($input, true) ?? [];
            } 
            
            return $_POST;
        }
        
        return [];
    }

    /**
     * Render a view
     */
    protected function render(string $view, array $data = []): void
    {
        $this->debug('Rendering view', [
            'view' => $view,
            'data' => array_keys($data)
        ]);

        // Extract data to make it available in the view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewPath = ROOT_DIR . '/templates/' . $view . '.php';
        
        if (!file_exists($viewPath)) {
            $this->debug("View not found", ['path' => $viewPath]);
            throw new \Exception("View not found: {$view}");
        }
        
        $this->debug("Including view file", ['path' => $viewPath]);
        include $viewPath;
        
        // Get the contents and clean the buffer
        $content = ob_get_clean();
        
        // Send content
        echo $content;
    }

    /**
     * Send a JSON response
     */
    protected function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Send a success response
     */
    protected function success($data = null, string $message = 'Success', int $status = 200): void
    {
        $this->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Send an error response
     */
    protected function error(string $message = 'Error', int $status = 400, $errors = null): void
    {
        $this->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }

    /**
     * Validate request data
     */
    protected function validate(array $rules): array
    {
        $errors = [];
        $data = array_merge($this->request['params'], $this->request['body']);

        foreach ($rules as $field => $rule) {
            $rules = explode('|', $rule);
            
            foreach ($rules as $rule) {
                if ($rule === 'required' && (!isset($data[$field]) || empty($data[$field]))) {
                    $errors[$field][] = "The {$field} field is required.";
                    continue;
                }

                if (isset($data[$field])) {
                    if ($rule === 'email' && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = "The {$field} must be a valid email address.";
                    }

                    if (strpos($rule, 'min:') === 0) {
                        $min = substr($rule, 4);
                        if (strlen($data[$field]) < $min) {
                            $errors[$field][] = "The {$field} must be at least {$min} characters.";
                        }
                    }

                    if (strpos($rule, 'max:') === 0) {
                        $max = substr($rule, 4);
                        if (strlen($data[$field]) > $max) {
                            $errors[$field][] = "The {$field} may not be greater than {$max} characters.";
                        }
                    }
                }
            }
        }

        if (!empty($errors)) {
            $this->error('Validation failed', 422, $errors);
        }

        return $data;
    }
}