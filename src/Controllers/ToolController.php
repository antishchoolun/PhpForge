<?php

namespace PhpForge\Controllers;

use PhpForge\Core\Controller;
use PhpForge\Services\CodeGeneratorService;
use Exception;

class ToolController extends Controller
{
    /**
     * @var array Tool service mapping
     */
    private $services = [
        'generate' => CodeGeneratorService::class,
        // Other tools will be added here as they are implemented
        // 'debug' => DebugService::class,
        // 'security' => SecurityService::class,
        // 'optimize' => OptimizationService::class,
        // 'document' => DocumentationService::class,
        // 'evaluate' => DomainValuationService::class
    ];

    /**
     * Handle code generation requests
     */
    public function generate(): void
    {
        $this->handleToolRequest('generate');
    }

    /**
     * Handle debugging requests
     */
    public function debug(): void
    {
        $this->handleToolRequest('debug');
    }

    /**
     * Handle security analysis requests
     */
    public function security(): void
    {
        $this->handleToolRequest('security');
    }

    /**
     * Handle optimization requests
     */
    public function optimize(): void
    {
        $this->handleToolRequest('optimize');
    }

    /**
     * Handle documentation generation requests
     */
    public function document(): void
    {
        $this->handleToolRequest('document');
    }

    /**
     * Handle domain valuation requests
     */
    public function evaluate(): void
    {
        $this->handleToolRequest('evaluate');
    }

    /**
     * Generic handler for tool requests
     */
    protected function handleToolRequest(string $tool): void
    {
        if ($this->request['method'] !== 'POST') {
            $this->error('Method not allowed', 405);
        }

        try {
            // Check if tool exists
            if (!isset($this->services[$tool])) {
                throw new Exception("Tool '{$tool}' not found", 404);
            }

            // Check authentication
            $this->checkAuth();

            // Get service class
            $serviceClass = $this->services[$tool];
            
            // Create service instance
            $service = new $serviceClass();

            // Process the request
            $result = $service->process($this->getRequestData());

            $this->success($result);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    /**
     * Check if user is authenticated
     */
    private function checkAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('Authentication required', 401);
        }

        // Check if user has an active subscription
        $user = (new \PhpForge\Models\User())->getUserWithSubscription($_SESSION['user_id']);
        
        if (!$user || !$user['has_active_subscription']) {
            throw new Exception('Active subscription required to use this tool', 403);
        }
    }

    /**
     * Get request data
     */
    private function getRequestData(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') !== false) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON payload', 400);
            }
            
            return $data;
        }
        
        return $_POST;
    }

    /**
     * Handle error response
     */
    private function handleError(Exception $e): void
    {
        $code = $e->getCode();
        
        // Ensure valid HTTP status code
        if ($code < 100 || $code > 599) {
            $code = 500;
        }

        // Log error if it's a server error
        if ($code >= 500) {
            error_log("[Tool Error] {$e->getMessage()}\n{$e->getTraceAsString()}");
        }

        $this->error($e->getMessage(), $code);
    }

    /**
     * Get tool usage statistics
     */
    public function getStats(): void
    {
        try {
            $this->checkAuth();

            $userId = $_SESSION['user_id'];
            $stats = $this->db->fetchAll(
                "SELECT 
                    tool_name,
                    COUNT(*) as total_uses,
                    AVG(execution_time) as avg_execution_time,
                    COUNT(CASE WHEN status = 'error' THEN 1 END) as errors,
                    DATE_FORMAT(MAX(created_at), '%Y-%m-%d %H:%i:%s') as last_used
                FROM tool_logs 
                WHERE user_id = ? 
                AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                GROUP BY tool_name",
                [$userId]
            );

            $this->success(['stats' => $stats]);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    /**
     * Get tool usage history
     */
    public function getHistory(): void
    {
        try {
            $this->checkAuth();

            $data = $this->validate([
                'tool' => 'required',
                'page' => 'required|numeric',
                'limit' => 'required|numeric'
            ]);

            $userId = $_SESSION['user_id'];
            $offset = ($data['page'] - 1) * $data['limit'];

            $history = $this->db->fetchAll(
                "SELECT 
                    id,
                    tool_name,
                    input_data,
                    output_data,
                    execution_time,
                    status,
                    error_message,
                    created_at
                FROM tool_logs 
                WHERE user_id = ? 
                AND tool_name = ?
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?",
                [$userId, $data['tool'], $data['limit'], $offset]
            );

            // Get total count for pagination
            $total = $this->db->fetch(
                "SELECT COUNT(*) as count 
                FROM tool_logs 
                WHERE user_id = ? AND tool_name = ?",
                [$userId, $data['tool']]
            );

            $this->success([
                'history' => $history,
                'total' => (int) $total['count'],
                'page' => (int) $data['page'],
                'limit' => (int) $data['limit']
            ]);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }
}