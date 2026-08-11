<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('web_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->text('msg');
            $table
                ->tinyInteger('is_seen')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->unsignedBigInteger('job_task_id')->nullable();
            $table
                ->enum('notification_type', [
                    'view_profile',
                    'accept_application',
                    'new_post',
                    'new_job',
                ])
                ->default('new_job');
            $table->unsignedBigInteger('viewer_id')->nullable();
            $table->unsignedBigInteger('viewed_user_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_notifications');
    }
};
