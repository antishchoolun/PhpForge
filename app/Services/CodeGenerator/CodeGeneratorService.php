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
    
    public function generateCode($prompt, array $options)
    {
        try {
            // Get framework-specific code style
            $codeStyle = $this->getFrameworkStyle($options['framework']);
            
            // Get version-specific features
            $versionFeatures = $this->getPhpVersionFeatures($options['phpVersion']);
            
            // Get component-specific requirements
            $componentReqs = $this->getComponentRequirements($options['component']);
            
            // Get pattern implementations
            $patternReqs = $this->getPatternRequirements($options['patterns']);
            
            // Construct enhanced prompt
            $enhancedPrompt = implode("\n\n", [
                "Generate PHP code for the following requirement:",
                $prompt,
                "Technical Context:",
                "- Framework: {$options['framework']}",
                "- PHP Version: {$options['phpVersion']}",
                "- Component Type: {$options['component']}",
                $codeStyle,
                $versionFeatures,
                $componentReqs,
                $patternReqs,
                "Additional Requirements:",
                "- Follow PHP-FIG standards and PSR recommendations",
                "- Include proper error handling and validation",
                "- Add comprehensive PHPDoc comments",
                "- Use proper type hints and return types",
                "- Follow SOLID principles",
                "- Make code testable and maintainable",
                "\nProvide only the code without explanations."
            ]);
            
            // Get code from Groq API
            $result = $this->groqApi->generateCode($enhancedPrompt);
            
            // Extract code from response
            $code = $result['choices'][0]['text'] ?? '';
            if (preg_match('/```(?:php)?\n(.*?)\n```/s', $code, $matches)) {
                $code = $matches[1];
            }
            
            // Log successful generation
            Log::info('Code generated successfully', [
                'framework' => $options['framework'],
                'component' => $options['component'],
                'prompt_length' => strlen($prompt)
            ]);
            
            return [
                'success' => true,
                'code' => $code
            ];
            
        } catch (\Exception $e) {
            Log::error('Code generation failed', [
                'error' => $e->getMessage(),
                'framework' => $options['framework'] ?? 'unknown'
            ]);
            
            return [
                'success' => false,
                'error' => 'Failed to generate code: ' . $e->getMessage()
            ];
        }
    }

    protected function getFrameworkStyle($framework)
    {
        $styles = [
            'raw' => "Use vanilla PHP with modern practices:\n- PSR-4 autoloading\n- Composer for dependencies\n- Modern PHP features",
            'laravel' => "Follow Laravel conventions:\n- Use Laravel's service container\n- Follow facade patterns\n- Use Laravel's helper functions",
            'symfony' => "Follow Symfony conventions:\n- Use dependency injection\n- Follow Symfony's service architecture\n- Use Symfony's components",
            'wordpress' => "Follow WordPress standards:\n- Use WordPress coding standards\n- Follow plugin/theme architecture\n- Use WordPress functions and hooks",
            'codeigniter' => "Follow CodeIgniter patterns:\n- Use CodeIgniter's helpers\n- Follow MVC architecture\n- Use CodeIgniter's libraries"
        ];

        return $styles[$framework] ?? $styles['raw'];
    }

    protected function getPhpVersionFeatures($version)
    {
        $features = [
            '7.4' => "Use PHP 7.4 features:\n- Typed properties\n- Arrow functions\n- Null coalescing assignment",
            '8.0' => "Use PHP 8.0 features:\n- Constructor property promotion\n- Named arguments\n- Match expression\n- Nullsafe operator",
            '8.1' => "Use PHP 8.1 features:\n- Enums\n- First-class callable syntax\n- Pure intersection types\n- Never return type",
            '8.2' => "Use PHP 8.2 features:\n- Readonly classes\n- Disjunctive normal form types\n- Standalone types\n- Null/false standalone types"
        ];

        return $features[$version] ?? $features['8.1'];
    }

    protected function getComponentRequirements($component)
    {
        $requirements = [
            'controller' => "Controller requirements:\n- Handle HTTP requests\n- Input validation\n- Response formatting\n- Error handling",
            'model' => "Model requirements:\n- Data validation\n- Relationship definitions\n- Attribute handling\n- Query scopes",
            'service' => "Service requirements:\n- Business logic handling\n- Transaction management\n- Event dispatching\n- Error handling",
            'repository' => "Repository requirements:\n- Data access abstraction\n- Query building\n- Cache handling\n- Error handling",
            'middleware' => "Middleware requirements:\n- Request/Response handling\n- Authentication/Authorization\n- Input sanitization\n- Error handling"
        ];

        return $requirements[$component] ?? '';
    }

    protected function getPatternRequirements($patterns)
    {
        if (empty($patterns)) {
            return '';
        }

        $implementations = [
            'crud' => "- Implement CRUD operations\n- Include validation\n- Handle relationships\n- Format responses",
            'repository' => "- Use repository pattern\n- Abstract data access\n- Include caching strategy\n- Handle errors",
            'service' => "- Implement service layer\n- Handle business logic\n- Manage transactions\n- Emit events",
            'factory' => "- Use factory pattern\n- Create object instances\n- Handle dependencies\n- Support variations",
            'dependency' => "- Use dependency injection\n- Implement interfaces\n- Follow SOLID principles\n- Support testing"
        ];

        $selected = array_intersect_key($implementations, array_flip($patterns));
        return "Implementation Patterns:\n" . implode("\n", $selected);
    }
}