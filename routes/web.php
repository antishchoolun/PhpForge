<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CodeGeneratorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

// Tool routes (protected by TrackUsage middleware)
Route::middleware('track.usage')->group(function () {
    Route::post('/tools/generate', [CodeGeneratorController::class, 'generate'])->name('tools.generate');
    // Add other tool routes here
});

// Auth routes (provided by Laravel Breeze)
require __DIR__.'/auth.php';
