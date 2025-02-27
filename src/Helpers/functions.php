<?php

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable
     */
    function env(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('config')) {
    /**
     * Get configuration value
     */
    function config(string $key, $default = null)
    {
        static $config = [];
        
        if (empty($config)) {
            $appConfig = new \PhpForge\Config\App();
            $config = $appConfig->getConfig();
        }
        
        $keys = explode('.', $key);
        $value = $config;
        
        foreach ($keys as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }
        
        return $value;
    }
}

if (!function_exists('base_path')) {
    /**
     * Get the application base path
     */
    function base_path(string $path = ''): string
    {
        return ROOT_DIR . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the public path
     */
    function public_path(string $path = ''): string
    {
        return ROOT_DIR . DIRECTORY_SEPARATOR . 'public' . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get the storage path
     */
    function storage_path(string $path = ''): string
    {
        return ROOT_DIR . DIRECTORY_SEPARATOR . 'storage' . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }
}

if (!function_exists('asset')) {
    /**
     * Generate an asset path
     */
    function asset(string $path): string
    {
        return rtrim(env('APP_URL'), '/') . '/assets/' . ltrim($path, '/');
    }
}

if (!function_exists('redirect')) {
    /**
     * Create a redirect response
     */
    function redirect(string $url, int $status = 302): void
    {
        header('Location: ' . $url, true, $status);
        exit;
    }
}

if (!function_exists('session')) {
    /**
     * Get or set session value
     */
    function session(string $key = null, $default = null)
    {
        if (is_null($key)) {
            return $_SESSION;
        }
        
        if (strpos($key, '.') !== false) {
            $keys = explode('.', $key);
            $value = $_SESSION;
            
            foreach ($keys as $segment) {
                if (!is_array($value) || !array_key_exists($segment, $value)) {
                    return $default;
                }
                $value = $value[$segment];
            }
            
            return $value;
        }
        
        return $_SESSION[$key] ?? $default;
    }
}

if (!function_exists('old')) {
    /**
     * Get old form input value
     */
    function old(string $key, $default = ''): string
    {
        return htmlspecialchars(session('_old.' . $key, $default), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get CSRF token
     */
    function csrf_token(): string
    {
        if (!isset($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['_token'];
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF token field
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

if (!function_exists('method_field')) {
    /**
     * Generate method field for forms
     */
    function method_field(string $method): string
    {
        return '<input type="hidden" name="_method" value="' . $method . '">';
    }
}