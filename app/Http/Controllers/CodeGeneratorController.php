<?php

namespace App\Http\Controllers;

use App\Services\CodeGenerator\CodeGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CodeGeneratorController extends Controller
{
    protected $codeGenerator;
    
    public function __construct(CodeGeneratorService $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }
    
    public function index()
    {
        return view('tools.code-generator');
    }
    
    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prompt' => 'required|string|min:10',
            'framework' => 'required|string|in:raw,laravel,symfony,wordpress,codeigniter',
            'component' => 'required|string|in:controller,model,service,repository,middleware',
            'patterns' => 'nullable|array',
            'patterns.*' => 'string|in:crud,repository,service,factory,dependency',
            'phpVersion' => 'required|string|in:7.4,8.0,8.1,8.2'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $result = $this->codeGenerator->generateCode(
            $request->input('prompt'),
            [
                'framework' => $request->input('framework'),
                'component' => $request->input('component'),
                'patterns' => $request->input('patterns', []),
                'phpVersion' => $request->input('phpVersion')
            ]
        );
        
        return response()->json($result);
    }
}