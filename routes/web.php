<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CodeGeneratorController;
use App\Http\Controllers\CodeDebuggerController;
use App\Http\Controllers\SecurityAnalyzerController;
use App\Http\Controllers\PerformanceOptimizerController;
use App\Http\Controllers\DocumentationGeneratorController;
use App\Http\Controllers\DomainValuationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Middleware\TrackUsage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

// Auth routes (provided by Laravel Breeze)
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Tool routes
Route::post('/tools/generate', [CodeGeneratorController::class, 'generate'])
    ->middleware(TrackUsage::class)
    ->name('tools.generate');

// Protected tool routes
// Tool routes with usage tracking
Route::post('/tools/debug', [CodeDebuggerController::class, 'debug'])
    ->middleware(TrackUsage::class)
    ->name('tools.debug');

Route::post('/tools/security-analyze', [SecurityAnalyzerController::class, 'analyze'])
    ->middleware(TrackUsage::class)
    ->name('tools.security.analyze');

Route::post('/tools/performance-optimize', [PerformanceOptimizerController::class, 'optimize'])
    ->middleware(TrackUsage::class)
    ->name('tools.performance.optimize');

Route::post('/tools/generate-docs', [DocumentationGeneratorController::class, 'generate'])
    ->middleware(TrackUsage::class)
    ->name('tools.docs.generate');

Route::post('/tools/domain-valuation', [DomainValuationController::class, 'analyze'])
    ->middleware(TrackUsage::class)
    ->name('tools.domain.valuation');
