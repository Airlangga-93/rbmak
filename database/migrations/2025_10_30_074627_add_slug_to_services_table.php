<?php
// database/migrations/*_add_slug_to_services_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Tambahkan kolom 'slug', setelah kolom 'name', dan buat unique
            $table->string('slug')->after('name')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Drop kolom 'slug' saat rollback
            $table->dropColumn('slug');
        });
    }
};
