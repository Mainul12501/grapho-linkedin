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
        Schema::create('employee_work_experiences', function (
            Blueprint $table
        ) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('title');
            $table->string('company_name');
            $table->string('position')->nullable();
            $table->text('job_responsibilities')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->text('office_address')->nullable();
            $table->string('duration')->nullable();
            $table
                ->tinyInteger('is_working_currently')
                ->default(0)
                ->nullable();
            $table
                ->enum('job_type', ['full_time', 'part_time', 'contructual'])
                ->default('full_time')
                ->nullable();
            $table->tinyInteger('status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_work_experiences');
    }
};
