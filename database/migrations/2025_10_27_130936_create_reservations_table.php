<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Pemesan)
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Data pesanan
            $table->text('services'); // Menyimpan list layanan/barang

            // Menggunakan decimal (15,2) sudah tepat untuk uang
            $table->decimal('total_price', 15, 2)->default(0);

            // Jadwal
            $table->date('date');
            $table->string('time');

            // Catatan dari pembeli
            $table->text('note')->nullable();

            /** * PERBAIKAN STATUS & CHAT LOGIC
             */
            // Gunakan enum atau string untuk status agar konsisten
            $table->string('status')->default('pending');

            // Tambahan: Flag untuk mengetahui apakah ada pesan baru (Logika WA)
            // 'customer' berarti customer baru nge-chat, admin harus balas.
            // 'admin' berarti admin sudah balas terakhir kali.
            $table->enum('last_message_from', ['customer', 'admin'])->nullable();

            // Catatan internal admin (Opsional, untuk pengingat admin saja)
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Hapus tabel saat rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
