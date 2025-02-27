<?php

namespace PhpForge\Core;

use Exception;

class Router
{
    /**
     * @var array Array of registered routes
     */
    private $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    /**
     * @var string Current route group prefix
     */
    private $groupPrefix = '';

    /**
     * Create a new Router instance
     */
    public function __construct()
    {
        $this->routes = [
            'GET' => [],
            'POST' => [],
            'PUT' => [],
            'DELETE' => []
        ];
        $this->groupPrefix = '';
    }

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
     * Register a GET route
     */
    public function get(string $uri, $handler): void
    {
        $this->addRoute('GET', $uri, $handler);
    }

    /**
     * Register a POST route
     */
    public function post(string $uri, $handler): void
    {
        $this->addRoute('POST', $uri, $handler);
    }

    /**
     * Register a PUT route
     */
    public function put(string $uri, $handler): void
    {
        $this->addRoute('PUT', $uri, $handler);
    }

    /**
     * Register a DELETE route
     */
    public function delete(string $uri, $handler): void
    {
        $this->addRoute('DELETE', $uri, $handler);
    }

    /**
     * Add a route to the router
     */
    private function addRoute(string $method, string $uri, $handler): void
    {
        // Prepare the route URI
        $uri = '/' . trim($uri, '/');
        
        if (!empty($this->groupPrefix)) {
            $uri = rtrim($this->groupPrefix, '/') . '/' . ltrim($uri, '/');
        }

        $this->debug("Registering route: {$method} {$uri}");

        // Store route
        $this->routes[$method][$uri] = [
            'uri' => $uri,
            'handler' => $handler
        ];
    }

    /**
     * Dispatch the request
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = '/' . trim($uri, '/');

        if ($uri === '') {
            $uri = '/';
        }

        $this->debug("Dispatching request", [
            'method' => $method,
            'uri' => $uri,
            'available_routes' => $this->routes[$method] ?? []
        ]);

        // Check if method is supported
        if (!isset($this->routes[$method])) {
            throw new Exception("HTTP method not supported: {$method}", 405);
        }

        // Check if route exists
        if (!isset($this->routes[$method][$uri])) {
            $this->debug("No route found for {$method} {$uri}");
            $this->debug("Available routes", $this->routes[$method]);
            throw new Exception("Route not found: {$method} {$uri}", 404);
        }

        $route = $this->routes[$method][$uri];
        $handler = $route['handler'];

        $this->debug("Found route", [
            'uri' => $uri,
            'handler' => is_string($handler) ? $handler : 'Closure'
        ]);

        // Handle string handlers (Controller@method)
        if (is_string($handler)) {
            [$controllerName, $method] = explode('@', $handler);
            
            // Add namespace if not present
            if (strpos($controllerName, '\\') === false) {
                $controllerName = "PhpForge\\Controllers\\{$controllerName}";
            }

            $this->debug("Loading controller", [
                'class' => $controllerName,
                'method' => $method
            ]);

            if (!class_exists($controllerName)) {
                $this->debug("Controller not found: {$controllerName}");
                throw new Exception("Controller not found: {$controllerName}", 500);
            }

            $controller = new $controllerName();
            
            if (!method_exists($controller, $method)) {
                $this->debug("Method not found: {$controllerName}::{$method}");
                throw new Exception("Method not found: {$controllerName}::{$method}", 500);
            }

            $this->debug("Calling controller method: {$controllerName}::{$method}");
            $controller->$method();
            return;
        }

        // Handle closure
        if (is_callable($handler)) {
            $this->debug("Executing closure handler");
            $handler();
            return;
        }

        $this->debug("Invalid route handler");
        throw new Exception('Invalid route handler', 500);
    }

    /**
     * Create a route group
     */
    public function group(string $prefix, callable $callback): void
    {
        $previousPrefix = $this->groupPrefix;
        $this->groupPrefix = $previousPrefix . '/' . trim($prefix, '/');
        
        $this->debug("Creating route group", [
            'prefix' => $this->groupPrefix
        ]);

        $callback($this);
        
        $this->groupPrefix = $previousPrefix;
    }

    /**
     * Debug method to get registered routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}