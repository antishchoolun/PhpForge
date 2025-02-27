<?php
/**
 * Database Configuration
 * 
 * This file contains database connection settings.
 * In production, these values should be set via environment variables.
 */

// Load environment variables if .env file exists
if (file_exists(dirname(__DIR__, 2) . '/.env')) {
    $env = parse_ini_file(dirname(__DIR__, 2) . '/.env');
    foreach ($env as $key => $value) {
        $_ENV[$key] = $value;
    }
}

// Database credentials
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'phpforge');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? 'admin');

// Additional database settings
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATION', 'utf8mb4_unicode_ci');

// Connection options
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

/**
 * Database Tables
 * Define table names as constants to avoid typos and make updates easier
 */
define('TABLE_USERS', 'users');
define('TABLE_API_KEYS', 'api_keys');
define('TABLE_TOOL_USAGE', 'tool_usage');
define('TABLE_USER_PROJECTS', 'user_projects');
define('TABLE_CODE_SNIPPETS', 'code_snippets');
define('TABLE_SECURITY_SCANS', 'security_scans');
define('TABLE_PERFORMANCE_LOGS', 'performance_logs');
define('TABLE_DOCUMENTATION', 'documentation');
define('TABLE_DOMAIN_VALUATIONS', 'domain_valuations');