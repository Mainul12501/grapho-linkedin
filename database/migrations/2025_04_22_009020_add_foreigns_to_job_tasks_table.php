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
        Schema::table('job_tasks', function (Blueprint $table) {
            $table
                ->foreign('job_type_id')
                ->references('id')
                ->on('job_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('job_location_type_id')
                ->references('id')
                ->on('job_location_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('employer_company_id')
                ->references('id')
                ->on('employer_companies')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_tasks', function (Blueprint $table) {
            $table->dropForeign(['job_type_id']);
            $table->dropForeign(['job_location_type_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['employer_company_id']);
        });
    }
};
