<?php

namespace App\Http\Controllers;

use App\Services\CodeDebugger\CodeDebuggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CodeDebuggerController extends Controller
{
    protected $codeDebugger;
    
    public function __construct(CodeDebuggerService $codeDebugger)
    {
        $this->codeDebugger = $codeDebugger;
    }
    
    public function index()
    {
        return view('tools.code-debugger');
    }
    
    public function debug(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:1',
            'errorDescription' => 'nullable|string',
            'options' => 'required|array',
            'options.*' => 'string|in:security,performance,best_practices,type_safety,memory_leaks,logic_errors'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $result = $this->codeDebugger->debugCode(
            $request->input('code'),
            $request->input('errorDescription'),
            $request->input('options', [])
        );
        
        return response()->json($result);
    }
}
