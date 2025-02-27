<?php

namespace PhpForge\Controllers;

use PhpForge\Core\Controller;
use PhpForge\Models\User;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     * @var User
     */
    private $userModel;

    /**
     * Create a new AuthController instance
     */
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Handle login request
     */
    public function login(): void
    {
        if ($this->request['method'] !== 'POST') {
            $this->error('Method not allowed', 405);
        }

        $data = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = $this->userModel->findByEmail($data['email']);

        if (!$user || !$this->userModel->verifyPassword($user, $data['password'])) {
            $this->error('Invalid credentials', 401);
        }

        // Check if email is verified
        if (!$user['email_verified_at']) {
            $this->error('Please verify your email address', 403);
        }

        // Update last login
        $this->userModel->updateLastLogin($user['id']);

        // Generate JWT token
        $token = $this->generateJwtToken($user);

        // Set remember token if requested
        if (!empty($data['remember'])) {
            $rememberToken = bin2hex(random_bytes(32));
            $this->userModel->updateRememberToken($user['id'], $rememberToken);
            setcookie('remember_token', $rememberToken, time() + 30 * 24 * 60 * 60, '/', '', true, true);
        }

        $this->success([
            'token' => $token,
            'user' => array_diff_key($user, array_flip(['password_hash', 'remember_token']))
        ]);
    }

    /**
     * Handle registration request
     */
    public function register(): void
    {
        if ($this->request['method'] !== 'POST') {
            $this->error('Method not allowed', 405);
        }

        $data = $this->validate([
            'name' => 'required|min:2|max:100',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required'
        ]);

        // Check if passwords match
        if ($data['password'] !== $data['password_confirmation']) {
            $this->error('Passwords do not match', 422);
        }

        // Check if email already exists
        if ($this->userModel->findByEmail($data['email'])) {
            $this->error('Email already registered', 422);
        }

        // Create user
        $userId = $this->userModel->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if (!$userId) {
            $this->error('Failed to create account', 500);
        }

        // Send verification email
        $this->sendVerificationEmail($data['email']);

        $this->success([
            'message' => 'Registration successful. Please check your email to verify your account.'
        ], 201);
    }

    /**
     * Handle logout request
     */
    public function logout(): void
    {
        if ($this->request['method'] !== 'POST') {
            $this->error('Method not allowed', 405);
        }

        $token = $this->getBearerToken();
        if (!$token) {
            $this->error('Unauthorized', 401);
        }

        try {
            $payload = JWT::decode($token, $_ENV['JWT_SECRET'], ['HS256']);
            $this->userModel->updateRememberToken($payload->sub, null);
        } catch (\Exception $e) {
            // Token is invalid, but we'll still clear cookies
        }

        // Clear cookies
        setcookie('remember_token', '', time() - 3600, '/', '', true, true);

        $this->success(['message' => 'Successfully logged out']);
    }

    /**
     * Handle password reset request
     */
    public function forgotPassword(): void
    {
        if ($this->request['method'] !== 'POST') {
            $this->error('Method not allowed', 405);
        }

        $data = $this->validate([
            'email' => 'required|email'
        ]);

        $user = $this->userModel->findByEmail($data['email']);
        if (!$user) {
            // Don't reveal that the email doesn't exist
            $this->success([
                'message' => 'If your email address exists in our database, you will receive a password recovery link.'
            ]);
        }

        // Generate reset token
        $token = bin2hex(random_bytes(32));
        
        // Store token in database
        $this->db->insert('password_resets', [
            'email' => $data['email'],
            'token' => $token
        ]);

        // Send password reset email
        $this->sendPasswordResetEmail($data['email'], $token);

        $this->success([
            'message' => 'Password reset instructions have been sent to your email.'
        ]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(): void
    {
        if ($this->request['method'] !== 'POST') {
            $this->error('Method not allowed', 405);
        }

        $data = $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required'
        ]);

        if ($data['password'] !== $data['password_confirmation']) {
            $this->error('Passwords do not match', 422);
        }

        // Verify token
        $reset = $this->db->fetch(
            "SELECT * FROM password_resets 
            WHERE email = ? AND token = ? 
            AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)",
            [$data['email'], $data['token']]
        );

        if (!$reset) {
            $this->error('Invalid or expired password reset token', 400);
        }

        $user = $this->userModel->findByEmail($data['email']);
        if (!$user) {
            $this->error('User not found', 404);
        }

        // Update password
        $this->userModel->updatePassword($user['id'], $data['password']);

        // Delete used token
        $this->db->delete('password_resets', 'email = ?', [$data['email']]);

        $this->success([
            'message' => 'Password has been reset successfully.'
        ]);
    }

    /**
     * Generate JWT token for user
     */
    private function generateJwtToken(array $user): string
    {
        $payload = [
            'sub' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'iat' => time(),
            'exp' => time() + (int) $_ENV['JWT_EXPIRATION']
        ];

        return JWT::encode($payload, $_ENV['JWT_SECRET']);
    }

    /**
     * Get bearer token from authorization header
     */
    private function getBearerToken(): ?string
    {
        $header = $this->request['headers']['Authorization'] ?? null;
        if (!$header || !preg_match('/Bearer\s+(.+)/', $header, $matches)) {
            return null;
        }
        return $matches[1];
    }

    /**
     * Send verification email
     */
    private function sendVerificationEmail(string $email): void
    {
        // In a real application, implement email sending logic
        // For now, we'll just log it
        error_log("Verification email would be sent to: {$email}");
    }

    /**
     * Send password reset email
     */
    private function sendPasswordResetEmail(string $email, string $token): void
    {
        // In a real application, implement email sending logic
        // For now, we'll just log it
        error_log("Password reset email would be sent to: {$email} with token: {$token}");
    }
}