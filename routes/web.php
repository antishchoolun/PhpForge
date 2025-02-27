<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CodeGeneratorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tool Routes
Route::prefix('tools')->name('tools.')->group(function () {
    // Code Generator
    Route::get('/code-generator', [CodeGeneratorController::class, 'index'])->name('code-generator');
    Route::post('/code-generator/generate', [CodeGeneratorController::class, 'generate'])->name('code-generator.generate');
    
    // Future tool routes will go here
    // Route::get('/debugging', [DebuggingController::class, 'index'])->name('debugging');
    // Route::get('/security', [SecurityController::class, 'index'])->name('security');
    // Route::get('/performance', [PerformanceController::class, 'index'])->name('performance');
    // Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation');
    // Route::get('/domain-valuation', [DomainValuationController::class, 'index'])->name('domain-valuation');
});

// Static Pages
Route::view('/pricing', 'pages.pricing')->name('pricing');
Route::view('/documentation', 'pages.documentation')->name('documentation');
Route::view('/blog', 'pages.blog')->name('blog');

// Auth Routes (placeholders for now)
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
