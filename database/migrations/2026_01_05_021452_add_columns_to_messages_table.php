<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // 1. Tambahkan booking_id sebagai nullable() terlebih dahulu agar SQLite mau menerimanya
            if (!Schema::hasColumn('messages', 'booking_id')) {
                $table->foreignId('booking_id')->nullable()->after('id')->constrained('bookings')->onDelete('cascade');
            }

            // 2. Tambahkan kolom image
            if (!Schema::hasColumn('messages', 'image')) {
                $table->string('image')->nullable()->after('message');
            }

            // 3. Ubah message menjadi nullable
            $table->text('message')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Untuk SQLite, drop foreign key harus hati-hati, biasanya cukup drop column
            $table->dropColumn(['booking_id', 'image']);
        });
    }
};
