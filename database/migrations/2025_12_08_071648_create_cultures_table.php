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
    Schema::create('cultures', function (Blueprint $table) {
        $table->id();

        // kategori/jenis budaya (enum agar konsisten)
        $table->enum('jenis', [
            'tradisi',
            'adat',
            'tarian',
            'musik',
            'kuliner',
            'kerajinan',
            'sejarah'
        ]);

        $table->string('judul');
        $table->string('ringkasan');
        $table->text('deskripsi');
        $table->string('lokasi')->nullable();

        // satu gambar saja per data budaya
        $table->string('gambar')->nullable();;

        // publish = 1, draft = 0
        $table->boolean('status')->default(1);

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultures');
    }
};
