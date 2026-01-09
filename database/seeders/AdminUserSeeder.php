<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Data Admin 1
        User::updateOrCreate(
            ['email' => 'iqbaliqbalnew15286@gmail.com'],
            [
                'name' => 'ADMIN PT RIZQALLAH BOER MAKMUR',
                'password' => Hash::make('tower123'),
                'role' => 'admin', // TAMBAHKAN INI
                'email_verified_at' => now(),
            ]
        );

        // Data Admin 2 (Tambahan)
        User::updateOrCreate(
            ['email' => 'admin.sayap91@gmail.com'],
            [
                'name' => 'Support Tower',
                'password' => Hash::make('sayap91jaya'),
                'role' => 'admin', // TAMBAHKAN INI
                'email_verified_at' => now(),
            ]
        );
    }
}
