<?php

namespace PhpForge\Config;

class Database
{
    /**
     * Get database configuration
     */
    public static function getConfig(): array
    {
        return [
            'driver' => $_ENV['DB_CONNECTION'] ?? 'mysql',
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'port' => $_ENV['DB_PORT'] ?? '3306',
            'database' => $_ENV['DB_DATABASE'] ?? 'phpforge',
            'username' => $_ENV['DB_USERNAME'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'options' => [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
            ],
            'pool' => [
                'min_connections' => 1,
                'max_connections' => 10,
                'connect_timeout' => 10.0,
                'wait_timeout' => 3.0,
                'heartbeat' => -1,
                'max_idle_time' => (float) ($_ENV['DB_MAX_IDLE_TIME'] ?? 60)
            ],
            'migration' => [
                'path' => ROOT_DIR . '/database/migrations',
                'table' => 'migrations'
            ],
            'redis' => [
                'client' => 'phpredis',
                'default' => [
                    'host' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
                    'password' => $_ENV['REDIS_PASSWORD'] ?? null,
                    'port' => $_ENV['REDIS_PORT'] ?? 6379,
                    'database' => $_ENV['REDIS_DB'] ?? 0,
                ]
            ],
            'cache' => [
                'prefix' => 'phpforge_db_',
                'ttl' => 3600
            ],
            'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'timezone' => $_ENV['APP_TIMEZONE'] ?? 'UTC'
        ];
    }

    /**
     * Get PDO DSN string
     */
    public static function getDsn(array $config): string
    {
        $driver = $config['driver'] ?? 'mysql';
        $host = $config['host'] ?? 'localhost';
        $port = $config['port'] ?? '3306';
        $database = $config['database'];
        $charset = $config['charset'] ?? 'utf8mb4';

        return sprintf(
            '%s:host=%s;port=%s;dbname=%s;charset=%s',
            $driver,
            $host,
            $port,
            $database,
            $charset
        );
    }

    /**
     * Check if database configuration is valid
     */
    public static function validateConfig(array $config): bool
    {
        $required = ['driver', 'host', 'database', 'username'];
        
        foreach ($required as $field) {
            if (empty($config[$field])) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get connection options merged with defaults
     */
    public static function getOptions(array $config): array
    {
        $defaults = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false
        ];

        return array_merge(
            $defaults,
            $config['options'] ?? []
        );
    }

    /**
     * Test database connection
     */
    public static function testConnection(array $config): bool
    {
        try {
            $dsn = self::getDsn($config);
            $options = self::getOptions($config);

            $pdo = new \PDO(
                $dsn,
                $config['username'],
                $config['password'] ?? '',
                $options
            );

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}