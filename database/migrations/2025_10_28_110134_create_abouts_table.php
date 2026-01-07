<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * Membuat tabel 'abouts' untuk menyimpan Visi, Misi, Tujuan, dan Gambar.
     */
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();

            // Menggunakan text() karena konten Visi/Misi/Tujuan bisa panjang.
            // Menggunakan nullable() agar sesuai dengan aturan validasi di Controller.
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('goal')->nullable();

            // Menggunakan string untuk path gambar. Menggunakan nullable() karena opsional.
            // Panjang string default Laravel (255) sudah cukup untuk path storage.
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * Menghapus tabel 'abouts' jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
