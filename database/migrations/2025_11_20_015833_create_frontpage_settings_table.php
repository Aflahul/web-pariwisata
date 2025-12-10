<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('frontpage_settings', function (Blueprint $table) {
            $table->id();

            // HERO SECTION
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();

            // WELCOME SECTION
            $table->string('welcome_title')->nullable();
            $table->text('welcome_text')->nullable();
            $table->string('welcome_image')->nullable();

            // PANDUAN WISATA
            $table->string('guide1_title')->nullable();
            $table->text('guide1_text')->nullable();
            $table->string('guide2_title')->nullable();
            $table->text('guide2_text')->nullable();
            $table->string('guide3_title')->nullable();
            $table->text('guide3_text')->nullable();

            // SLIDER DESTINASI
            $table->json('slider')->nullable();

            // FOOTER & KONTAK
            $table->string('contact_address')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();

            // LOGO & FAVICON
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frontpage_settings');
    }
};
