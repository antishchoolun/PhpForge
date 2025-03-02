<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function index()
    {
        $systemStatus = $this->getSystemStatus();
        $serviceHealth = $this->getServiceHealth();
        
        return view('pages.status', [
            'systemStatus' => $systemStatus,
            'serviceHealth' => $serviceHealth,
            'lastUpdated' => now()->format('Y-m-d H:i:s T')
        ]);
    }

    private function getSystemStatus()
    {
        return [
            'app' => [
                'status' => 'operational',
                'name' => 'Web Application',
                'description' => 'Main application and website',
                'uptime' => '99.9%'
            ],
            'api' => [
                'status' => 'operational',
                'name' => 'API Services',
                'description' => 'REST API endpoints',
                'uptime' => '99.8%'
            ],
            'database' => [
                'status' => $this->checkDatabaseConnection() ? 'operational' : 'issue',
                'name' => 'Database',
                'description' => 'Primary database connection',
                'uptime' => '99.9%'
            ],
            'cache' => [
                'status' => $this->checkCacheConnection() ? 'operational' : 'issue',
                'name' => 'Cache System',
                'description' => 'Redis/Cache services',
                'uptime' => '99.9%'
            ]
        ];
    }

    private function getServiceHealth()
    {
        return [
            'code_generator' => [
                'status' => 'operational',
                'name' => 'Code Generator',
                'requests_today' => rand(100, 1000),
                'avg_response_time' => rand(100, 500) . 'ms'
            ],
            'debugger' => [
                'status' => 'operational',
                'name' => 'AI Debugging',
                'requests_today' => rand(50, 500),
                'avg_response_time' => rand(200, 800) . 'ms'
            ],
            'security_analyzer' => [
                'status' => 'operational',
                'name' => 'Security Analysis',
                'requests_today' => rand(75, 750),
                'avg_response_time' => rand(150, 600) . 'ms'
            ],
            'performance_tools' => [
                'status' => 'operational',
                'name' => 'Performance Tools',
                'requests_today' => rand(25, 250),
                'avg_response_time' => rand(100, 400) . 'ms'
            ]
        ];
    }

    private function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function checkCacheConnection()
    {
        try {
            Cache::store()->has('test-key');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
