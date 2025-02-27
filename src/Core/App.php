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
     * Create a new Application instance
     */
    public function __construct()
    {
        if (self::$instance !== null) {
            throw new Exception('Application can only be instantiated once');
        }

        self::$instance = $this;
        $this->router = new Router();
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
        set_error_handler(function ($severity, $message, $file, $line) {
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });

        set_exception_handler(function ($e) {
            $this->handleException($e);
        });
    }

    /**
     * Load application configurations
     */
    public function loadConfigurations(): void
    {
        // Load database configuration
        $this->db = new Database([
            'host' => $_ENV['DB_HOST'],
            'dbname' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
        ]);

        // Initialize router with routes
        $this->initializeRoutes();
    }

    /**
     * Initialize application services
     */
    public function initializeServices(): void
    {
        // Register core services
        $this->services['db'] = $this->db;
        $this->services['router'] = $this->router;

        // Initialize logging
        $this->initializeLogging();

        // Initialize caching
        $this->initializeCaching();
    }

    /**
     * Initialize logging service
     */
    private function initializeLogging(): void
    {
        $logPath = ROOT_DIR . '/logs/app.log';
        $this->services['logger'] = new \Monolog\Logger('phpforge');
        $this->services['logger']->pushHandler(
            new \Monolog\Handler\RotatingFileHandler($logPath, 30)
        );
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
    }

    /**
     * Initialize application routes
     */
    private function initializeRoutes(): void
    {
        // API Routes
        $this->router->group('/api/v1', function (Router $router) {
            // Auth routes
            $router->post('/auth/login', 'AuthController@login');
            $router->post('/auth/register', 'AuthController@register');
            $router->post('/auth/logout', 'AuthController@logout');

            // Tool routes
            $router->post('/tools/generate', 'ToolController@generate');
            $router->post('/tools/debug', 'ToolController@debug');
            $router->post('/tools/security', 'ToolController@security');
            $router->post('/tools/optimize', 'ToolController@optimize');
            $router->post('/tools/document', 'ToolController@document');
            $router->post('/tools/evaluate', 'ToolController@evaluate');

            // User routes
            $router->get('/user/usage', 'UserController@usage');
        });

        // Web Routes
        $this->router->get('/', 'HomeController@index');
        $this->router->get('/tools', 'HomeController@tools');
        $this->router->get('/pricing', 'HomeController@pricing');
        $this->router->get('/docs', 'HomeController@documentation');
        $this->router->get('/blog', 'HomeController@blog');
    }

    /**
     * Handle the incoming request
     */
    public function handleRequest(): void
    {
        try {
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
        if (isset($this->services['logger'])) {
            $this->services['logger']->error($e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }

        // Set appropriate HTTP status code
        http_response_code(500);

        // Display error based on environment
        if (filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
            echo '<h1>Application Error</h1>';
            echo '<pre>' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>';
        } else {
            echo 'An unexpected error occurred. Please try again later.';
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
}