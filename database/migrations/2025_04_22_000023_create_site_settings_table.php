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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_title')->nullable();
            $table->text('site_description')->nullable();
            $table->string('logo')->nullable();
            $table->string('site_icon')->nullable();
            $table->string('favicon')->nullable();
            $table->longText('meta_header')->nullable();
            $table->longText('meta_footer')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('banner')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->text('fb')->nullable();
            $table->text('x_link')->nullable();
            $table->text('youtube')->nullable();
            $table->text('insta')->nullable();
            $table->text('tiktalk')->nullable();
            $table->text('apk_link')->nullable();
            $table->text('ios_link')->nullable();
            $table->string('apk_latest_version')->nullable();
            $table->string('ios_latest_version')->nullable();
            $table->text('office_address')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code', 3)->nullable();
            $table->string('site_name');
            $table->tinyInteger('subscription_system_status')->default(0)->nullable()->comment('0 = On, 1 = Off');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
