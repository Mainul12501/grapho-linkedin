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
            $table->text('device_token')->nullable()->after('remember_token');
            $table->enum('device_platform', ['ios', 'android', 'web'])->nullable()->after('device_token');
            $table->boolean('is_online')->default(false)->after('device_platform');
            $table->timestamp('last_seen')->nullable()->after('is_online');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['device_token', 'device_platform', 'is_online', 'last_seen']);
        });
    }
};
