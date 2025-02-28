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

    protected function setUp(): void
    {
        parent::setUp();
        
        // Enable session handling for testing
        $this->withSession([]);
        
        // Register test route with middleware
        Route::middleware(['web', TrackUsage::class])
            ->post('/test/generate', [TestController::class, 'generate'])
            ->name('test.generate');
    }

    public function test_guest_can_use_tools_within_limits(): void
    {
        $response = $this->postJson('/test/generate', [
            'prompt' => 'Test prompt'
        ]);

        $response->assertStatus(200);
        
        $guestUsage = GuestUsage::first();
        $this->assertEquals(1, $guestUsage->usage_count);
    }

    public function test_guest_cannot_exceed_daily_limit(): void
    {
        // Create a guest that has reached the limit
        GuestUsage::create([
            'ip_address' => '127.0.0.1',
            'session_id' => session()->getId(),
            'usage_count' => 5,
            'last_reset' => now(),
        ]);

        $response = $this->postJson('/test/generate', [
            'prompt' => 'Test prompt'
        ]);

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
            'session_id' => session()->getId(),
            'usage_count' => 5,
            'last_reset' => now()->subDay(),
        ]);

        $response = $this->postJson('/test/generate', [
            'prompt' => 'Test prompt'
        ]);

        $response->assertStatus(200);
        
        $guestUsage->refresh();
        $this->assertEquals(1, $guestUsage->usage_count);
        $this->assertTrue($guestUsage->last_reset->isToday());
    }

    public function test_registered_users_have_unlimited_access(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/test/generate', [
                'prompt' => 'Test prompt'
            ]);

        $response->assertStatus(200);
        
        // Verify no guest usage was created
        $this->assertEquals(0, GuestUsage::count());
        
        // Verify user's last_used_at was updated
        $user->refresh();
        $this->assertTrue($user->last_used_at->isToday());
    }
}
