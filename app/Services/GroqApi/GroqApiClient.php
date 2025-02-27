<?php

namespace App\Services\GroqApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GroqApiClient
{
    protected $apiKey;
    protected $baseUrl = 'https://api.groq.com/openai/v1/chat';
    
    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
    }

    protected function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];
    }

    protected function makeRequest($endpoint, $data, $method = 'POST')
    {
        $cacheKey = 'groq_' . md5($endpoint . json_encode($data));
        
        // Check cache first for GET requests
        if ($method === 'GET' && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->$method($this->baseUrl . $endpoint, $data);
                
            if ($response->successful()) {
                $result = $response->json();
                
                // Cache successful GET requests
                if ($method === 'GET') {
                    Cache::put($cacheKey, $result, now()->addMinutes(60));
                }
                
                return $result;
            }
            
            throw new \Exception('Groq API request failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Groq API Error: ' . $e->getMessage(), [
                'endpoint' => $endpoint,
                'data' => $data
            ]);
            throw $e;
        }
    }

    public function generateCode($prompt)
    {
        return $this->makeRequest('/completions', [
            'prompt' => $prompt,
            'max_tokens' => 2000,
            'temperature' => 0.7,
        ]);
    }

    public function analyzeSecurity($code)
    {
        return $this->makeRequest('/analyze/security', [
            'code' => $code,
        ]);
    }

    public function debugCode($code)
    {
        return $this->makeRequest('/analyze/debug', [
            'code' => $code,
        ]);
    }

    public function optimizePerformance($code)
    {
        return $this->makeRequest('/analyze/performance', [
            'code' => $code,
        ]);
    }

    public function generateDocumentation($code)
    {
        return $this->makeRequest('/generate/documentation', [
            'code' => $code,
        ]);
    }

    public function evaluateDomain($domain)
    {
        return $this->makeRequest('/evaluate/domain', [
            'domain' => $domain,
        ]);
    }
}