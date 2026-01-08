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
                'logo' => 'assets/img/tower-provider/pt-daya-mitra-telekomunikasi.png',
            ],
            [
                'name' => 'PT. Infraco Daya Mitra',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower-provider/pt-infraco-daya-mitra.png',
            ],
            [
                'name' => 'PT. Koperasi Jasa Daya Mitra',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower-provider/pt-koperasi-jasa-daya-mitra.png',
            ],
            [
                'name' => 'PT. Persada Sokka Tama',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower-provider/pt-persada-sokka-tama.png',
            ],
            [
                'name' => 'PT. Solusi Tunas Pratama Tbk',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower-provider/pt-tunas-pratama-tbk.png',
            ],
            [
                'name' => 'PT. Tower Bersama Infrastructure Tbk',
                'city' => 'Jakarta',
                'logo' => 'assets/img/tower-provider/pt-tower-bersama-infrastructure-tbk.png',
            ],
        ];

        // Data Non Tower Provider
        $nonTowerProviders = [
            [
                'name' => 'PT. Akurasi Konstruksi Indonesia',
                'city' => 'Bogor',
                'logo' => 'assets/img/non-tower-provider/pt-akurasi-konstruksi-indonesia.png',
            ],
            [
                'name' => 'PT. Duta Solusi Metalindo',
                'city' => 'Jakarta',
                'logo' => 'assets/img/non-tower-provider/pt-duta-solusi-metalindo.png',
            ],
            [
                'name' => 'PT. Quadran Empat Persada',
                'city' => 'Jakarta',
                'logo' => 'assets/img/non-tower-provider/pt-quadran-empat-persada.jpg',
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

        foreach ($towerProviders as $item) {
            $partners[] = [
                'name'              => $item['name'],
                'slug'              => Str::slug($item['name']),
                'description'       => 'Perusahaan penyedia infrastruktur tower telekomunikasi yang mendukung jaringan komunikasi nasional.',
                'logo'              => $item['logo'],
                'sector'            => 'Tower Provider',
                'city'              => $item['city'],
                'company_contact'   => '-',
                'publisher'         => 'Admin',
                'partnership_date'  => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ];
        }

        foreach ($nonTowerProviders as $item) {
            $partners[] = [
                'name'              => $item['name'],
                'slug'              => Str::slug($item['name']),
                'description'       => 'Perusahaan pendukung non tower yang bergerak di bidang konstruksi, engineering, dan penyedia solusi industri.',
                'logo'              => $item['logo'],
                'sector'            => 'Non Tower Provider',
                'city'              => $item['city'],
                'company_contact'   => '-',
                'publisher'         => 'Admin',
                'partnership_date'  => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ];
        }

        DB::table('partners')->insert($partners);
    }
}