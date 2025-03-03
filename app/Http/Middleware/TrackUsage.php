<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\GuestUsage;
use Illuminate\Support\Facades\Auth;

class TrackUsage
{
public function handle(Request $request, Closure $next)
{
// Skip tracking for non-tool routes
if (!$this->isToolRoute($request)) {
return $next($request);
}

    // If user is authenticated, just update last_used_at and continue
    if (Auth::check()) {
        Auth::user()->update(['last_used_at' => now()]);
        return $next($request);
    }

    $guestUsage = $this->getOrCreateGuestUsage($request);
    $guestUsage->resetIfNeeded();

    if ($guestUsage->hasReachedLimit()) {
        return response()->json([
            'error' => 'Daily limit reached',
            'message' => 'You have reached the daily limit of 5 requests. Please register for unlimited access.',
            'remaining_time' => now()->endOfDay()->diffForHumans(),
        ], 429);
    }

    // Track the usage
    $guestUsage->incrementUsage();

    $response = $next($request);

    // Add remaining requests info to response headers
    $remaining = 5 - $guestUsage->usage_count;
    $response->headers->set('X-RateLimit-Remaining', $remaining);
    $response->headers->set('X-RateLimit-Reset', now()->endOfDay()->timestamp);

    return $response;
}

protected function generateFingerprint(Request $request)
{
    // Collect browser data
    $data = [
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'accept_language' => $request->header('Accept-Language'),
        'accept_encoding' => $request->header('Accept-Encoding'),
        'accept' => $request->header('Accept'),
        'connection' => $request->header('Connection'),
    ];

    // Generate a unique fingerprint
    return hash('sha256', json_encode($data));
}

protected function getOrCreateGuestUsage(Request $request)
{
    $ip = $request->ip();
    $fingerprint = $this->generateFingerprint($request);
    
    // Ensure session is started
    if (!$request->hasSession()) {
        throw new \RuntimeException('Session store not set on request.');
    }
    
    // Start the session if it hasn't been started
    if (!$request->session()->isStarted()) {
        $request->session()->start();
    }
    
    // Get session ID from request or generate one
    $sessionId = $request->session()->get('id') ?? $request->session()->getId();

    // Find by both IP and fingerprint to prevent private browsing bypass
    $guestUsage = GuestUsage::where('ip_address', $ip)
        ->where('fingerprint', $fingerprint)
        ->first();

    if (!$guestUsage) {
        // Check if IP or fingerprint has been used today
        $existingUsage = GuestUsage::where(function ($query) use ($ip, $fingerprint) {
            $query->where('ip_address', $ip)
                ->orWhere('fingerprint', $fingerprint);
        })
        ->whereDate('last_reset', today())
        ->first();

        if ($existingUsage) {
            return $existingUsage;
        }

        // Create new record if none found
        $guestUsage = GuestUsage::create([
            'ip_address' => $ip,
            'session_id' => $sessionId,
            'fingerprint' => $fingerprint,
            'usage_count' => 0,
            'last_reset' => now(),
        ]);
    }

    return $guestUsage;
}

protected function isToolRoute(Request $request)
{
    // Add all tool-related routes here
    $toolRoutes = [
        'tools/generate',
        'tools/debug',
        'tools/security',
        'tools/optimize',
        'tools/document',
        'test/generate'  // Add our test route
    ];

    foreach ($toolRoutes as $route) {
        if ($request->is($route) || $request->is("api/*/$route")) {
            return true;
        }
    }

    return false;
}
}