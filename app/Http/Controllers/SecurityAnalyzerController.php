<?php

namespace App\Http\Controllers;

use App\Services\SecurityAnalyzer\SecurityAnalyzerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecurityAnalyzerController extends Controller
{
    protected $securityAnalyzer;
    
    public function __construct(SecurityAnalyzerService $securityAnalyzer)
    {
        $this->securityAnalyzer = $securityAnalyzer;
    }
    
    public function analyze(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:1',
            'checks' => 'required|array',
            'checks.*' => 'string|in:sql_injection,xss,csrf,file_security,input_validation,authentication,session_security,encryption,dependency_check,api_security',
            'riskLevel' => 'required|string|in:info,low,medium,high'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $result = $this->securityAnalyzer->analyzeSecurity(
            $request->input('code'),
            $request->input('checks', []),
            $request->input('riskLevel')
        );
        
        return response()->json($result);
    }
}
