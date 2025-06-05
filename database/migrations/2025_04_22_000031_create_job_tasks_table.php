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
        Schema::create('job_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_title');
            $table->unsignedBigInteger('job_type_id');
            $table->unsignedBigInteger('job_location_type_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employer_company_id');
            $table->string('required_experience')->nullable();
            $table
                ->enum('job_pref_salary_payment_type', [
                    'hourly',
                    'monthly',
                    'yearly',
                    'fixed',
                ])
                ->default('monthly')
                ->nullable();
            $table->string('salary_amount')->nullable();
            $table
                ->float('salary_range_start', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->float('salary_range_end', 10, 2)
                ->default(0)
                ->nullable();
            $table->longText('description')->nullable();
            $table->string('deadline')->nullable();
            $table->string('require_sector_looking_for')->nullable();
            $table->text('slug')->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->string('banner_image')->nullable();
            $table->string('cgpa')->nullable();
            $table->text('university_preference')->nullable();
            $table->text('field_of_study_preference')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_tasks');
    }
};
