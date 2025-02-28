<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function generate(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Code generated successfully'
        ]);
    }
}
