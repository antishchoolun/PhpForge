<?php

namespace PhpForge\Core;

use PDO;

abstract class Model
{
    /**
     * @var Database
     */
    protected $db;

    /**
     * @var string The table associated with the model
     */
    protected $table;

    /**
     * @var string The primary key of the table
     */
    protected $primaryKey = 'id';

    /**
     * @var array The model's fillable attributes
     */
    protected $fillable = [];

    /**
     * @var array The model's hidden attributes
     */
    protected $hidden = [];

    /**
     * Create a new model instance
     */
    public function __construct()
    {
        $this->db = App::getInstance()->service('db');
        
        if (empty($this->table)) {
            // Convert CamelCase to snake_case for table name
            $this->table = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', basename(str_replace('\\', '/', get_class($this)))));
        }
    }

    /**
     * Find a record by its primary key
     */
    public function find($id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        );
    }

    /**
     * Get all records
     */
    public function all(): array
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table}");
    }

    /**
     * Create a new record
     */
    public function create(array $data): int
    {
        $data = $this->filterFillableFields($data);
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update a record
     */
    public function update($id, array $data): int
    {
        $data = $this->filterFillableFields($data);
        return $this->db->update(
            $this->table,
            $data,
            "{$this->primaryKey} = ?",
            [$id]
        );
    }

    /**
     * Delete a record
     */
    public function delete($id): int
    {
        return $this->db->delete(
            $this->table,
            "{$this->primaryKey} = ?",
            [$id]
        );
    }

    /**
     * Find records by a where clause
     */
    public function where(string $column, $value, string $operator = '='): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?",
            [$value]
        );
    }

    /**
     * Find first record by a where clause
     */
    public function firstWhere(string $column, $value, string $operator = '='): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?",
            [$value]
        );
    }

    /**
     * Filter array to only include fillable fields
     */
    protected function filterFillableFields(array $data): array
    {
        if (empty($this->fillable)) {
            return $data;
        }

        return array_intersect_key($data, array_flip($this->fillable));
    }

    /**
     * Remove hidden fields from array
     */
    protected function removeHiddenFields(array $data): array
    {
        return array_diff_key($data, array_flip($this->hidden));
    }

    /**
     * Begin a transaction
     */
    public function beginTransaction(): bool
    {
        return $this->db->beginTransaction();
    }

    /**
     * Commit the transaction
     */
    public function commit(): bool
    {
        return $this->db->commit();
    }

    /**
     * Rollback the transaction
     */
    public function rollBack(): bool
    {
        return $this->db->rollBack();
    }

    /**
     * Get the raw PDO instance
     */
    public function getPdo(): PDO
    {
        return $this->db->getConnection();
    }

    /**
     * Execute a raw query
     */
    public function raw(string $sql, array $params = []): array
    {
        return $this->db->fetchAll($sql, $params);
    }

    /**
     * Count records in the table
     */
    public function count(string $column = '*'): int
    {
        $result = $this->db->fetch("SELECT COUNT({$column}) as count FROM {$this->table}");
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get records with pagination
     */
    public function paginate(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        $total = $this->count();
        
        $items = $this->db->fetchAll(
            "SELECT * FROM {$this->table} LIMIT ? OFFSET ?",
            [$perPage, $offset]
        );

        return [
            'data' => $items,
            'meta' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => ceil($total / $perPage)
            ]
        ];
    }
}