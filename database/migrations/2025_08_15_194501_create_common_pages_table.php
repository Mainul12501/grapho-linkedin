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
        Schema::create('common_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->nullable();
            $table->text('title');
            $table->string('main_image')->nullable();
            $table->longText('content')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->longText('seo_header')->nullable();
            $table->longText('seo_footer')->nullable();
            $table->text('slug')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_pages');
    }
};
