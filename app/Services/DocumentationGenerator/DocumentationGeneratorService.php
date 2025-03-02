<?php

namespace App\Services\DocumentationGenerator;

use App\Services\GroqApi\GroqApiClient;
use Illuminate\Support\Facades\Log;

class DocumentationGeneratorService
{
    protected $groqApi;

    public function __construct(GroqApiClient $groqApi)
    {
        $this->groqApi = $groqApi;
    }

    public function generateDocumentation(string $code, array $sections = [], string $style = 'phpdoc', string $format = 'inline')
    {
        try {
            // Build documentation prompt with selected sections and style
            $prompt = $this->buildDocumentationPrompt($code, $sections, $style, $format);
            
            // Get AI documentation generation
            $result = $this->groqApi->generateDocumentation($prompt);
            
            // Parse and format the documentation
            $documentation = $this->formatDocumentation($result['documentation'], $format);
            
            // Calculate summary
            $summary = $this->calculateSummary($documentation, $code);
            
            return [
                'success' => true,
                'documentation' => $documentation,
                'summary' => $summary
            ];

        } catch (\Exception $e) {
            Log::error('Documentation generation error: ' . $e->getMessage(), [
                'code' => $code,
                'sections' => $sections,
                'style' => $style,
                'format' => $format
            ]);

            return [
                'success' => false,
                'message' => 'Failed to generate documentation: ' . $e->getMessage()
            ];
        }
    }

    protected function buildDocumentationPrompt(string $code, array $sections, string $style, string $format): string
    {
        $prompt = "Generate documentation for the following PHP code:\n\n```php\n$code\n```\n\n";
        
        // Add section requirements
        if (!empty($sections)) {
            $prompt .= "Include these documentation sections:\n";
            foreach ($sections as $section) {
                switch ($section) {
                    case 'function_description':
                        $prompt .= "- Detailed function/method descriptions\n";
                        break;
                    case 'parameter_types':
                        $prompt .= "- Parameter types and descriptions\n";
                        break;
                    case 'return_values':
                        $prompt .= "- Return value specifications\n";
                        break;
                    case 'examples':
                        $prompt .= "- Usage examples\n";
                        break;
                    case 'dependencies':
                        $prompt .= "- Dependencies and requirements\n";
                        break;
                    case 'exceptions':
                        $prompt .= "- Exceptions and error handling\n";
                        break;
                    case 'changelog':
                        $prompt .= "- Version history and changelog\n";
                        break;
                    case 'inheritance':
                        $prompt .= "- Class inheritance and hierarchy\n";
                        break;
                    case 'security':
                        $prompt .= "- Security considerations\n";
                        break;
                    case 'performance':
                        $prompt .= "- Performance implications\n";
                        break;
                }
            }
        }

        // Add style requirements
        $prompt .= "\nUse this documentation style: $style\n";
        switch ($style) {
            case 'phpdoc':
                $prompt .= "Follow PHPDoc standard with @ tags\n";
                break;
            case 'markdown':
                $prompt .= "Use Markdown formatting\n";
                break;
            case 'clean':
                $prompt .= "Use clean text without special formatting\n";
                break;
            case 'detailed':
                $prompt .= "Provide detailed descriptions with examples\n";
                break;
        }

        // Add format-specific instructions
        switch ($format) {
            case 'inline':
                $prompt .= "\nGenerate documentation as inline comments\n";
                break;
            case 'separate':
                $prompt .= "\nGenerate documentation as a separate document\n";
                break;
            case 'readme':
                $prompt .= "\nGenerate documentation in README format\n";
                break;
            case 'wiki':
                $prompt .= "\nGenerate documentation in wiki format\n";
                break;
        }

        return $prompt;
    }

    protected function formatDocumentation(string $documentation, string $format): string
    {
        // Format based on output type
        switch ($format) {
            case 'inline':
                return $this->formatInlineDocumentation($documentation);
            case 'markdown':
                return $this->formatMarkdownDocumentation($documentation);
            case 'wiki':
                return $this->formatWikiDocumentation($documentation);
            default:
                return $documentation;
        }
    }

    protected function formatInlineDocumentation(string $documentation): string
    {
        // Ensure proper spacing and indentation for inline comments
        $lines = explode("\n", $documentation);
        $formatted = [];
        foreach ($lines as $line) {
            // Add proper indentation for multiline comments
            if (!empty($line)) {
                $formatted[] = trim($line);
            }
        }
        return implode("\n", $formatted);
    }

    protected function formatMarkdownDocumentation(string $documentation): string
    {
        // Ensure proper Markdown formatting
        return trim($documentation);
    }

    protected function formatWikiDocumentation(string $documentation): string
    {
        // Format for wiki-style display
        return str_replace('```', '<code>', str_replace('```php', '<code>', $documentation));
    }

    protected function calculateSummary(string $documentation, string $code): array
    {
        $docLines = substr_count($documentation, "\n") + 1;
        $codeLines = substr_count($code, "\n") + 1;
        $docWords = str_word_count($documentation);
        
        // Calculate documentation coverage percentage
        $codeElements = $this->countCodeElements($code);
        $documentedElements = $this->countDocumentedElements($documentation);
        $coverage = $codeElements > 0 ? 
            round(($documentedElements / $codeElements) * 100) : 100;

        return [
            'sections' => $this->countSections($documentation),
            'lines' => $docLines,
            'coverage' => $coverage
        ];
    }

    protected function countCodeElements(string $code): int
    {
        $count = 0;
        
        // Count functions
        preg_match_all('/function\s+\w+\s*\(/', $code, $matches);
        $count += count($matches[0]);
        
        // Count classes
        preg_match_all('/class\s+\w+/', $code, $matches);
        $count += count($matches[0]);
        
        // Count methods
        preg_match_all('/public|private|protected\s+function\s+\w+\s*\(/', $code, $matches);
        $count += count($matches[0]);
        
        // Count properties
        preg_match_all('/public|private|protected\s+\$\w+/', $code, $matches);
        $count += count($matches[0]);
        
        return $count;
    }

    protected function countDocumentedElements(string $documentation): int
    {
        $count = 0;
        
        // Count documented elements based on doc blocks or descriptions
        preg_match_all('/@(param|return|var|method|property)/', $documentation, $matches);
        $count += count($matches[0]);
        
        // Count function/method descriptions
        preg_match_all('/\* [\w\s]+function/', $documentation, $matches);
        $count += count($matches[0]);
        
        return $count;
    }

    protected function countSections(string $documentation): int
    {
        $count = 0;
        
        // Count PHPDoc sections
        preg_match_all('/@\w+/', $documentation, $matches);
        $count += count($matches[0]);
        
        // Count Markdown sections
        preg_match_all('/^#{1,6}\s+\w+/m', $documentation, $matches);
        $count += count($matches[0]);
        
        return max(1, $count); // At least 1 section
    }
}
