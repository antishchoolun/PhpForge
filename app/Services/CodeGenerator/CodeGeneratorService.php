<?php

namespace App\Services\CodeGenerator;

use App\Services\GroqApi\GroqApiClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CodeGeneratorService
{
    protected $groqApi;
    
    public function __construct(GroqApiClient $groqApi)
    {
        $this->groqApi = $groqApi;
    }
    
    public function generateCode($prompt, $language = 'php', $options = [])
    {
        try {
            // Build language-specific requirements
            $requirements = $this->getLanguageRequirements($language);
            
            // Add selected options to requirements
            foreach ($options as $option) {
                switch ($option) {
                    case 'comments':
                        $requirements[] = "Include detailed comments and documentation";
                        break;
                    case 'error_handling':
                        $requirements[] = "Implement comprehensive error handling";
                        break;
                    case 'psr12':
                        if ($language === 'php') {
                            $requirements[] = "Follow PSR-12 coding standards";
                        }
                        break;
                    case 'type_hints':
                        $requirements[] = "Use type hints/annotations where applicable";
                        break;
                }
            }

            // Construct enhanced prompt with specific instructions
            $enhancedPrompt = implode("\n\n", [
                "Please generate {$language} code for the following requirement:",
                $prompt,
                "Technical Requirements:",
                implode("\n", array_map(fn($req) => "- {$req}", $requirements)),
                "Additional Instructions:",
                "- Provide only the code without explanations",
                "- Include comments to explain complex logic",
                "- Follow standard coding conventions",
                "- Ensure the code is production-ready"
            ]);
            
            // Get code from Groq API
            $result = $this->groqApi->generateCode($enhancedPrompt);

            // Extract just the code block if it's wrapped in markdown or explanations
            $code = $result['choices'][0]['text'] ?? '';
            if (preg_match('/```(?:\w+)?\n(.*?)\n```/s', $code, $matches)) {
                $code = $matches[1];
            }

            $result['choices'][0]['text'] = $code;
            
            // Log successful generation
            Log::info('Code generated successfully', [
                'language' => $language,
                'prompt_length' => strlen($prompt)
            ]);
            
            return [
                'success' => true,
                'code' => $result['choices'][0]['text'] ?? '',
                'language' => $language
            ];
            
        } catch (\Exception $e) {
            Log::error('Code generation failed', [
                'error' => $e->getMessage(),
                'language' => $language
            ]);
            
            return [
                'success' => false,
                'error' => 'Failed to generate code: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get language-specific code generation requirements
     * 
     * @param string $language
     * @return array
     */
    protected function getLanguageRequirements($language)
    {
        $common = [
            'Follow best practices and conventions',
            'Use meaningful variable and function names',
            'Include proper code organization and structure'
        ];

        $specific = [
            'php' => [
                'Follow PHP 8.0+ features where appropriate',
                'Use proper namespacing',
                'Follow SOLID principles'
            ],
            'javascript' => [
                'Use modern ES6+ features',
                'Follow async/await patterns for asynchronous code',
                'Consider browser compatibility'
            ],
            'python' => [
                'Follow PEP 8 style guide',
                'Use Python 3.x features',
                'Include proper type hints (Python 3.5+)'
            ],
            'java' => [
                'Follow Java coding conventions',
                'Use appropriate access modifiers',
                'Include proper exception handling'
            ],
            'cpp' => [
                'Follow modern C++ practices',
                'Use STL where appropriate',
                'Include memory management considerations'
            ],
            'csharp' => [
                'Follow C# conventions',
                'Use appropriate access modifiers',
                'Include proper exception handling'
            ]
        ];

        return array_merge(
            $common,
            $specific[$language] ?? []
        );
    }
}