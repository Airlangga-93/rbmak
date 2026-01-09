<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan data sebelumnya (opsional tapi aman)
        About::truncate();

        About::create([
            'vision' => 'Menjadi perusahaan pendukung industri telekomunikasi dengan pelayanan terbaik dan mampu memberi solusi yang menguntungkan bagi pelanggan.',

            'mission' => 'Memberi respon dan solusi yang cepat kepada pelanggan, meningkatkan kesejahteraan kepada karyawan, serta melakukan efisiensi dalam bekerja.',

            'goal' => null,

            'image' => 'assets/images/about/about-company.jpg',
        ]);
    }
}
