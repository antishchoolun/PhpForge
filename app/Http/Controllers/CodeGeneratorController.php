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
            'language' => 'required|string|in:php,javascript,python,java,cpp,csharp',
            'options' => 'nullable|array',
            'options.*' => 'string|in:comments,error_handling,psr12,type_hints'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $result = $this->codeGenerator->generateCode(
            $request->input('prompt'),
            $request->input('language'),
            $request->input('options', [])
        );
        
        return response()->json($result);
    }
}