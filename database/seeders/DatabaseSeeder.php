<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            ProductSeeder::class,
            FacilitySeeder::class,
            ImageSeeder::class,
                // Tambahkan PartnerSeeder di bawah ini
            PartnerSeeder::class,
            UpdateNewsSlugsSeeder::class,
        ]);
    }
}
