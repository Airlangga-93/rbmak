<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Matikan Foreign Key Checks agar truncate tidak error
        if (config('database.default') === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // 2. Kosongkan Tabel
        Gallery::truncate();

        // 3. Hidupkan kembali Foreign Key Checks
        if (config('database.default') === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // 4. Masukkan Data (Hanya Judul dan Gambar)
        Gallery::create([
            'title' => 'Pengerjaan Kontraktor Listrik',
            'image' => 'gallery/kontraktor-listrik.jpg',
        ]);

        Gallery::create([
            'title' => 'Inspeksi Lapangan OIP',
            'image' => 'gallery/oip.jpg',
        ]);

        Gallery::create([
            'title' => 'Tim Profesional Proyek Konstruksi',
            'image' => 'gallery/profesi-profesi-dalam-proyek-konstruksi.jpg',
        ]);
    }
}
