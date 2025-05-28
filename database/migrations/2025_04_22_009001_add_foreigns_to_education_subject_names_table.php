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
        Schema::table('education_subject_names', function (Blueprint $table) {
            $table
                ->foreign('field_of_study_id')
                ->references('id')
                ->on('field_of_studies')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_subject_names', function (Blueprint $table) {
            $table->dropForeign(['field_of_study_id']);
        });
    }
};
