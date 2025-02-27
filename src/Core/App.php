<?php

namespace PhpForge\Core;

use Exception;

class App
{
    /**
     * @var App Singleton instance
     */
    private static $instance = null;

    /**
     * @var array Registered services
     */
    private $services = [];

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Database
     */
    private $db;

    /**
     * Debug log helper
     */
    private function debug($message, $data = null): void
    {
        if (function_exists('debug')) {
            debug($message, $data);
        } elseif (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG']) {
            error_log($message . ($data ? ': ' . print_r($data, true) : ''));
        }
    }

    /**
     * Create a new Application instance
     */
    public function __construct()
    {
        if (self::$instance !== null) {
            throw new Exception('Application can only be instantiated once');
        }

        self::$instance = $this;
        
        $this->debug('Creating Router instance');
        $this->router = new Router();
    }

    /**
     * Register application routes
     */
    private function registerRoutes(): void
    {
        $this->debug('Registering routes');

        // Web Routes
        $this->router->get('/', 'HomeController@index');
        $this->router->get('/tools', 'HomeController@tools');
        $this->router->get('/pricing', 'HomeController@pricing');
        $this->router->get('/docs', 'HomeController@documentation');
        $this->router->get('/blog', 'HomeController@blog');

        // Auth Routes
        $this->router->post('/auth/login', 'AuthController@login');
        $this->router->post('/auth/register', 'AuthController@register');
        $this->router->post('/auth/logout', 'AuthController@logout');
        $this->router->post('/auth/forgot-password', 'AuthController@forgotPassword');
        $this->router->post('/auth/reset-password', 'AuthController@resetPassword');

        // Tool Routes
        $this->router->post('/api/tools/generate', 'ToolController@generate');
        $this->router->post('/api/tools/debug', 'ToolController@debug');
        $this->router->post('/api/tools/security', 'ToolController@security');
        $this->router->post('/api/tools/optimize', 'ToolController@optimize');
        $this->router->post('/api/tools/document', 'ToolController@document');
        $this->router->post('/api/tools/evaluate', 'ToolController@evaluate');
        
        // Tool Stats Routes
        $this->router->get('/api/tools/stats', 'ToolController@getStats');
        $this->router->get('/api/tools/history', 'ToolController@getHistory');

        $this->debug('Routes registered', $this->router->getRoutes());
    }

    /**
     * Get the singleton instance
     */
    public static function getInstance(): App
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Register error handlers
     */
    public function registerErrorHandlers(): void
    {
        $this->debug('Registering error handlers');

        set_error_handler(function ($severity, $message, $file, $line) {
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });

        set_exception_handler(function ($e) {
            $this->handleException($e);
        });
    }

    /**
     * Initialize application services
     */
    public function initializeServices(): void
    {
        $this->debug('Initializing services');

        // Initialize session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Load database configuration
        $this->db = new Database([
            'host' => $_ENV['DB_HOST'],
            'dbname' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
        ]);

        // Register core services
        $this->services['db'] = $this->db;
        $this->services['router'] = $this->router;

        // Initialize logging
        $this->initializeLogging();

        // Initialize caching
        $this->initializeCaching();

        // Register routes
        $this->registerRoutes();

        $this->debug('Services initialized');
    }

    /**
     * Initialize logging service
     */
    private function initializeLogging(): void
    {
        $logPath = ROOT_DIR . '/logs/app.log';
        
        // Create logs directory if it doesn't exist
        if (!is_dir(dirname($logPath))) {
            mkdir(dirname($logPath), 0777, true);
        }
        
        $this->services['logger'] = new \Monolog\Logger('phpforge');
        $this->services['logger']->pushHandler(
            new \Monolog\Handler\RotatingFileHandler($logPath, 30)
        );

        $this->debug('Logging service initialized');
    }

    /**
     * Initialize caching service
     */
    private function initializeCaching(): void
    {
        $cacheDir = ROOT_DIR . '/cache';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        $this->services['cache'] = new \Symfony\Component\Cache\Adapter\FilesystemAdapter(
            $_ENV['CACHE_PREFIX'],
            3600,
            $cacheDir
        );

        $this->debug('Caching service initialized');
    }

    /**
     * Handle the incoming request
     */
    public function handleRequest(): void
    {
        try {
            $this->debug('Handling request', [
                'method' => $_SERVER['REQUEST_METHOD'],
                'uri' => $_SERVER['REQUEST_URI']
            ]);

            $this->router->dispatch();
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * Handle an exception
     */
    private function handleException(\Throwable $e): void
    {
        // Log the error
        $message = $e->getMessage();
        $trace = $e->getTraceAsString();
        
        $this->debug('Exception caught', [
            'message' => $message,
            'trace' => $trace
        ]);

        if (isset($this->services['logger'])) {
            $this->services['logger']->error($message, [
                'trace' => $trace
            ]);
        }

        // Set appropriate HTTP status code
        $code = $e->getCode() ?: 500;
        if ($code < 100 || $code > 599) {
            $code = 500;
        }
        http_response_code($code);

        // Display error based on environment
        if (filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
            echo '<h1>Application Error</h1>';
            echo '<pre>' . $message . "\n" . $trace . '</pre>';
        } else {
            if ($code === 404) {
                $this->render('404');
            } else {
                echo 'An unexpected error occurred. Please try again later.';
            }
        }
    }

    /**
     * Get a service from the container
     */
    public function service(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new Exception("Service '$name' not found");
        }
        return $this->services[$name];
    }

    /**
     * Render a view
     */
    private function render(string $view): void
    {
        $viewPath = ROOT_DIR . '/templates/' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        }
    }
}