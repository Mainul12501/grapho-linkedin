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
        Schema::create('group_calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('host_id');
            $table->string('room_id')->unique();
            $table->string('name')->nullable();
            $table->enum('call_type', ['audio', 'video'])->default('video');
            $table->enum('status', ['initiated', 'active', 'ended'])->default('initiated');
            $table->integer('max_participants')->default(10);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in seconds');
            $table->timestamps();

            $table->index('host_id');
            $table->index('status');
        });

        Schema::create('group_call_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_call_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['invited', 'joined', 'left', 'rejected'])->default('invited');
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();
            $table->timestamps();

            $table->unique(['group_call_id', 'user_id']);
            $table->index('group_call_id');
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_call_participants');
        Schema::dropIfExists('group_calls');
    }
};
