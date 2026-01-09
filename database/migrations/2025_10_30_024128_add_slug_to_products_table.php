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
        Schema::table('products', function (Blueprint $table) {
            // Menambahkan kolom 'slug' dengan batasan unique,
            // dan ditempatkan setelah kolom 'name'.
            // Slug dibuat nullable karena kita akan mengisinya melalui Model/Controller,
            // tidak melalui input user secara langsung, dan mungkin ada data lama.
            $table->string('slug')->unique()->nullable()->after('name');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menghapus kolom 'slug'
            $table->dropColumn('slug');
        });
    }
};
