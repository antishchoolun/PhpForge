<?php

namespace App\Http\Controllers;

use App\Services\PerformanceOptimizer\PerformanceOptimizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PerformanceOptimizerController extends Controller
{
    protected $performanceOptimizer;
    
    public function __construct(PerformanceOptimizerService $performanceOptimizer)
    {
        $this->performanceOptimizer = $performanceOptimizer;
    }
    
    public function optimize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:1',
            'optimizations' => 'required|array',
            'optimizations.*' => 'string|in:memory_usage,cpu_time,database_queries,caching_strategies,algorithm_complexity,data_structures,io_operations,network_calls,code_structure,resource_management',
            'environment' => 'required|string|in:production,staging,development'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $result = $this->performanceOptimizer->analyzePerformance(
            $request->input('code'),
            $request->input('optimizations', []),
            $request->input('environment')
        );
        
        return response()->json($result);
    }
}
