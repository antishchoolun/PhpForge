<?php

namespace App\Http\Controllers;

use App\Services\DomainValuation\DomainValuationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DomainValuationController extends Controller
{
    protected $domainValuation;
    
    public function __construct(DomainValuationService $domainValuation)
    {
        $this->domainValuation = $domainValuation;
    }
    
    public function analyze(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'domain' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]\.)+[a-zA-Z]{2,}$/'
            ],
            'factors' => 'required|array',
            'factors.*' => 'string|in:market_trends,seo_metrics,brand_potential,industry_relevance,length_analysis,keyword_value,sales_history,extensions,trademark_check,commerce_potential',
            'category' => 'required|string|in:general,technology,business,entertainment,e-commerce,health,finance,education',
            'currency' => 'required|string|in:USD,EUR,GBP,AED'
        ], [
            'domain.regex' => 'Please enter a valid domain name without http:// or www'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $result = $this->domainValuation->analyzeDomain(
            $request->input('domain'),
            $request->input('factors', []),
            $request->input('category', 'general'),
            $request->input('currency', 'USD')
        );
        
        return response()->json($result);
    }
}
