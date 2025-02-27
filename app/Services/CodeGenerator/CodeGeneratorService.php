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
    
    public function generateCode($prompt, $language = 'php')
    {
        try {
            // Enhance prompt with language context
            $enhancedPrompt = "Generate {$language} code for: {$prompt}\n" .
                            "Please provide clean, well-documented code following best practices.";
            
            $result = $this->groqApi->generateCode($enhancedPrompt);
            
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
}