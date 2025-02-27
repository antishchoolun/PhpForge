<?php

namespace PhpForge\Config;

class App
{
    /**
     * Get application configuration
     */
    public static function getConfig(): array
    {
        return [
            'name' => $_ENV['APP_NAME'] ?? 'PhpForge',
            'env' => $_ENV['APP_ENV'] ?? 'production',
            'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'url' => rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/'),
            'timezone' => $_ENV['APP_TIMEZONE'] ?? 'UTC',
            'locale' => $_ENV['APP_LOCALE'] ?? 'en',
            'key' => $_ENV['APP_KEY'],

            'security' => [
                'jwt_secret' => $_ENV['JWT_SECRET'],
                'jwt_expiration' => (int) ($_ENV['JWT_EXPIRATION'] ?? 3600),
                'password_algo' => PASSWORD_ARGON2ID,
                'password_options' => [
                    'memory_cost' => 65536,
                    'time_cost' => 4,
                    'threads' => 3
                ],
                'csrf_token_name' => 'csrf_token',
                'session_lifetime' => (int) ($_ENV['SESSION_LIFETIME'] ?? 120),
                'session_secure' => filter_var($_ENV['SESSION_SECURE'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'session_http_only' => true,
                'session_same_site' => 'lax'
            ],

            'logging' => [
                'channel' => $_ENV['LOG_CHANNEL'] ?? 'file',
                'level' => $_ENV['LOG_LEVEL'] ?? 'debug',
                'path' => ROOT_DIR . '/logs/',
                'days' => (int) ($_ENV['LOG_DAYS'] ?? 30)
            ],

            'cache' => [
                'driver' => $_ENV['CACHE_DRIVER'] ?? 'file',
                'prefix' => $_ENV['CACHE_PREFIX'] ?? 'phpforge_',
                'path' => ROOT_DIR . '/cache/',
                'ttl' => (int) ($_ENV['CACHE_TTL'] ?? 3600)
            ],

            'rate_limiting' => [
                'enabled' => true,
                'max_requests' => (int) ($_ENV['RATE_LIMIT_PER_MINUTE'] ?? 60),
                'window' => 60, // 1 minute
                'headers' => [
                    'limit' => 'X-RateLimit-Limit',
                    'remaining' => 'X-RateLimit-Remaining',
                    'reset' => 'X-RateLimit-Reset'
                ]
            ],

            'api' => [
                'groq' => [
                    'url' => $_ENV['GROQ_API_URL'] ?? 'https://api.groq.com/v1',
                    'key' => $_ENV['GROQ_API_KEY'],
                    'timeout' => (int) ($_ENV['GROQ_API_TIMEOUT'] ?? 30),
                    'version' => '2024-02'
                ]
            ],

            'mail' => [
                'from_address' => $_ENV['MAIL_FROM_ADDRESS'] ?? 'hello@phpforge.com',
                'from_name' => $_ENV['MAIL_FROM_NAME'] ?? 'PhpForge',
                'driver' => $_ENV['MAIL_DRIVER'] ?? 'smtp',
                'host' => $_ENV['MAIL_HOST'] ?? 'smtp.mailgun.org',
                'port' => $_ENV['MAIL_PORT'] ?? 587,
                'username' => $_ENV['MAIL_USERNAME'],
                'password' => $_ENV['MAIL_PASSWORD'],
                'encryption' => $_ENV['MAIL_ENCRYPTION'] ?? 'tls'
            ],

            'storage' => [
                'driver' => $_ENV['STORAGE_DRIVER'] ?? 'local',
                'path' => ROOT_DIR . '/storage/',
                'temp' => ROOT_DIR . '/storage/temp/',
                'allowed_extensions' => ['php', 'txt', 'json', 'yml', 'yaml', 'md'],
                'max_file_size' => (int) ($_ENV['MAX_FILE_SIZE'] ?? 10 * 1024 * 1024) // 10MB
            ],

            'cors' => [
                'allowed_origins' => explode(',', $_ENV['CORS_ALLOWED_ORIGINS'] ?? '*'),
                'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
                'exposed_headers' => [],
                'max_age' => 0,
                'supports_credentials' => false
            ],

            'tools' => [
                'code_generator' => [
                    'max_tokens' => (int) ($_ENV['CODE_GEN_MAX_TOKENS'] ?? 2000),
                    'temperature' => (float) ($_ENV['CODE_GEN_TEMPERATURE'] ?? 0.7),
                    'cache_ttl' => (int) ($_ENV['CODE_GEN_CACHE_TTL'] ?? 3600)
                ],
                'debugging' => [
                    'max_file_size' => (int) ($_ENV['DEBUG_MAX_FILE_SIZE'] ?? 1 * 1024 * 1024),
                    'cache_ttl' => (int) ($_ENV['DEBUG_CACHE_TTL'] ?? 1800)
                ],
                'security' => [
                    'scan_depth' => (int) ($_ENV['SECURITY_SCAN_DEPTH'] ?? 3),
                    'cache_ttl' => (int) ($_ENV['SECURITY_CACHE_TTL'] ?? 7200)
                ],
                'performance' => [
                    'analysis_timeout' => (int) ($_ENV['PERF_ANALYSIS_TIMEOUT'] ?? 30),
                    'cache_ttl' => (int) ($_ENV['PERF_CACHE_TTL'] ?? 3600)
                ]
            ]
        ];
    }

    /**
     * Check if application is in debug mode
     */
    public static function isDebug(): bool
    {
        return filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Check if application is in production environment
     */
    public static function isProduction(): bool
    {
        return ($_ENV['APP_ENV'] ?? 'production') === 'production';
    }

    /**
     * Get application environment
     */
    public static function getEnvironment(): string
    {
        return $_ENV['APP_ENV'] ?? 'production';
    }

    /**
     * Get application URL
     */
    public static function getUrl(): string
    {
        return rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/');
    }

    /**
     * Get application timezone
     */
    public static function getTimezone(): string
    {
        return $_ENV['APP_TIMEZONE'] ?? 'UTC';
    }
}