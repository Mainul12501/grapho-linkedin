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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('subscription_plan_id')->nullable();
            $table->unsignedBigInteger('employer_company_id')->nullable();

            $table->string('mobile')->nullable()->unique();
            $table->enum('user_type', [
                    'employee',
                    'employer',
                    'sub_employer',
                    'super_admin',
                    'admin',
                    'user',
                ])->default('employee')->nullable();
            $table->string('provider')->nullable();
            $table->text('provider_id')->nullable();
            $table->text('provider_token')->nullable();
            $table->text('google_id')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('subscription_started_from')->nullable();
            $table->string('subscription_end_date')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('profile_title')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->text('fb_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->text('x_link')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('male')->nullable();
            $table->string('user_slug')->nullable();
            $table->string('dob')->nullable();
            $table->string('language')->nullable();
            $table->tinyInteger('is_open_for_hire')->default(0)->nullable();
            $table->enum('employer_agent_active_status', [
                'active',
                'inactive',
            ])->default('inactive')->nullable();

            $table->string('status')->default('active')->nullable();
            $table->tinyInteger('is_approved')->default(0)->nullable()->comment('0 = not approved, 1 = approved, 2 = rejected');
            $table->tinyInteger('subscription_system_status')->default(0)->nullable()->comment('0 = On, 1 = Off');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
