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
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->app = App::getInstance();
        $this->initializeRequest();
    }

    /**
     * Initialize request data
     */
    protected function initializeRequest(): void
    {
        $this->request = [
            'method' => $_SERVER['REQUEST_METHOD'],
            'uri' => $_SERVER['REQUEST_URI'],
            'params' => $_REQUEST,
            'headers' => $this->getRequestHeaders(),
            'body' => $this->getRequestBody()
        ];
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
        $body = [];
        
        if ($this->request['method'] === 'POST' || $this->request['method'] === 'PUT') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            
            if (strpos($contentType, 'application/json') !== false) {
                $input = file_get_contents('php://input');
                $body = json_decode($input, true) ?? [];
            } else {
                $body = $_POST;
            }
        }
        
        return $body;
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

    /**
     * Render a view
     */
    protected function render(string $view, array $data = []): void
    {
        $viewPath = ROOT_DIR . '/templates/' . $view . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View {$view} not found");
        }

        // Extract data to make it available in the view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        include $viewPath;
        
        // Get the contents and clean the buffer
        $content = ob_get_clean();
        
        echo $content;
        exit;
    }

    /**
     * Get a service from the container
     */
    protected function service(string $name)
    {
        return $this->app->service($name);
    }
}