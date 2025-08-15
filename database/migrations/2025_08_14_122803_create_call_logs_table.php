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
        if (!Schema::hasTable('call_logs'))
        {
            Schema::create('call_logs', function (Blueprint $table) {
                $table->id();
                $table->string('room_name')->index();
                $table->foreignId('host_id')->constrained('users')->onDelete('cascade');
                $table->enum('type',['audio','video','both'])->default('both');
                $table->timestamp('started_at')->nullable();
                $table->timestamp('ended_at')->nullable();
                $table->json('participants')->nullable(); // store last known participants
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_logs');
    }
};
