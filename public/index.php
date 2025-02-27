<?php
/**
 * PhpForge - AI-Powered PHP Tools Suite
 * Main Application Entry Point
 */

// Set error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the application root directory
define('ROOT_DIR', dirname(__DIR__));

// Autoload dependencies
if (!file_exists(ROOT_DIR . '/vendor/autoload.php')) {
    die('Please run "composer install" to install dependencies');
}
require ROOT_DIR . '/vendor/autoload.php';

// For debugging
function debug($message, $data = null) {
    if (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG']) {
        error_log($message . ($data ? ': ' . print_r($data, true) : ''));
    }
}

// Load environment variables
try {
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
    $dotenv->load();
    
    // Required environment variables
    $dotenv->required([
        'APP_NAME',
        'APP_ENV',
        'APP_URL',
        'DB_HOST',
        'DB_DATABASE',
        'DB_USERNAME'
    ]);

    debug('Environment variables loaded');
} catch (Exception $e) {
    die('Error loading environment variables: ' . $e->getMessage());
}

// Initialize the application
try {
    debug('Creating application instance');
    
    // Create application instance
    $app = \PhpForge\Core\App::getInstance();

    debug('Registering error handlers');
    // Register error handlers
    $app->registerErrorHandlers();

    debug('Initializing services');
    // Initialize services
    $app->initializeServices();

    debug('Current request', [
        'METHOD' => $_SERVER['REQUEST_METHOD'],
        'URI' => $_SERVER['REQUEST_URI'],
        'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME']
    ]);

    // Get router for debugging
    $router = $app->service('router');
    debug('Registered routes', $router->getRoutes());

    debug('Handling request');
    // Handle the request
    $app->handleRequest();
} catch (Exception $e) {
    // Handle fatal errors
    if (filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
        // Show detailed error in development
        echo '<h1>Application Error</h1>';
        echo '<pre>' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>';
    } else {
        // Show generic error in production
        http_response_code(500);
        echo 'An unexpected error occurred. Please try again later.';
    }
    
    // Log the error
    error_log($e->getMessage() . "\n" . $e->getTraceAsString());
}