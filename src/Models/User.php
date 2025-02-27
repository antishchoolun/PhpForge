<?php

namespace PhpForge\Models;

use PhpForge\Core\Model;

class User extends Model
{
    /**
     * The table associated with the model
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'name',
        'email',
        'password_hash'
    ];

    /**
     * The attributes that should be hidden
     */
    protected $hidden = [
        'password_hash',
        'remember_token'
    ];

    /**
     * Find a user by their email
     */
    public function findByEmail(string $email): ?array
    {
        return $this->firstWhere('email', $email);
    }

    /**
     * Find a user by their remember token
     */
    public function findByRememberToken(string $token): ?array
    {
        return $this->firstWhere('remember_token', $token);
    }

    /**
     * Create a new user
     */
    public function createUser(array $data): ?int
    {
        $data['password_hash'] = password_hash(
            $data['password'],
            PASSWORD_ARGON2ID
        );

        unset($data['password']);
        
        return $this->create($data);
    }

    /**
     * Update user's password
     */
    public function updatePassword(int $userId, string $password): bool
    {
        return $this->update($userId, [
            'password_hash' => password_hash($password, PASSWORD_ARGON2ID)
        ]) > 0;
    }

    /**
     * Verify user's password
     */
    public function verifyPassword(array $user, string $password): bool
    {
        return password_verify($password, $user['password_hash']);
    }

    /**
     * Update remember token
     */
    public function updateRememberToken(int $userId, ?string $token): bool
    {
        return $this->update($userId, [
            'remember_token' => $token
        ]) > 0;
    }

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified(int $userId): bool
    {
        return $this->update($userId, [
            'email_verified_at' => date('Y-m-d H:i:s')
        ]) > 0;
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(int $userId): bool
    {
        return $this->update($userId, [
            'last_login_at' => date('Y-m-d H:i:s')
        ]) > 0;
    }

    /**
     * Get user's subscription
     */
    public function getSubscription(int $userId): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM subscriptions 
            WHERE user_id = ? 
            AND status = 'active' 
            AND (ends_at IS NULL OR ends_at > NOW())",
            [$userId]
        );
    }

    /**
     * Get user's tool usage for the current month
     */
    public function getToolUsage(int $userId): array
    {
        return $this->db->fetchAll(
            "SELECT tool_name, COUNT(*) as count 
            FROM tool_logs 
            WHERE user_id = ? 
            AND created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')
            GROUP BY tool_name",
            [$userId]
        );
    }

    /**
     * Get user's blog posts
     */
    public function getBlogPosts(int $userId, int $limit = 10): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM blog_posts 
            WHERE author_id = ? 
            ORDER BY created_at DESC 
            LIMIT ?",
            [$userId, $limit]
        );
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription(int $userId): bool
    {
        return $this->getSubscription($userId) !== null;
    }

    /**
     * Get user's API request count for the current minute
     */
    public function getApiRequestCount(int $userId): int
    {
        $result = $this->db->fetch(
            "SELECT COUNT(*) as count 
            FROM api_requests 
            WHERE user_id = ? 
            AND request_time >= DATE_SUB(NOW(), INTERVAL 1 MINUTE)",
            [$userId]
        );

        return (int) ($result['count'] ?? 0);
    }

    /**
     * Log an API request
     */
    public function logApiRequest(int $userId, string $endpoint, string $ipAddress): void
    {
        $this->db->insert('api_requests', [
            'user_id' => $userId,
            'endpoint' => $endpoint,
            'ip_address' => $ipAddress
        ]);
    }

    /**
     * Get user with active subscription validation
     */
    public function getUserWithSubscription(int $userId): ?array
    {
        $user = $this->find($userId);
        
        if (!$user) {
            return null;
        }

        $subscription = $this->getSubscription($userId);
        $user['has_active_subscription'] = $subscription !== null;
        $user['subscription'] = $subscription;

        return $user;
    }
}