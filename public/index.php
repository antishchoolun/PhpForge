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
require ROOT_DIR . '/vendor/autoload.php';

// Load environment variables
try {
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
    $dotenv->load();
    $dotenv->required([
        'APP_NAME', 'APP_ENV', 'APP_URL', 
        'DB_HOST', 'DB_DATABASE', 'DB_USERNAME'
    ]);
} catch (Exception $e) {
    die('Error loading environment variables: ' . $e->getMessage());
}

// Initialize the application
try {
    // Create application instance
    $app = new \PhpForge\Core\App();

    // Register error handlers
    $app->registerErrorHandlers();

    // Load configurations
    $app->loadConfigurations();

    // Initialize services
    $app->initializeServices();

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