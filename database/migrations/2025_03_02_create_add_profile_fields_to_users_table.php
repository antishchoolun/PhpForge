<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('preferred_language')->default('php');
            $table->integer('api_requests_count')->default(0);
            $table->json('tool_preferences')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'timezone',
                'preferred_language',
                'api_requests_count',
                'tool_preferences'
            ]);
        });
    }
};
