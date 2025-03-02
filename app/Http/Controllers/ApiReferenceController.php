<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiReferenceController extends Controller
{
    public function index()
    {
        return view('pages.api-reference');
    }
}
