<?php

// Define root directory
define('ROOT_DIR', dirname(__DIR__));

// Required directories with their permissions
$directories = [
    'cache' => 0755,
    'logs' => 0755,
    'public/assets/uploads' => 0755,
    'storage' => 0755,
    'storage/temp' => 0755,
    'vendor' => 0755,
];

// ANSI color codes for output
$colors = [
    'green' => "\033[0;32m",
    'red' => "\033[0;31m",
    'yellow' => "\033[1;33m",
    'reset' => "\033[0m"
];

echo "Checking directory structure...\n\n";

$hasErrors = false;

foreach ($directories as $dir => $permission) {
    $path = ROOT_DIR . '/' . $dir;
    
    // Check if directory exists
    if (!file_exists($path)) {
        echo "{$colors['yellow']}Creating directory: {$dir}{$colors['reset']}\n";
        
        if (!mkdir($path, $permission, true)) {
            echo "{$colors['red']}Failed to create directory: {$dir}{$colors['reset']}\n";
            $hasErrors = true;
            continue;
        }
    }

    // Check directory permissions
    $currentPerms = substr(sprintf('%o', fileperms($path)), -4);
    $requiredPerms = sprintf('%04o', $permission);
    
    if ($currentPerms !== $requiredPerms) {
        echo "{$colors['yellow']}Fixing permissions for {$dir} ({$currentPerms} -> {$requiredPerms}){$colors['reset']}\n";
        
        if (!chmod($path, $permission)) {
            echo "{$colors['red']}Failed to set permissions for: {$dir}{$colors['reset']}\n";
            $hasErrors = true;
            continue;
        }
    }

    echo "{$colors['green']}✓ {$dir} (permissions: {$requiredPerms}){$colors['reset']}\n";
}

// Check for .htaccess in public directory
$htaccess = ROOT_DIR . '/public/.htaccess';
if (!file_exists($htaccess)) {
    echo "{$colors['red']}\nWarning: .htaccess file missing in public directory{$colors['reset']}\n";
    $hasErrors = true;
}

// Check for .env file
$env = ROOT_DIR . '/.env';
if (!file_exists($env)) {
    echo "{$colors['yellow']}\nNotice: .env file missing. Creating from .env.example...{$colors['reset']}\n";
    if (!copy(ROOT_DIR . '/.env.example', $env)) {
        echo "{$colors['red']}Failed to create .env file{$colors['reset']}\n";
        $hasErrors = true;
    } else {
        echo "{$colors['green']}✓ Created .env file{$colors['reset']}\n";
    }
}

// Check composer installation
if (!file_exists(ROOT_DIR . '/vendor/autoload.php')) {
    echo "{$colors['red']}\nError: Composer dependencies not installed. Run 'composer install'{$colors['reset']}\n";
    $hasErrors = true;
}

echo "\nDirectory check " . ($hasErrors ? "completed with errors" : "successful") . "\n";

if ($hasErrors) {
    echo "{$colors['red']}Please fix the reported issues before running the application{$colors['reset']}\n";
    exit(1);
}

echo "{$colors['green']}System ready to run{$colors['reset']}\n";