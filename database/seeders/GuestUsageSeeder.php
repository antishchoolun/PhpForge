<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestUsage;

class GuestUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test guest with no usage
        GuestUsage::create([
            'ip_address' => '127.0.0.1',
            'session_id' => 'test-session-1',
            'usage_count' => 0,
            'last_reset' => now(),
        ]);

        // Create a test guest with some usage
        GuestUsage::create([
            'ip_address' => '127.0.0.1',
            'session_id' => 'test-session-2',
            'usage_count' => 3,
            'last_reset' => now(),
        ]);

        // Create a test guest that has reached the limit
        GuestUsage::create([
            'ip_address' => '127.0.0.1',
            'session_id' => 'test-session-3',
            'usage_count' => 5,
            'last_reset' => now(),
        ]);

        // Create a test guest that needs reset (yesterday's usage)
        GuestUsage::create([
            'ip_address' => '127.0.0.1',
            'session_id' => 'test-session-4',
            'usage_count' => 5,
            'last_reset' => now()->subDay(),
        ]);
    }
}
