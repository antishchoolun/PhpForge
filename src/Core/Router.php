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
     * @var array Route middleware
     */
    private $middleware = [];

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
     * Create a route group
     */
    public function group(string $prefix, callable $callback): void
    {
        $previousGroupPrefix = $this->groupPrefix;
        $this->groupPrefix .= $prefix;

        $callback($this);

        $this->groupPrefix = $previousGroupPrefix;
    }

    /**
     * Add a route to the router
     */
    private function addRoute(string $method, string $uri, $handler): void
    {
        // Prepare the route URI with group prefix
        $uri = $this->groupPrefix . '/' . trim($uri, '/');
        $uri = '/' . trim($uri, '/');

        // Convert handler string to array with controller and method
        if (is_string($handler)) {
            [$controller, $method] = explode('@', $handler);
            $handler = [
                'controller' => "PhpForge\\Controllers\\$controller",
                'method' => $method
            ];
        }

        // Store route with pattern and handler
        $this->routes[$method][$uri] = [
            'pattern' => $this->convertUriToRegex($uri),
            'handler' => $handler,
            'middleware' => $this->middleware
        ];
    }

    /**
     * Convert URI to regex pattern
     */
    private function convertUriToRegex(string $uri): string
    {
        return preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[^/]+)', $uri);
    }

    /**
     * Get current request URI
     */
    private function getCurrentUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        
        return '/' . trim($uri, '/');
    }

    /**
     * Match the route and return handler with params
     */
    private function matchRoute(string $method, string $uri): ?array
    {
        $routes = $this->routes[$method] ?? [];
        
        foreach ($routes as $route => $data) {
            if (preg_match('#^' . $data['pattern'] . '$#', $uri, $matches)) {
                // Extract named parameters
                $params = array_filter($matches, function ($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);

                return [
                    'handler' => $data['handler'],
                    'params' => $params,
                    'middleware' => $data['middleware'] ?? []
                ];
            }
        }
        
        return null;
    }

    /**
     * Dispatch the request to the appropriate handler
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->getCurrentUri();
        
        // Match the route
        $route = $this->matchRoute($method, $uri);
        
        if ($route === null) {
            http_response_code(404);
            throw new Exception('Route not found');
        }

        try {
            // Execute middleware stack
            foreach ($route['middleware'] as $middleware) {
                $middlewareInstance = new $middleware();
                $middlewareInstance->handle();
            }

            // Create controller instance and call method
            if (is_array($route['handler'])) {
                $controller = new $route['handler']['controller']();
                $method = $route['handler']['method'];
                
                $response = $controller->$method(...array_values($route['params']));
            } else {
                // Handle closure based routes
                $response = ($route['handler'])(...array_values($route['params']));
            }

            // Send the response
            if (is_array($response) || is_object($response)) {
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                echo $response;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Add middleware to the route
     */
    public function middleware(string $middleware): self
    {
        $this->middleware[] = $middleware;
        return $this;
    }
}