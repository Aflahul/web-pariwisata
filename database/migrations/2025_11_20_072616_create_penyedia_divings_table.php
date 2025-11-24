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
    Schema::create('penyedia_diving', function (Blueprint $table) {
        $table->id();

        $table->string('nama');                  // Nama penyedia jasa
        $table->string('slug')->unique();        // URL SEO
        $table->string('kontak')->nullable();    // WA / telepon
        $table->string('alamat')->nullable();    // Lokasi singkat
        $table->string('maps_url')->nullable();  // Link Google Maps

        $table->json('peralatan')->nullable();   // Masker, fin, snorkel, tabung, BCD, dll.
        $table->json('paket')->nullable();       // Paket diving / harga
        $table->json('gambar')->nullable();      // Multiple image

        $table->longText('deskripsi')->nullable(); // Deskripsi lengkap
        $table->boolean('is_published')->default(true);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia_divings');
    }
};
