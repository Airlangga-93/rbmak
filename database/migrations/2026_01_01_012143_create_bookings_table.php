<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (Customer)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Data Pesanan
            $table->string('services');
            $table->date('date');
            $table->string('time');
            $table->decimal('total_price', 15, 2)->default(0);
            $table->text('note')->nullable();

            // --- LOGIKA STATUS & CHAT (WHATSAPP STYLE) ---

            // Status Booking Utama
            $table->string('status')->default('pending'); // pending, proses, selesai, batal

            // Balasan Admin (Chat Content)
            $table->text('admin_note')->nullable();

            // Penanda: Siapa yang terakhir ngirim pesan?
            // Ini penting untuk filter 'Belum Dibalas' di Dashboard Admin
            $table->enum('last_reply_by', ['user', 'admin'])->default('user');

            // Status Baca: Apakah admin sudah melihat pesan baru dari user?
            $table->boolean('is_read_by_admin')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
