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
        Schema::create('chatify_deleted_conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // User who deleted the conversation
            $table->unsignedBigInteger('contact_id'); // The other user in the conversation
            $table->timestamp('deleted_at')->nullable(); // When the conversation was deleted
            $table->timestamps();

            // Composite unique index to prevent duplicate entries
            $table->unique(['user_id', 'contact_id']);

            // Indexes for faster queries
            $table->index('user_id');
            $table->index('contact_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatify_deleted_conversations');
    }
};
