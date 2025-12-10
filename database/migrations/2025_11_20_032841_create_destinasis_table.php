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
        Schema::create('destinasi', function (Blueprint $table) {
            $table->id();

            $table->string('nama');                       // Nama destinasi
            $table->string('slug')->unique();             // URL SEO
            $table->string('kategori')->nullable();       // Pantai, Budaya, Diving, dll
            $table->string('lokasi')->nullable();         // Lokasi singkat
            $table->string('maps_url')->nullable();       // Link Google Maps (aman)

            $table->text('excerpt')->nullable();          // Ringkasan untuk list
            $table->longText('deskripsi')->nullable();    // Deskripsi lengkap

            $table->json('gambar')->nullable();           // Banyak gambar (JSON)
            $table->boolean('unggulan')->default(false);  // Untuk slider homepage

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasis');
    }
};
