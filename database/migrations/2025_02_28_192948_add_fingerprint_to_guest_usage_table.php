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
Schema::table('guest_usage', function (Blueprint $table) {
// Make fingerprint required since we always generate one
$table->string('fingerprint', 64)->after('session_id');

        // Add individual indexes for flexible querying
        $table->index('fingerprint');
        $table->index('ip_address');
        
        // Add compound index for the common lookup case
        $table->index(['ip_address', 'fingerprint'], 'guest_usage_lookup_index');
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('guest_usage', function (Blueprint $table) {
        $table->dropIndex('guest_usage_lookup_index');
        $table->dropIndex(['fingerprint']);
        $table->dropIndex(['ip_address']);
        $table->dropColumn('fingerprint');
    });
}
};