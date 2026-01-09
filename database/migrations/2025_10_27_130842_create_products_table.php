<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Kolom utama produk
            $table->string('name');
            $table->text('description'); // 🛑 Diubah dari nullable menjadi wajib (sesuai validasi di Controller)

            // 🛑 KOREKSI: Tambahkan kolom 'type' (barang/jasa) dan dijadikan wajib
            // Menggunakan 'enum' untuk memastikan nilai hanya 'barang' atau 'jasa'
            $table->enum('type', ['barang', 'jasa']);

            // Kolom harga
            // Menggunakan precision 12 dan scale 0 (sesuai number_format di Blade untuk Rp tanpa desimal)
            $table->decimal('price', 12, 0);

            // Kolom gambar (nullable karena 'jasa' tidak wajib)
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
