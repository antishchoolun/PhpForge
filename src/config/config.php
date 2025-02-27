<?php
/**
 * Application Configuration
 * 
 * This file contains general application settings and constants
 */

// Application Info
define('APP_NAME', 'PhpForge');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'https://phpforge.com');

// Environment
define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');
define('DEBUG_MODE', APP_ENV === 'development');

// Security
define('CSRF_TOKEN_NAME', 'phpforge_csrf_token');
define('SESSION_NAME', 'phpforge_session');
define('PASSWORD_MIN_LENGTH', 8);
define('AUTH_TOKEN_EXPIRY', 7200); // 2 hours in seconds

// API Settings
define('GROQ_API_URL', 'https://api.groq.com/v1');
define('GROQ_API_VERSION', '1.0');
define('API_RATE_LIMIT', 60); // requests per minute
define('API_TIMEOUT', 30); // seconds

// File Upload Settings
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', [
    'php' => 'text/php',
    'js' => 'text/javascript',
    'css' => 'text/css',
    'txt' => 'text/plain',
    'json' => 'application/json',
    'xml' => 'application/xml',
]);

// Cache Settings
define('CACHE_ENABLED', true);
define('CACHE_TTL', 3600); // 1 hour in seconds
define('CACHE_PREFIX', 'phpforge_');

// Tool Settings
define('CODE_GENERATION_MAX_TOKENS', 2000);
define('SECURITY_SCAN_TIMEOUT', 300); // 5 minutes
define('MAX_FILES_PER_SCAN', 100);
define('DOCUMENTATION_MAX_FILES', 50);

// Pagination
define('ITEMS_PER_PAGE', 20);
define('MAX_PAGINATION_LINKS', 5);

// Email Settings
define('SMTP_HOST', $_ENV['SMTP_HOST'] ?? 'smtp.mailtrap.io');
define('SMTP_PORT', $_ENV['SMTP_PORT'] ?? 2525);
define('SMTP_USER', $_ENV['SMTP_USER'] ?? '');
define('SMTP_PASS', $_ENV['SMTP_PASS'] ?? '');
define('MAIL_FROM_ADDRESS', 'noreply@phpforge.com');
define('MAIL_FROM_NAME', 'PhpForge');

// Social Media Links
define('SOCIAL_LINKS', [
    'twitter' => 'https://twitter.com/phpforge',
    'github' => 'https://github.com/phpforge',
    'linkedin' => 'https://linkedin.com/company/phpforge'
]);

// Plan Limits
define('PLAN_LIMITS', [
    'free' => [
        'requests_per_day' => 50,
        'max_file_size' => 1 * 1024 * 1024, // 1MB
        'concurrent_scans' => 1,
        'tools_available' => ['code_generator', 'debug_basic']
    ],
    'pro' => [
        'requests_per_day' => 500,
        'max_file_size' => 5 * 1024 * 1024, // 5MB
        'concurrent_scans' => 3,
        'tools_available' => ['code_generator', 'debug_advanced', 'security', 'performance']
    ],
    'enterprise' => [
        'requests_per_day' => 5000,
        'max_file_size' => 20 * 1024 * 1024, // 20MB
        'concurrent_scans' => 10,
        'tools_available' => ['code_generator', 'debug_advanced', 'security', 'performance', 'documentation', 'domain']
    ]
]);

// Support
define('SUPPORT_EMAIL', 'support@phpforge.com');
define('DOCS_URL', 'https://docs.phpforge.com');
define('API_DOCS_URL', 'https://api.phpforge.com/docs');