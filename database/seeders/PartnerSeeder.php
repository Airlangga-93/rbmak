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
        // Kosongkan tabel sebelum mengisi data baru untuk menghindari duplikasi
        DB::table('partners')->truncate();

        // 1. DATA TOWER PROVIDER (Sesuai gambar folder 'tower provider')
        $towerProviders = [
            [
                'name' => 'PT. Daya Mitra Telekomunikasi',
                'logo' => 'assets/img/tower-provider/pt-daya-mitra-telekomunikasi.png',
            ],
            [
                'name' => 'PT. Infraco Daya Mitra',
                'logo' => 'assets/img/tower-provider/pt-infraco-daya-mitra.png',
            ],
            [
                'name' => 'PT. Koperasi Jasa Daya Mitra',
                'logo' => 'assets/img/tower-provider/pt-koperasi-jasa-daya-mitra.png',
            ],
            [
                'name' => 'PT. Persada Sokka Tama',
                'logo' => 'assets/img/tower-provider/pt-persada-sokka-tama.png',
            ],
            [
                'name' => 'PT. Solusi Tunas Pratama Tbk',
                'logo' => 'assets/img/tower-provider/pt-tunas-pratama-tbk.png',
            ],
            [
                'name' => 'PT. Tower Bersama Infrastructure Tbk',
                'logo' => 'assets/img/tower-provider/pt-tower-bersama-infrastructure-tbk.png',
            ],
        ];

        // 2. DATA NON TOWER PROVIDER (Sesuai gambar folder 'non tower provider')
        $nonTowerProviders = [
            [
                'name' => 'PT. Akurasi Konstruksi Indonesia',
                'logo' => 'assets/img/non-tower-provider/pt-akurasi-konstruksi-indonesia.png',
            ],
            [
                'name' => 'PT. Duta Solusi Metalindo',
                'logo' => 'assets/img/non-tower-provider/pt-duta-solusi-metalindo.png',
            ],
            [
                'name' => 'PT. Quadran Empat Persada',
                'logo' => 'assets/img/non-tower-provider/pt-quadran-empat-persada.jpg',
            ],
            [
                'name' => 'CV. Cahaya Abadi Teknik',
                'logo' => 'assets/img/non-tower-provider/pt-akurasi-konstruksi-indonesia.png', // Fallback jika file belum ada
            ],
            [
                'name' => 'PT. Dwi Pari Abadi',
                'logo' => 'assets/img/non-tower-provider/pt-duta-solusi-metalindo.png', // Fallback jika file belum ada
            ],
            [
                'name' => 'PT. Sayap Sembilan Satu',
                'logo' => 'assets/img/non-tower-provider/pt-quadran-empat-persada.jpg', // Fallback jika file belum ada
            ],
        ];

        $partners = [];

        // Gabungkan data Tower Providers
        foreach ($towerProviders as $item) {
            $partners[] = [
                'name'              => $item['name'],
                'slug'              => Str::slug($item['name']),
                'description'       => 'Penyedia infrastruktur menara telekomunikasi terkemuka yang mendukung konektivitas digital di Indonesia.',
                'logo'              => $item['logo'],
                'sector'            => 'Tower Provider',
                'city'              => 'Jakarta',
                'company_contact'   => '-',
                'publisher'         => 'Admin',
                'partnership_date'  => Carbon::now()->subYears(rand(1, 5)),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ];
        }

        // Gabungkan data Non Tower Providers
        foreach ($nonTowerProviders as $item) {
            $partners[] = [
                'name'              => $item['name'],
                'slug'              => Str::slug($item['name']),
                'description'       => 'Mitra strategis dalam penyediaan solusi konstruksi, engineering, dan pemeliharaan infrastruktur industri.',
                'logo'              => $item['logo'],
                'sector'            => 'Non Tower Provider',
                'city'              => 'Jakarta/Bogor',
                'company_contact'   => '-',
                'publisher'         => 'Admin',
                'partnership_date'  => Carbon::now()->subYears(rand(1, 3)),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ];
        }

        // Eksekusi Insert ke Database
        DB::table('partners')->insert($partners);
    }
}