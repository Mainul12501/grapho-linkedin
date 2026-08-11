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
        Schema::table('employee_educations', function (Blueprint $table) {
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('education_degree_name_id')
                ->references('id')
                ->on('education_degree_names')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('university_name_id')
                ->references('id')
                ->on('university_names')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('field_of_study_id')
                ->references('id')
                ->on('field_of_studies')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('main_subject_id')
                ->references('id')
                ->on('education_subject_names')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_educations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['education_degree_name_id']);
            $table->dropForeign(['university_name_id']);
            $table->dropForeign(['field_of_study_id']);
            $table->dropForeign(['main_subject_id']);
        });
    }
};
