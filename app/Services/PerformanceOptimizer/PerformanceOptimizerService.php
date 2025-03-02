<?php

namespace App\Services\PerformanceOptimizer;

use App\Services\GroqApi\GroqApiClient;
use Illuminate\Support\Facades\Log;

class PerformanceOptimizerService
{
    protected $groqApi;

    public function __construct(GroqApiClient $groqApi)
    {
        $this->groqApi = $groqApi;
    }

    public function analyzePerformance(string $code, array $optimizations = [], string $environment = 'staging')
    {
        try {
            // Build analysis prompt with selected optimizations
            $prompt = $this->buildPerformancePrompt($code, $optimizations, $environment);
            
            // Get AI analysis
            $result = $this->groqApi->optimizePerformance($prompt);
            
            // Parse the response
            $issues = $this->parsePerformanceResponse($result['analysis']);
            
            // Calculate summary
            $summary = $this->calculateSummary($issues);
            
            return [
                'success' => true,
                'issues' => $issues,
                'summary' => $summary
            ];

        } catch (\Exception $e) {
            Log::error('Performance analysis error: ' . $e->getMessage(), [
                'code' => $code,
                'optimizations' => $optimizations,
                'environment' => $environment
            ]);

            return [
                'success' => false,
                'message' => 'Failed to analyze performance: ' . $e->getMessage()
            ];
        }
    }

    protected function buildPerformancePrompt(string $code, array $optimizations, string $environment): string
    {
        $prompt = "Analyze the following PHP code for performance optimization opportunities:\n\n```php\n$code\n```\n\n";
        
        // Add specific optimization focus areas
        if (!empty($optimizations)) {
            $prompt .= "Focus on these aspects:\n";
            foreach ($optimizations as $opt) {
                switch ($opt) {
                    case 'memory_usage':
                        $prompt .= "- Memory usage and allocation patterns\n";
                        break;
                    case 'cpu_time':
                        $prompt .= "- CPU time optimization and algorithmic efficiency\n";
                        break;
                    case 'database_queries':
                        $prompt .= "- Database query optimization and caching\n";
                        break;
                    case 'caching_strategies':
                        $prompt .= "- Caching opportunities and implementation\n";
                        break;
                    case 'algorithm_complexity':
                        $prompt .= "- Algorithm complexity and Big O analysis\n";
                        break;
                    case 'data_structures':
                        $prompt .= "- Data structure selection and usage\n";
                        break;
                    case 'io_operations':
                        $prompt .= "- I/O operations optimization\n";
                        break;
                    case 'network_calls':
                        $prompt .= "- Network calls and API interactions\n";
                        break;
                    case 'code_structure':
                        $prompt .= "- Code structure and organization for performance\n";
                        break;
                    case 'resource_management':
                        $prompt .= "- Resource management and cleanup\n";
                        break;
                }
            }
        }

        // Add environment context
        $prompt .= "\nEnvironment Context: $environment\n";
        switch ($environment) {
            case 'production':
                $prompt .= "Consider high-traffic production environment with emphasis on stability and scalability.\n";
                break;
            case 'staging':
                $prompt .= "Balance between performance optimization and debugging capabilities.\n";
                break;
            case 'development':
                $prompt .= "Focus on development-time performance and debugging ease.\n";
                break;
        }

        $prompt .= "\nProvide the analysis results in this JSON format:\n";
        $prompt .= "[\n";
        $prompt .= "  {\n";
        $prompt .= "    \"severity\": \"critical|major|minor|optimization\",\n";
        $prompt .= "    \"title\": \"Issue title\",\n";
        $prompt .= "    \"description\": \"Detailed description\",\n";
        $prompt .= "    \"impact\": \"Performance impact details\",\n";
        $prompt .= "    \"solution\": \"How to optimize (optional)\",\n";
        $prompt .= "    \"code\": \"Example optimized code (optional)\"\n";
        $prompt .= "  }\n";
        $prompt .= "]\n\n";
        $prompt .= "Return ONLY the JSON array, no additional text.";

        return $prompt;
    }

    protected function parsePerformanceResponse(string $response): array
    {
        // Extract JSON from the response
        if (preg_match('/\[[\s\S]*\]/', $response, $matches)) {
            $jsonStr = $matches[0];
            $issues = json_decode($jsonStr, true);
            
            if (json_last_error() === JSON_ERROR_NONE && is_array($issues)) {
                return $issues;
            }
        }
        
        // Fallback if JSON parsing fails
        return [[
            'severity' => 'error',
            'title' => 'Analysis Error',
            'description' => 'Failed to parse performance analysis results',
            'solution' => 'Please try again or contact support if the issue persists'
        ]];
    }

    protected function calculateSummary(array $issues): array
    {
        $summary = [
            'critical' => 0,
            'major' => 0,
            'minor' => 0,
            'optimization' => 0
        ];

        foreach ($issues as $issue) {
            $severity = strtolower($issue['severity']);
            if (isset($summary[$severity])) {
                $summary[$severity]++;
            }
        }

        return $summary;
    }
}
