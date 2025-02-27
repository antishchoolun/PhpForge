<?php

/**
 * PhpForge Setup Script
 * This script initializes the project by setting up the database,
 * creating required directories, and configuring the environment.
 */

// Define root directory
define('ROOT_DIR', dirname(__DIR__));

// Check PHP version
if (PHP_VERSION_ID < 80200) {
    die("Error: PHP 8.2 or higher is required. Current version: " . PHP_VERSION . "\n");
}

// Check if running from command line
if (php_sapi_name() !== 'cli') {
    die("Error: This script must be run from the command line\n");
}

// Function to output colored text
function output($message, $type = 'info') {
    $colors = [
        'info' => "\033[0;32m", // Green
        'error' => "\033[0;31m", // Red
        'warning' => "\033[1;33m", // Yellow
        'reset' => "\033[0m"
    ];
    
    echo $colors[$type] . $message . $colors['reset'] . "\n";
}

// Function to check required extensions
function checkExtensions() {
    $required = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'openssl', 'sodium'];
    $missing = [];
    
    foreach ($required as $ext) {
        if (!extension_loaded($ext)) {
            $missing[] = $ext;
        }
    }
    
    if (!empty($missing)) {
        output("Error: Missing required PHP extensions: " . implode(', ', $missing), 'error');
        return false;
    }
    
    output("✓ Required PHP extensions verified");
    return true;
}

// Function to create required directories
function createDirectories() {
    $directories = [
        'logs',
        'cache',
        'storage',
        'storage/temp',
        'public/assets/uploads'
    ];
    
    foreach ($directories as $dir) {
        $path = ROOT_DIR . '/' . $dir;
        if (!is_dir($path)) {
            if (mkdir($path, 0755, true)) {
                output("✓ Created directory: $dir");
            } else {
                output("Error: Failed to create directory: $dir", 'error');
                return false;
            }
        }
    }
    
    return true;
}

// Function to check and set directory permissions
function setPermissions() {
    $paths = [
        'logs',
        'cache',
        'storage',
        'public/assets/uploads',
        '.env'
    ];
    
    foreach ($paths as $path) {
        $fullPath = ROOT_DIR . '/' . $path;
        if (file_exists($fullPath)) {
            if (is_dir($fullPath)) {
                chmod($fullPath, 0755);
            } else {
                chmod($fullPath, 0644);
            }
            output("✓ Set permissions for: $path");
        }
    }
}

// Function to setup environment file
function setupEnvironment() {
    $envFile = ROOT_DIR . '/.env';
    $envExampleFile = ROOT_DIR . '/.env.example';
    
    if (!file_exists($envFile)) {
        if (!copy($envExampleFile, $envFile)) {
            output("Error: Failed to create .env file", 'error');
            return false;
        }
        output("✓ Created .env file from example");
    }
    
    return true;
}

// Function to verify database connection
function verifyDatabaseConnection() {
    require_once ROOT_DIR . '/vendor/autoload.php';
    
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
        $dotenv->load();
        
        $dsn = sprintf(
            "mysql:host=%s;port=%s",
            $_ENV['DB_HOST'] ?? 'localhost',
            $_ENV['DB_PORT'] ?? '3306'
        );
        
        $pdo = new PDO(
            $dsn,
            $_ENV['DB_USERNAME'] ?? 'root',
            $_ENV['DB_PASSWORD'] ?? '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        output("✓ Database connection verified");
        return true;
    } catch (Exception $e) {
        output("Error: Database connection failed - " . $e->getMessage(), 'error');
        return false;
    }
}

// Function to import database schema
function importDatabaseSchema() {
    try {
        $schemaFile = ROOT_DIR . '/database/schema.sql';
        if (!file_exists($schemaFile)) {
            output("Error: Database schema file not found", 'error');
            return false;
        }
        
        $dsn = sprintf(
            "mysql:host=%s;port=%s",
            $_ENV['DB_HOST'] ?? 'localhost',
            $_ENV['DB_PORT'] ?? '3306'
        );
        
        $pdo = new PDO(
            $dsn,
            $_ENV['DB_USERNAME'] ?? 'root',
            $_ENV['DB_PASSWORD'] ?? '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        $sql = file_get_contents($schemaFile);
        $pdo->exec($sql);
        
        output("✓ Database schema imported successfully");
        return true;
    } catch (Exception $e) {
        output("Error: Failed to import database schema - " . $e->getMessage(), 'error');
        return false;
    }
}

// Function to generate application key
function generateAppKey() {
    $key = base64_encode(random_bytes(32));
    $envFile = ROOT_DIR . '/.env';
    
    if (file_exists($envFile)) {
        $content = file_get_contents($envFile);
        $content = preg_replace('/APP_KEY=.*$/m', "APP_KEY={$key}", $content);
        
        if (file_put_contents($envFile, $content)) {
            output("✓ Generated new application key");
            return true;
        }
    }
    
    output("Error: Failed to generate application key", 'error');
    return false;
}

// Main setup process
output("\nPhpForge Setup\n============", 'info');

// Run setup steps
$steps = [
    'Checking PHP extensions' => 'checkExtensions',
    'Creating required directories' => 'createDirectories',
    'Setting up environment file' => 'setupEnvironment',
    'Verifying database connection' => 'verifyDatabaseConnection',
    'Importing database schema' => 'importDatabaseSchema',
    'Generating application key' => 'generateAppKey',
    'Setting file permissions' => 'setPermissions'
];

$success = true;

foreach ($steps as $description => $function) {
    output("\n> $description...");
    
    if (!$function()) {
        $success = false;
        break;
    }
}

if ($success) {
    output("\n✓ Setup completed successfully!", 'info');
    output("\nNext steps:");
    output("1. Configure your web server to point to the 'public' directory");
    output("2. Review and update your .env file with your settings");
    output("3. Run 'composer install' if you haven't already");
    output("4. Visit the website in your browser\n");
} else {
    output("\n× Setup failed. Please fix the errors and try again.", 'error');
}