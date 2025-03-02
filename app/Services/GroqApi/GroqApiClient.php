<?php

namespace App\Services\GroqApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GroqApiClient
{
    protected $apiKey;
    protected $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';
    protected $model = 'llama-3.3-70b-versatile';
    
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

    public function generateCode($prompt)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->baseUrl, [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a code generation assistant. Generate high-quality, well-documented code based on the requirements provided.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'model' => $this->model,
                    'temperature' => 0.7,
                    'max_completion_tokens' => 2000,
                    'top_p' => 1,
                    'stream' => false,
                    'stop' => null
                ]);
                
            if ($response->successful()) {
                $result = $response->json();
                return [
                    'choices' => [
                        [
                            'text' => $result['choices'][0]['message']['content'] ?? ''
                        ]
                    ]
                ];
            }
            
            throw new \Exception('Groq API request failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Groq API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function analyzeSecurity($code)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post($this->baseUrl, [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a security analysis assistant. Analyze the provided code for security vulnerabilities and best practices.'
                        ],
                        [
                            'role' => 'user',
                            'content' => "Please analyze this code for security issues:\n\n$code"
                        ]
                    ],
                    'model' => $this->model,
                    'temperature' => 0.3,
                    'max_completion_tokens' => 1000
                ]);

            if ($response->successful()) {
                return [
                    'analysis' => $response->json()['choices'][0]['message']['content'] ?? ''
                ];
            }

            throw new \Exception('Security analysis failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Security Analysis Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function debugCode($code)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post($this->baseUrl, [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a code debugging assistant. Analyze the code and provide output in JSON format following the specified structure.'
                        ],
                        [
                            'role' => 'user',
                            'content' => "Analyze the following code and provide results in JSON format:\n\n" . 
                                "```php\n$code\n```\n\n" .
                                "Return the analysis in this exact JSON structure:\n" .
                                "[\n" .
                                "  {\n" .
                                "    \"severity\": \"error|warning|info|success\",\n" .
                                "    \"title\": \"Issue title\",\n" .
                                "    \"message\": \"Detailed explanation\",\n" .
                                "    \"suggestion\": \"How to fix it (optional)\",\n" .
                                "    \"code\": \"Example code snippet (optional)\"\n" .
                                "  }\n" .
                                "]\n\n" .
                                "Return ONLY the JSON array, no additional text or explanations."
                        ]
                    ],
                    'model' => $this->model,
                    'temperature' => 0.3,
                    'max_completion_tokens' => 1000
                ]);

            if ($response->successful()) {
                return [
                    'analysis' => $response->json()['choices'][0]['message']['content'] ?? ''
                ];
            }

            throw new \Exception('Debug analysis failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Debug Analysis Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function optimizePerformance($code)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post($this->baseUrl, [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a performance optimization assistant. Analyze the code for performance improvements.'
                        ],
                        [
                            'role' => 'user',
                            'content' => "Please analyze this code for performance optimization:\n\n$code"
                        ]
                    ],
                    'model' => $this->model,
                    'temperature' => 0.3,
                    'max_completion_tokens' => 1000
                ]);

            if ($response->successful()) {
                return [
                    'analysis' => $response->json()['choices'][0]['message']['content'] ?? ''
                ];
            }

            throw new \Exception('Performance analysis failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Performance Analysis Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function generateDocumentation($code)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post($this->baseUrl, [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a documentation generation assistant. Generate comprehensive documentation for the provided code.'
                        ],
                        [
                            'role' => 'user',
                            'content' => "Please generate documentation for this code:\n\n$code"
                        ]
                    ],
                    'model' => $this->model,
                    'temperature' => 0.3,
                    'max_completion_tokens' => 1000
                ]);

            if ($response->successful()) {
                return [
                    'documentation' => $response->json()['choices'][0]['message']['content'] ?? ''
                ];
            }

            throw new \Exception('Documentation generation failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Documentation Generation Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
