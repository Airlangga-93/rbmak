<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel sebelum mengisi data baru
        DB::table('partners')->truncate();

        // Data Tower Provider
        $towerProviders = [
            [
                'name' => 'PT. Daya Mitra Telekomunikasi',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower provider/PT. Daya Mitra Telekomunikasi.png',
            ],
            [
                'name' => 'PT. Infraco Daya Mitra',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower provider/PT. Infraco Daya Mitra.png',
            ],
            [
                'name' => 'PT. Koperasi Jasa Daya Mitra',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower provider/PT. Koperasi Jasa Daya Mitra.png',
            ],
            [
                'name' => 'PT. Persada Sokka Tama',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower provider/PT. Persada Sokka Tama.png',
            ],
            [
                'name' => 'PT. Solusi Tunas Pratama Tbk',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower provider/PT. Solusi Tunas Pratama Tbk.png',
            ],
            [
                'name' => 'PT. Tower Bersama Infrastructure Tbk',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower provider/PT. Tower Bersama Infrastructure Tbk.png',
            ],
        ];

        // Data Non Tower Provider
        $nonTowerProviders = [
            [
                'name' => 'PT. Akurasi Konstruksi Indonesia',
                'city' => 'Bogor',
                'logo' => 'assets/img/non tower provider/pt akurasi konstruksi indonesia.png',
            ],
            [
                'name' => 'PT. Duta Solusi Metalindo',
                'city' => 'Jakarta',
                'logo' => 'assets/img/non tower provider/PT. Duta Solusi Metalindo.png',
            ],
            [
                'name' => 'PT. Quadran Empat Persada',
                'city' => 'Jakarta',
                'logo' => 'assets/img/non tower provider/PT. Quadran Empat Persada.jpg',
            ],
            [
                'name' => 'CV. Cahaya Abadi Teknik',
                'city' => 'Bogor',
                'logo' => 'assets/img/image.png',
            ],
            [
                'name' => 'PT. Dwi Pari Abadi',
                'city' => 'Jakarta',
                'logo' => 'assets/img/image.png',
            ],
            [
                'name' => 'CV. Raja Ardana Interior',
                'city' => 'Bogor',
                'logo' => 'assets/img/image.png',
            ],
            [
                'name' => 'PT. Sayap Sembilan Satu',
                'city' => 'Bogor',
                'logo' => 'assets/img/image.png',
            ],
            [
                'name' => 'PT. Surya Anugerah Enjinering',
                'city' => 'Jakarta',
                'logo' => 'assets/img/image.png',
            ],
        ];

        $partners = [];

        // Mapping data Tower Provider ke format database
        foreach ($towerProviders as $item) {
            $partners[] = [
                'name'              => $item['name'],
                'slug'              => Str::slug($item['name']),
                'description'       => 'Perusahaan penyedia infrastruktur tower telekomunikasi yang mendukung jaringan komunikasi nasional.',
                'logo'              => $item['logo'],
                'sector'            => 'Tower Provider',
                'city'              => $item['city'],
                'company_contact'   => '-', // Default jika kosong
                'publisher'         => 'Admin',
                'partnership_date'  => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ];
        }

        // Mapping data Non Tower Provider ke format database
        foreach ($nonTowerProviders as $item) {
            $partners[] = [
                'name'              => $item['name'],
                'slug'              => Str::slug($item['name']),
                'description'       => 'Perusahaan pendukung non tower yang bergerak di bidang konstruksi, engineering, dan penyedia solusi industri.',
                'logo'              => $item['logo'],
                'sector'            => 'Non Tower Provider',
                'city'              => $item['city'],
                'company_contact'   => '-', // Default jika kosong
                'publisher'         => 'Admin',
                'partnership_date'  => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ];
        }

        // Eksekusi insert massal
        DB::table('partners')->insert($partners);
    }
}
