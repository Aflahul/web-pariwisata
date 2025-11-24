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
        Schema::create('akomodasi', function (Blueprint $table) {
            $table->id();

            $table->string('nama');                    // Nama penginapan
            $table->string('slug')->unique();          // URL SEO
            $table->string('tipe')->nullable();        // Hotel / Homestay / Guesthouse
            $table->string('alamat')->nullable();      // Alamat singkat
            $table->string('telepon')->nullable();     // Kontak telepon
            $table->string('price_range')->nullable(); // Kisaran harga (opsional)
            $table->string('maps_url')->nullable();    // Link Google Maps (opsional)

            $table->text('excerpt')->nullable();       // Ringkasan
            $table->longText('deskripsi')->nullable(); // Deskripsi lengkap

            $table->json('fasilitas')->nullable();    // JSON array fasilitas (wifi, ac, sarapan, dll.)
            $table->json('images')->nullable();        // JSON array gambar
            $table->boolean('is_published')->default(true);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akomodasis');
    }
};
