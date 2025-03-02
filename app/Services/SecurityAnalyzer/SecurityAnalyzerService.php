<?php

namespace App\Services\SecurityAnalyzer;

use App\Services\GroqApi\GroqApiClient;
use Illuminate\Support\Facades\Log;

class SecurityAnalyzerService
{
    protected $groqApi;

    public function __construct(GroqApiClient $groqApi)
    {
        $this->groqApi = $groqApi;
    }

    public function analyzeSecurity(string $code, array $checks = [], string $riskLevel = 'medium')
    {
        try {
            // Build analysis prompt with selected checks
            $prompt = $this->buildSecurityPrompt($code, $checks);
            
            // Get AI analysis
            $result = $this->groqApi->analyzeSecurity($prompt);
            
            // Parse the response
            $vulnerabilities = $this->parseSecurityResponse($result['analysis']);
            
            // Filter by risk level
            $filteredVulnerabilities = $this->filterByRiskLevel($vulnerabilities, $riskLevel);
            
            // Calculate summary
            $summary = $this->calculateSummary($filteredVulnerabilities);
            
            return [
                'success' => true,
                'vulnerabilities' => $filteredVulnerabilities,
                'summary' => $summary
            ];

        } catch (\Exception $e) {
            Log::error('Security analysis error: ' . $e->getMessage(), [
                'code' => $code,
                'checks' => $checks,
                'risk_level' => $riskLevel
            ]);

            return [
                'success' => false,
                'message' => 'Failed to analyze security: ' . $e->getMessage()
            ];
        }
    }

    protected function buildSecurityPrompt(string $code, array $checks): string
    {
        $prompt = "Analyze the following PHP code for security vulnerabilities:\n\n```php\n$code\n```\n\n";
        
        // Add specific security checks
        if (!empty($checks)) {
            $prompt .= "Focus on these security aspects:\n";
            foreach ($checks as $check) {
                switch ($check) {
                    case 'sql_injection':
                        $prompt .= "- SQL Injection vulnerabilities\n";
                        break;
                    case 'xss':
                        $prompt .= "- Cross-Site Scripting (XSS) vulnerabilities\n";
                        break;
                    case 'csrf':
                        $prompt .= "- CSRF protection and vulnerabilities\n";
                        break;
                    case 'file_security':
                        $prompt .= "- File system security issues\n";
                        break;
                    case 'input_validation':
                        $prompt .= "- Input validation and sanitization\n";
                        break;
                    case 'authentication':
                        $prompt .= "- Authentication security issues\n";
                        break;
                    case 'session_security':
                        $prompt .= "- Session management security\n";
                        break;
                    case 'encryption':
                        $prompt .= "- Encryption and sensitive data handling\n";
                        break;
                    case 'dependency_check':
                        $prompt .= "- Security issues in dependencies/frameworks\n";
                        break;
                    case 'api_security':
                        $prompt .= "- API security best practices\n";
                        break;
                }
            }
        }

        $prompt .= "\nProvide the analysis results in this JSON format:\n";
        $prompt .= "[\n";
        $prompt .= "  {\n";
        $prompt .= "    \"severity\": \"high|medium|low|info\",\n";
        $prompt .= "    \"title\": \"Issue title\",\n";
        $prompt .= "    \"description\": \"Detailed description\",\n";
        $prompt .= "    \"location\": \"Where in the code (optional)\",\n";
        $prompt .= "    \"recommendation\": \"How to fix (optional)\",\n";
        $prompt .= "    \"code\": \"Example fix code (optional)\"\n";
        $prompt .= "  }\n";
        $prompt .= "]\n\n";
        $prompt .= "Return ONLY the JSON array, no additional text.";

        return $prompt;
    }

    protected function parseSecurityResponse(string $response): array
    {
        // Extract JSON from the response
        if (preg_match('/\[[\s\S]*\]/', $response, $matches)) {
            $jsonStr = $matches[0];
            $vulnerabilities = json_decode($jsonStr, true);
            
            if (json_last_error() === JSON_ERROR_NONE && is_array($vulnerabilities)) {
                return $vulnerabilities;
            }
        }
        
        // Fallback if JSON parsing fails
        return [[
            'severity' => 'error',
            'title' => 'Analysis Error',
            'description' => 'Failed to parse security analysis results',
            'recommendation' => 'Please try again or contact support if the issue persists'
        ]];
    }

    protected function filterByRiskLevel(array $vulnerabilities, string $minLevel): array
    {
        $levels = [
            'info' => 0,
            'low' => 1,
            'medium' => 2,
            'high' => 3
        ];

        $minLevelValue = $levels[strtolower($minLevel)] ?? 0;

        return array_filter($vulnerabilities, function($vuln) use ($levels, $minLevelValue) {
            $vulnLevel = $levels[strtolower($vuln['severity'])] ?? 0;
            return $vulnLevel >= $minLevelValue;
        });
    }

    protected function calculateSummary(array $vulnerabilities): array
    {
        $summary = [
            'high' => 0,
            'medium' => 0,
            'low' => 0,
            'info' => 0
        ];

        foreach ($vulnerabilities as $vuln) {
            $severity = strtolower($vuln['severity']);
            if (isset($summary[$severity])) {
                $summary[$severity]++;
            }
        }

        return $summary;
    }
}
