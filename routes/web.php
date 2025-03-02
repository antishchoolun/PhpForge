<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CodeGeneratorController;
use App\Http\Controllers\CodeDebuggerController;
use App\Http\Controllers\SecurityAnalyzerController;
use App\Http\Controllers\PerformanceOptimizerController;
use App\Http\Controllers\DocumentationGeneratorController;
use App\Http\Controllers\DomainValuationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\CookiePolicyController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ApiReferenceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\BlogController;
use App\Http\Middleware\TrackUsage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    
    return "Cache cleared successfully!";
})->middleware('auth')->name('cache.clear');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation');
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy.policy');
Route::get('/terms', [TermsController::class, 'index'])->name('terms');
Route::get('/cookie-policy', [CookiePolicyController::class, 'index'])->name('cookie.policy');

Route::get('/support', [SupportController::class, 'index'])->name('support');
Route::post('/support/contact', [SupportController::class, 'contact'])->name('support.contact');
Route::get('/status', [StatusController::class, 'index'])->name('status');
Route::get('/api-reference', [ApiReferenceController::class, 'index'])->name('api.reference');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/careers', [CareersController::class, 'index'])->name('careers');
Route::post('/careers/apply', [CareersController::class, 'apply'])->name('careers.apply');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Auth routes (provided by Laravel Breeze)
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::patch('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.preferences.update');
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
