<?php

namespace App\Services\CodeDebugger;

use App\Services\GroqApi\GroqApiClient;
use Illuminate\Support\Facades\Log;

class CodeDebuggerService
{
    protected $groqApi;

    public function __construct(GroqApiClient $groqApi)
    {
        $this->groqApi = $groqApi;
    }

    public function debugCode(string $code, ?string $errorDescription = null, array $options = [])
    {
        try {
            // Build analysis prompt with selected options
            $prompt = $code;
            if (!empty($options)) {
                $prompt .= "\n\nPlease focus on these aspects:\n";
                foreach ($options as $option) {
                    switch ($option) {
                        case 'security':
                            $prompt .= "- Security vulnerabilities (SQL injection, XSS, CSRF)\n";
                            break;
                        case 'performance':
                            $prompt .= "- Performance optimization opportunities\n";
                            break;
                        case 'best_practices':
                            $prompt .= "- PHP best practices and design patterns\n";
                            break;
                        case 'type_safety':
                            $prompt .= "- Type safety and type hint usage\n";
                            break;
                        case 'memory_leaks':
                            $prompt .= "- Memory leaks and resource management\n";
                            break;
                        case 'logic_errors':
                            $prompt .= "- Logic errors and edge cases\n";
                            break;
                    }
                }
            }

            if ($errorDescription) {
                $prompt .= "\n\nReported Error:\n$errorDescription";
            }

            // Get AI analysis
            $debugResult = $this->groqApi->debugCode($prompt);
            
            // Parse the response
            $analysis = $this->parseAnalysisResponse($debugResult['analysis']);
            
            // Generate fixed code if there were errors
            $fixedCode = null;
            if ($this->hasErrors($analysis)) {
                $fixedCode = $this->generateFixedCode($code, $analysis);
            }
            
            return [
                'success' => true,
                'analysis' => $analysis,
                'fixedCode' => $fixedCode
            ];

        } catch (\Exception $e) {
            Log::error('Code analysis error: ' . $e->getMessage(), [
                'code' => $code,
                'error_description' => $errorDescription,
                'options' => $options
            ]);

            return [
                'success' => false,
                'message' => 'Failed to analyze code: ' . $e->getMessage()
            ];
        }
    }

    protected function buildAnalysisPrompt(string $code, ?string $errorDescription, array $options): string
    {
        $prompt = "Analyze the following PHP code";
        
        if ($errorDescription) {
            $prompt .= " with reported error: $errorDescription";
        }
        
        $prompt .= "\n\nCode:\n```php\n$code\n```\n\n";
        
        // Add analysis instructions based on options
        $prompt .= "Please perform the following analysis:\n";
        
        if (in_array('security', $options)) {
            $prompt .= "- Check for security vulnerabilities (SQL injection, XSS, CSRF, etc.)\n";
        }
        if (in_array('performance', $options)) {
            $prompt .= "- Evaluate performance implications and optimization opportunities\n";
        }
        if (in_array('best_practices', $options)) {
            $prompt .= "- Review code against PHP best practices and design patterns\n";
        }
        if (in_array('type_safety', $options)) {
            $prompt .= "- Analyze type safety and type hint usage\n";
        }
        if (in_array('memory_leaks', $options)) {
            $prompt .= "- Check for potential memory leaks or resource management issues\n";
        }
        if (in_array('logic_errors', $options)) {
            $prompt .= "- Identify potential logical errors or edge cases\n";
        }
        
        $prompt .= "\nProvide analysis results in JSON format with the following structure:
        [
            {
                \"severity\": \"error|warning|info|success\",
                \"title\": \"Issue title\",
                \"message\": \"Detailed explanation\",
                \"suggestion\": \"How to fix it (optional)\",
                \"code\": \"Example code snippet (optional)\"
            }
        ]";
        
        return $prompt;
    }

    protected function parseAnalysisResponse(string $response): array
    {
        // Extract JSON from the response
        if (preg_match('/\[[\s\S]*\]/', $response, $matches)) {
            $jsonStr = $matches[0];
            $analysis = json_decode($jsonStr, true);
            
            if (json_last_error() === JSON_ERROR_NONE && is_array($analysis)) {
                return $analysis;
            }
        }
        
        // Fallback if JSON parsing fails
        return [[
            'severity' => 'error',
            'title' => 'Analysis Error',
            'message' => 'Failed to parse analysis results',
            'suggestion' => 'Please try again or contact support if the issue persists'
        ]];
    }

    protected function hasErrors(array $analysis): bool
    {
        return collect($analysis)->contains('severity', 'error');
    }

    protected function generateFixedCode(string $originalCode, array $analysis): ?string
    {
        // Only generate fixed code if there are errors
        if (!$this->hasErrors($analysis)) {
            return null;
        }

        try {
            // Build fix prompt with found issues
            $prompt = "Fix the following PHP code:\n\n```php\n$originalCode\n```\n\n";
            $prompt .= "Address these issues:\n";
            
            foreach ($analysis as $item) {
                if ($item['severity'] === 'error') {
                    $prompt .= "- {$item['title']}: {$item['message']}\n";
                    if (!empty($item['suggestion'])) {
                        $prompt .= "  Suggestion: {$item['suggestion']}\n";
                    }
                }
            }
            
            $prompt .= "\nProvide ONLY the fixed code without explanations, wrapped in PHP code block.";
            
            $fixResult = $this->groqApi->generateCode($prompt);
            $fixedCode = $fixResult['choices'][0]['text'] ?? null;
            
            // Clean up the response to extract just the code
            if ($fixedCode) {
                // Remove any markdown code block syntax
                $fixedCode = preg_replace('/^```php\s*|\s*```$/m', '', $fixedCode);
                // Ensure the code doesn't start with <?php if it's already there
                $fixedCode = preg_replace('/^<\?php\s+/', '', $fixedCode);
                // Add <?php tag if it's missing
                if (!str_starts_with(trim($fixedCode), '<?php')) {
                    $fixedCode = "<?php\n\n" . $fixedCode;
                }
            }
            
            return $fixedCode;

        } catch (\Exception $e) {
            Log::error('Failed to generate fixed code: ' . $e->getMessage());
            return null;
        }
    }
}
