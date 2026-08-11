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
        Schema::table('job_task_university_name', function (Blueprint $table) {
            $table
                ->foreign('university_name_id')
                ->references('id')
                ->on('university_names')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('job_task_id')
                ->references('id')
                ->on('job_tasks')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_task_university_name', function (Blueprint $table) {
            $table->dropForeign(['university_name_id']);
            $table->dropForeign(['job_task_id']);
        });
    }
};
