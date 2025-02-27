<?php
/**
 * Application Initialization
 * 
 * This file initializes the application by:
 * - Setting up error reporting
 * - Starting sessions
 * - Loading configurations
 * - Setting up database connections
 * - Defining base constants
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error reporting - set to 0 in production
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base paths
define('BASE_PATH', dirname(__DIR__, 1));
define('CONFIG_PATH', BASE_PATH . '/config');
define('COMPONENTS_PATH', BASE_PATH . '/components');
define('PUBLIC_PATH', dirname(__DIR__, 1) . '/public');

// Load configuration files
require_once CONFIG_PATH . '/config.php';
require_once CONFIG_PATH . '/database.php';

// Set default timezone
date_default_timezone_set('UTC');

// Initialize database connection
try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // Log the error and show a user-friendly message
    error_log("Database Connection Error: " . $e->getMessage());
    die("We're experiencing technical difficulties. Please try again later.");
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to redirect to a URL
function redirect($url) {
    header("Location: $url");
    exit();
}

// Function to sanitize output
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Function to get current page name
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF'], '.php');
}

// Load any additional helpers or functions
require_once CONFIG_PATH . '/helpers.php';