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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // 1. Relasi ke Booking (Sangat Penting agar chat tidak campur dengan pesanan lain)
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');

            // 2. Relasi ke tabel users
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');

            // 3. Isi pesan (nullable karena mungkin user hanya kirim gambar saja)
            $table->text('message')->nullable();

            // 4. Kolom Gambar (Wajib ada untuk fitur kirim file/foto)
            $table->string('image')->nullable();

            // 5. Tipe pengirim (admin/user)
            $table->enum('sender_type', ['admin', 'user'])->default('user');

            // 6. Informasi tambahan & Status baca
            $table->string('device_info')->nullable();
            $table->boolean('is_read')->default(false);

            $table->timestamps();

            // Indexing untuk mempercepat query
            $table->index(['booking_id', 'sender_id', 'receiver_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
