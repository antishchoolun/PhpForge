<?php

namespace App\Http\Controllers;

use App\Services\DocumentationGenerator\DocumentationGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentationGeneratorController extends Controller
{
    protected $documentationGenerator;
    
    public function __construct(DocumentationGeneratorService $documentationGenerator)
    {
        $this->documentationGenerator = $documentationGenerator;
    }
    
    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:1',
            'sections' => 'required|array',
            'sections.*' => 'string|in:function_description,parameter_types,return_values,examples,dependencies,exceptions,changelog,inheritance,security,performance',
            'style' => 'required|string|in:phpdoc,markdown,clean,detailed',
            'format' => 'required|string|in:inline,separate,readme,wiki'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $result = $this->documentationGenerator->generateDocumentation(
            $request->input('code'),
            $request->input('sections', []),
            $request->input('style', 'phpdoc'),
            $request->input('format', 'inline')
        );
        
        return response()->json($result);
    }
}
