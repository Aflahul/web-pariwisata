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
        Schema::create('informasi_daerah', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();          // Judul utama
            $table->string('subtitle')->nullable();       // Subjudul opsional
            $table->longText('content')->nullable();      // Isi lengkap
            $table->string('image')->nullable();          // Gambar hero / ilustrasi
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_daerahs');
    }
};
