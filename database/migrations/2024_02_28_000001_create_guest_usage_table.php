<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_usage', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('session_id');
            $table->unsignedInteger('usage_count')->default(0);
            $table->timestamp('last_reset')->useCurrent();
            $table->timestamps();
            
            $table->index(['ip_address', 'session_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_used_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_usage');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_used_at');
        });
    }
};
