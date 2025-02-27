<?php

namespace PhpForge\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;

abstract class Service
{
    /**
     * @var Client The HTTP client
     */
    protected $client;

    /**
     * @var string The Groq API key
     */
    protected $apiKey;

    /**
     * @var string The Groq API base URL
     */
    protected $apiUrl;

    /**
     * @var App Application instance
     */
    protected $app;

    /**
     * Create a new service instance
     */
    public function __construct()
    {
        $this->app = App::getInstance();
        $this->apiKey = $_ENV['GROQ_API_KEY'];
        $this->apiUrl = $_ENV['GROQ_API_URL'];

        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'timeout' => 30,
            'http_errors' => false
        ]);
    }

    /**
     * Make a request to the Groq API
     */
    protected function makeRequest(string $endpoint, string $method = 'POST', array $data = []): array
    {
        try {
            $response = $this->client->request($method, $endpoint, [
                'json' => $data
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode !== 200) {
                throw new Exception(
                    $body['error']['message'] ?? 'API request failed',
                    $statusCode
                );
            }

            return $body;
        } catch (GuzzleException $e) {
            throw new Exception("API request failed: " . $e->getMessage());
        }
    }

    /**
     * Log an API request
     */
    protected function logApiRequest(string $tool, array $input, array $output): void
    {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        $this->app->service('db')->insert('tool_logs', [
            'user_id' => $userId,
            'tool_name' => $tool,
            'input_data' => json_encode($input),
            'output_data' => json_encode($output),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Check rate limits for a user
     */
    protected function checkRateLimit(): void
    {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'anonymous';
        $limit = (int) $_ENV['RATE_LIMIT_PER_MINUTE'];
        
        $db = $this->app->service('db');
        
        // Count requests in the last minute
        $count = $db->fetch(
            "SELECT COUNT(*) as count FROM api_requests 
            WHERE user_id = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 MINUTE)",
            [$userId]
        );

        if ((int) $count['count'] >= $limit) {
            throw new Exception("Rate limit exceeded. Please try again later.", 429);
        }

        // Log the request
        $db->insert('api_requests', [
            'user_id' => $userId,
            'endpoint' => $_SERVER['REQUEST_URI'],
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Format error message for client
     */
    protected function formatError(Exception $e): array
    {
        return [
            'success' => false,
            'message' => $e->getMessage(),
            'code' => $e->getCode() ?: 500
        ];
    }

    /**
     * Format success response
     */
    protected function formatSuccess($data): array
    {
        return [
            'success' => true,
            'data' => $data
        ];
    }

    /**
     * Get cached response if available
     */
    protected function getCachedResponse(string $key)
    {
        $cache = $this->app->service('cache');
        $item = $cache->getItem($key);
        
        return $item->isHit() ? $item->get() : null;
    }

    /**
     * Cache a response
     */
    protected function cacheResponse(string $key, $data, int $ttl = 3600): void
    {
        $cache = $this->app->service('cache');
        $item = $cache->getItem($key);
        
        $item->set($data);
        $item->expiresAfter($ttl);
        
        $cache->save($item);
    }

    /**
     * Generate cache key
     */
    protected function generateCacheKey(string $prefix, array $params): string
    {
        return $prefix . '_' . md5(json_encode($params));
    }
}