<?php

namespace PhpForge\Core;

use PDO;
use PDOException;
use Exception;

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
     * @var array Active transactions count
     */
    private $transactionCount = 0;

    /**
     * Create a new database connection
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
            $dsn = sprintf(
                "mysql:host=%s;dbname=%s;charset=utf8mb4",
                $this->config['host'],
                $this->config['dbname']
            );

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                $options
            );
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Begin a transaction
     */
    public function beginTransaction(): bool
    {
        if ($this->transactionCount === 0) {
            $this->connection->beginTransaction();
        }
        $this->transactionCount++;
        
        return true;
    }

    /**
     * Commit the transaction
     */
    public function commit(): bool
    {
        $this->transactionCount--;
        
        if ($this->transactionCount === 0) {
            return $this->connection->commit();
        }
        
        return true;
    }

    /**
     * Rollback the transaction
     */
    public function rollBack(): bool
    {
        if ($this->transactionCount > 0) {
            $this->transactionCount = 0;
            return $this->connection->rollBack();
        }
        
        return false;
    }

    /**
     * Execute a query and return the statement
     */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Query failed: " . $e->getMessage());
        }
    }

    /**
     * Fetch all results from a query
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Fetch a single row from a query
     */
    public function fetch(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();
        return $result !== false ? $result : null;
    }

    /**
     * Insert a row and return the last inserted ID
     */
    public function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        
        $this->query($sql, array_values($data));
        return (int) $this->connection->lastInsertId();
    }

    /**
     * Update rows in a table
     */
    public function update(string $table, array $data, string $where, array $params = []): int
    {
        $set = implode(', ', array_map(function ($column) {
            return "{$column} = ?";
        }, array_keys($data)));
        
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        
        $stmt = $this->query($sql, array_merge(array_values($data), $params));
        return $stmt->rowCount();
    }

    /**
     * Delete rows from a table
     */
    public function delete(string $table, string $where, array $params = []): int
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Get the database connection
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Quote a value
     */
    public function quote($value): string
    {
        return $this->connection->quote($value);
    }

    /**
     * Get the last insert ID
     */
    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}