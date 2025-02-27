<?php

namespace PhpForge\Core;

use PDO;
use PDOException;

class Database
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * @var array The database configuration
     */
    private $config;

    /**
     * @var bool Whether to throw exceptions on error
     */
    private $throwErrors = true;

    /**
     * Debug log helper
     */
    private function debug($message, $data = null): void
    {
        if (function_exists('debug')) {
            debug($message, $data);
        } elseif (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG']) {
            error_log($message . ($data ? ': ' . print_r($data, true) : ''));
        }
    }

    /**
     * Create a new Database instance
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->connect();
    }

    /**
     * Connect to the database
     */
    private function connect(): void
    {
        try {
            $this->debug('Connecting to database', [
                'host' => $this->config['host'],
                'dbname' => $this->config['dbname']
            ]);

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $this->config['host'],
                $this->config['dbname']
            );

            $this->connection = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
                ]
            );

            $this->debug('Database connection successful');
        } catch (PDOException $e) {
            $this->debug('Database connection failed', ['error' => $e->getMessage()]);
            throw new PDOException('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Execute a query and return the statement
     */
    private function execute(string $query, array $params = []): \PDOStatement
    {
        try {
            $this->debug('Executing query', [
                'query' => $query,
                'params' => $params
            ]);

            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            $this->debug('Query execution failed', [
                'error' => $e->getMessage(),
                'query' => $query,
                'params' => $params
            ]);

            if ($this->throwErrors) {
                throw $e;
            }

            return false;
        }
    }

    /**
     * Fetch a single row
     */
    public function fetch(string $query, array $params = []): ?array
    {
        $stmt = $this->execute($query, $params);
        $result = $stmt ? $stmt->fetch() : null;
        
        $this->debug('Fetch result', [
            'query' => $query,
            'params' => $params,
            'result' => $result
        ]);

        return $result ?: null;
    }

    /**
     * Fetch all rows
     */
    public function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->execute($query, $params);
        $results = $stmt ? $stmt->fetchAll() : [];
        
        $this->debug('FetchAll result', [
            'query' => $query,
            'params' => $params,
            'count' => count($results)
        ]);

        return $results;
    }

    /**
     * Insert a new row
     */
    public function insert(string $table, array $data): ?int
    {
        $fields = array_keys($data);
        $values = array_values($data);
        $placeholders = str_repeat('?,', count($fields) - 1) . '?';

        $query = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(', ', $fields),
            $placeholders
        );

        $this->execute($query, $values);
        return (int) $this->connection->lastInsertId();
    }

    /**
     * Update existing rows
     */
    public function update(string $table, array $data, string $where, array $params = []): int
    {
        $set = [];
        $values = [];

        foreach ($data as $field => $value) {
            $set[] = "$field = ?";
            $values[] = $value;
        }

        $query = sprintf(
            'UPDATE %s SET %s WHERE %s',
            $table,
            implode(', ', $set),
            $where
        );

        $stmt = $this->execute($query, array_merge($values, $params));
        return $stmt ? $stmt->rowCount() : 0;
    }

    /**
     * Delete rows
     */
    public function delete(string $table, string $where, array $params = []): int
    {
        $query = sprintf('DELETE FROM %s WHERE %s', $table, $where);
        $stmt = $this->execute($query, $params);
        return $stmt ? $stmt->rowCount() : 0;
    }

    /**
     * Begin a transaction
     */
    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commit a transaction
     */
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * Rollback a transaction
     */
    public function rollback(): bool
    {
        return $this->connection->rollBack();
    }

    /**
     * Set whether to throw errors
     */
    public function setThrowErrors(bool $throw): void
    {
        $this->throwErrors = $throw;
    }

    /**
     * Get the PDO instance
     */
    public function getPdo(): PDO
    {
        return $this->connection;
    }
}