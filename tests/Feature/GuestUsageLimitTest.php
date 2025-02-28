<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\GuestUsage;
use App\Http\Controllers\TestController;
use App\Http\Middleware\TrackUsage;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestUsageLimitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The test session ID.
     */
    protected string $sessionId;

    protected function setUp(): void
    {
        parent::setUp();

        // Clear any existing guest usage records
        GuestUsage::query()->delete();

        $this->sessionId = 'test-session-' . now()->timestamp;
        
        // Register test route with middleware
        Route::post('/test/generate', function () {
            return response()->json(['status' => 'success']);
        })->middleware(['web', TrackUsage::class]);
    }

    protected function tearDown(): void
    {
        // Clean up after each test
        GuestUsage::query()->delete();
        parent::tearDown();
    }

    public function test_guest_can_use_tools_within_limits(): void
    {
        $response = $this->withSession(['id' => $this->sessionId])
            ->postJson('/test/generate', ['prompt' => 'Test prompt']);

        $response->assertOk();
        
        $guestUsage = GuestUsage::where('session_id', $this->sessionId)->first();
        $this->assertNotNull($guestUsage);
        $this->assertEquals(1, $guestUsage->usage_count);
    }

    public function test_guest_cannot_exceed_daily_limit(): void
    {
        // Create a guest that has reached the limit
        GuestUsage::create([
            'ip_address' => '127.0.0.1',
            'session_id' => $this->sessionId,
            'usage_count' => 5,
            'last_reset' => now(),
        ]);

        $response = $this->withSession(['id' => $this->sessionId])
            ->postJson('/test/generate', ['prompt' => 'Test prompt']);

        $response->assertStatus(429)
            ->assertJsonStructure([
                'error',
                'message',
                'remaining_time'
            ]);
    }

    public function test_usage_resets_after_day(): void
    {
        // Create a guest with yesterday's usage
        $guestUsage = GuestUsage::create([
            'ip_address' => '127.0.0.1',
            'session_id' => $this->sessionId,
            'usage_count' => 5,
            'last_reset' => now()->subDay(),
        ]);

        $response = $this->withSession(['id' => $this->sessionId])
            ->postJson('/test/generate', ['prompt' => 'Test prompt']);

        $response->assertOk();
        
        $guestUsage->refresh();
        $this->assertEquals(1, $guestUsage->usage_count);
        $this->assertTrue($guestUsage->last_reset->isToday());
    }

    public function test_registered_users_have_unlimited_access(): void
    {
        $user = User::factory()->create(['last_used_at' => null]);

        $response = $this->actingAs($user)
            ->withSession(['id' => $this->sessionId])
            ->postJson('/test/generate', ['prompt' => 'Test prompt']);

        $response->assertStatus(200);
        
        // Verify no guest usage was created
        $this->assertEquals(0, GuestUsage::count());
        
        // Verify user's last_used_at was updated
        $user->refresh();
        $this->assertTrue($user->last_used_at->isToday());
    }
}
