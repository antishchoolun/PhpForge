<?php

namespace PhpForge\Services;

use Exception;

class CodeGeneratorService extends BaseToolService
{
    /**
     * @var string The name of the tool
     */
    protected $toolName = 'code_generator';

    /**
     * Process the code generation request
     */
    protected function processRequest(array $input): array
    {
        $this->validateInput($input);

        // Prepare the prompt for the AI model
        $prompt = $this->preparePrompt($input);

        // Make API request to Groq
        $response = $this->makeApiRequestWithRetry('/completions', [
            'model' => 'mixtral-8x7b-32768',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a senior PHP developer expert. Generate clean, efficient, and well-documented PHP code based on the user\'s requirements. Always follow PSR standards and modern PHP best practices.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => $this->config[$this->toolName]['temperature'] ?? 0.7,
            'max_tokens' => $this->config[$this->toolName]['max_tokens'] ?? 2000,
            'top_p' => 0.9,
            'frequency_penalty' => 0.1,
            'presence_penalty' => 0.1
        ]);

        // Extract and format the generated code
        $generatedCode = $this->extractCode($response['choices'][0]['message']['content']);

        // Analyze the generated code
        $analysis = $this->analyzeCode($generatedCode);

        return $this->formatResponse([
            'code' => $generatedCode,
            'analysis' => $analysis,
            'metrics' => $this->calculateMetrics($generatedCode)
        ]);
    }

    /**
     * Validate the input data
     */
    protected function validateInput(array $input): void
    {
        if (empty($input['prompt'])) {
            throw new Exception('Prompt is required');
        }

        if (strlen($input['prompt']) > 1000) {
            throw new Exception('Prompt is too long (maximum 1000 characters)');
        }

        $options = $input['options'] ?? [];
        if (!is_array($options)) {
            throw new Exception('Options must be an array');
        }
    }

    /**
     * Prepare the prompt for the AI model
     */
    private function preparePrompt(array $input): string
    {
        $options = $input['options'] ?? [];
        $prompt = $input['prompt'];

        // Add requirements based on options
        $requirements = [];
        
        if ($options['include_comments'] ?? true) {
            $requirements[] = "Include detailed PHPDoc comments and inline documentation.";
        }

        if ($options['error_handling'] ?? true) {
            $requirements[] = "Implement proper error handling with try/catch blocks and logging.";
        }

        if ($options['psr12_compliance'] ?? false) {
            $requirements[] = "Ensure strict PSR-12 coding standard compliance.";
        }

        if ($options['type_hinting'] ?? false) {
            $requirements[] = "Use strict type declarations and type hinting.";
        }

        // Combine prompt with requirements
        return $prompt . "\n\nRequirements:\n- " . implode("\n- ", $requirements);
    }

    /**
     * Extract code from API response
     */
    private function extractCode(string $response): string
    {
        // Extract code between ``` markers if present
        if (preg_match('/```php(.*?)```/s', $response, $matches)) {
            return trim($matches[1]);
        }

        // If no markers, assume the entire response is code
        return trim($response);
    }

    /**
     * Analyze the generated code
     */
    private function analyzeCode(string $code): array
    {
        $analysis = [
            'practices' => [],
            'warnings' => [],
            'suggestions' => []
        ];

        // Check for good practices
        if (strpos($code, 'try') !== false && strpos($code, 'catch') !== false) {
            $analysis['practices'][] = "Implements error handling with try/catch blocks";
        }

        if (preg_match('/@param|@return|@throws/', $code)) {
            $analysis['practices'][] = "Includes PHPDoc documentation";
        }

        if (strpos($code, 'declare(strict_types=1)') !== false) {
            $analysis['practices'][] = "Uses strict type declarations";
        }

        // Check for potential warnings
        if (strpos($code, 'var_dump') !== false || strpos($code, 'print_r') !== false) {
            $analysis['warnings'][] = "Contains debugging functions that should be removed in production";
        }

        if (preg_match('/mysql_/', $code)) {
            $analysis['warnings'][] = "Uses deprecated MySQL functions; consider using PDO or MySQLi";
        }

        // Generate suggestions
        if (!preg_match('/\binterface\b|\btrait\b/', $code) && strlen($code) > 500) {
            $analysis['suggestions'][] = "Consider extracting functionality into interfaces or traits for better reusability";
        }

        if (!preg_match('/@throws/', $code) && strpos($code, 'throw') !== false) {
            $analysis['suggestions'][] = "Document thrown exceptions using @throws PHPDoc tags";
        }

        return $analysis;
    }

    /**
     * Calculate code metrics
     */
    private function calculateMetrics(string $code): array
    {
        $metrics = [
            'lines' => substr_count($code, "\n") + 1,
            'characters' => strlen($code),
            'functions' => substr_count(strtolower($code), 'function'),
            'classes' => substr_count(strtolower($code), 'class'),
            'complexity' => $this->calculateComplexity($code)
        ];

        // Calculate comment ratio
        $comments = preg_match_all('/(\/\*.*?\*\/|\/\/[^\n]*)/s', $code, $matches);
        $metrics['comment_ratio'] = $comments ? round(strlen(implode('', $matches[0])) / strlen($code) * 100, 2) : 0;

        return $metrics;
    }

    /**
     * Calculate cyclomatic complexity
     */
    private function calculateComplexity(string $code): int
    {
        $complexity = 1; // Base complexity

        // Count control structures
        $controlStructures = [
            'if', 'else', 'elseif', 'case', 'default', 'for',
            'foreach', 'while', 'do', 'catch', '&&', '\\|\\|'
        ];

        foreach ($controlStructures as $structure) {
            $complexity += substr_count(strtolower($code), $structure);
        }

        return $complexity;
    }
}