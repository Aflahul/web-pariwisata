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
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();

            $table->string('judul')->nullable();
            $table->enum('tipe_media', ['image','video'])->default('image'); // image = upload, video = url
            $table->string('file_path')->nullable();   // untuk image (path di storage/public)
            $table->string('video_url')->nullable();   // untuk video (YouTube/Vimeo link)
            $table->longText('deskripsi')->nullable();

            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
