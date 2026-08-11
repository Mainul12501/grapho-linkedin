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
        Schema::create('send_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->string('send_user_type')->default('all')->comment('all, employee, employer, admin, user');
            $table->text('msg');
            $table->enum('method', ['mobile', 'email', 'all'])->default('email');
            $table->tinyInteger('status')->default(1);
            $table->integer('send_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_notifications');
    }
};
