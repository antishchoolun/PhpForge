<?php

namespace PhpForge\Services;

use PhpForge\Core\Service;
use Exception;

abstract class BaseToolService extends Service
{
    /**
     * @var string The name of the tool
     */
    protected $toolName;

    /**
     * @var array The tool configuration
     */
    protected $config;

    /**
     * @var int Maximum retries for API calls
     */
    protected $maxRetries = 3;

    /**
     * Create a new tool service instance
     */
    public function __construct()
    {
        parent::__construct();
        $this->config = $this->app->service('config')->get('tools');
    }

    /**
     * Process the tool request
     */
    public function process(array $input): array
    {
        try {
            // Check rate limits
            $this->checkRateLimit();

            // Get cached response if available
            $cacheKey = $this->generateCacheKey($this->toolName, $input);
            $cached = $this->getCachedResponse($cacheKey);
            
            if ($cached !== null) {
                return $cached;
            }

            // Process the request
            $startTime = microtime(true);
            $result = $this->processRequest($input);
            $executionTime = microtime(true) - $startTime;

            // Log the tool usage
            $this->logToolUsage($input, $result, $executionTime);

            // Cache the response
            $this->cacheResponse($cacheKey, $result, $this->getCacheTtl());

            return $result;
        } catch (Exception $e) {
            $this->logError($e, $input);
            throw $e;
        }
    }

    /**
     * Process the actual tool request
     * This method should be implemented by specific tool services
     */
    abstract protected function processRequest(array $input): array;

    /**
     * Validate tool input
     * This method should be implemented by specific tool services
     */
    abstract protected function validateInput(array $input): void;

    /**
     * Get cache TTL for this tool
     */
    protected function getCacheTtl(): int
    {
        return $this->config[$this->toolName]['cache_ttl'] ?? 3600;
    }

    /**
     * Format the tool response
     */
    protected function formatResponse(array $data): array
    {
        return [
            'success' => true,
            'data' => $data,
            'tool' => $this->toolName,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * Log tool usage
     */
    protected function logToolUsage(array $input, array $output, float $executionTime): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        $this->db->insert('tool_logs', [
            'user_id' => $userId,
            'tool_name' => $this->toolName,
            'input_data' => json_encode($input),
            'output_data' => json_encode($output),
            'execution_time' => $executionTime,
            'status' => 'success'
        ]);
    }

    /**
     * Log error
     */
    protected function logError(Exception $e, array $input): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        $this->db->insert('tool_logs', [
            'user_id' => $userId,
            'tool_name' => $this->toolName,
            'input_data' => json_encode($input),
            'error_message' => $e->getMessage(),
            'status' => 'error'
        ]);
    }

    /**
     * Make API request with retry logic
     */
    protected function makeApiRequestWithRetry(string $endpoint, array $data, int $retries = 0): array
    {
        try {
            return $this->makeRequest($endpoint, 'POST', $data);
        } catch (Exception $e) {
            if ($retries < $this->maxRetries && $this->shouldRetry($e)) {
                sleep(pow(2, $retries)); // Exponential backoff
                return $this->makeApiRequestWithRetry($endpoint, $data, $retries + 1);
            }
            throw $e;
        }
    }

    /**
     * Determine if request should be retried
     */
    protected function shouldRetry(Exception $e): bool
    {
        $retryableCodes = [408, 429, 500, 502, 503, 504];
        return in_array($e->getCode(), $retryableCodes);
    }

    /**
     * Check if user has access to this tool
     */
    protected function checkAccess(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            throw new Exception('Authentication required', 401);
        }

        $user = (new \PhpForge\Models\User())->getUserWithSubscription($userId);
        if (!$user['has_active_subscription']) {
            throw new Exception('Subscription required to use this tool', 403);
        }
    }

    /**
     * Generate cache key for tool request
     */
    protected function generateCacheKey(string $tool, array $input): string
    {
        $userId = $_SESSION['user_id'] ?? 'anonymous';
        return "tool:{$tool}:user:{$userId}:" . md5(json_encode($input));
    }

    /**
     * Clean sensitive data from input
     */
    protected function cleanSensitiveData(array $data): array
    {
        $sensitiveKeys = ['password', 'token', 'secret', 'key'];
        
        array_walk_recursive($data, function (&$value, $key) use ($sensitiveKeys) {
            if (in_array(strtolower($key), $sensitiveKeys)) {
                $value = '********';
            }
        });

        return $data;
    }

    /**
     * Format error response
     */
    protected function formatError(Exception $e): array
    {
        return [
            'success' => false,
            'error' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ],
            'tool' => $this->toolName,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
}