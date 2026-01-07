<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Reset data
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        /*
        |--------------------------------------------------------------------------
        | PRODUK BARANG
        |--------------------------------------------------------------------------
        */
        $produkBarang = [
            [
                'name' => 'Transportable BTS ( Combat )',
                'description' => 'Unit Transportable BTS (Combat) untuk kebutuhan jaringan sementara maupun darurat dengan standar industri telekomunikasi.',
                'price' => 250000000,
                'image' => 'assets/img/produk barang/Transportable BTS Combat.jpeg',
            ],
            [
                'name' => 'Tower On Trailer',
                'description' => 'Tower mobile berbasis trailer yang fleksibel untuk deployment cepat di berbagai medan.',
                'price' => 300000000,
                'image' => 'assets/img/produk barang/Tower On Trailer.jpg',
            ],
            [
                'name' => 'Truck Head Transporter Combat',
                'description' => 'Kendaraan transporter khusus untuk mobilisasi unit BTS Combat secara aman dan efisien.',
                'price' => 450000000,
                'image' => 'assets/img/produk barang/Truck Head ransporter Combat.png',
            ],
            [
                'name' => 'Guyed Mast Tower',
                'description' => 'Menara guyed mast dengan sistem penyangga kabel untuk kestabilan dan efisiensi struktur.',
                'price' => 180000000,
                'image' => 'assets/img/produk barang/Guyed Mast Tower.jpg',
            ],
            [
                'name' => 'Monopole',
                'description' => 'Tower monopole dengan desain ramping dan estetis untuk area urban.',
                'price' => 220000000,
                'image' => 'assets/img/produk barang/Monopole.jpg',
            ],
            [
                'name' => 'Perkuatan Tower SST dan Monopole',
                'description' => 'Solusi perkuatan struktur tower SST dan monopole untuk meningkatkan keamanan dan daya tahan.',
                'price' => 150000000,
                'image' => 'assets/img/produk barang/Perkuatan Tower SST dan Monopole.jpg',
            ],
            [
                'name' => 'Steel Structure Produk',
                'description' => 'Produk struktur baja berkualitas tinggi untuk kebutuhan industri dan infrastruktur.',
                'price' => 120000000,
                'image' => 'assets/img/produk barang/Steel Structure Produk.jpg',
            ],
            [
                'name' => 'Sheet Metal Produk',
                'description' => 'Produk sheet metal presisi tinggi untuk berbagai kebutuhan teknis.',
                'price' => 90000000,
                'image' => 'assets/img/produk barang/Sheet Metal Produk.jpg',
            ],
            [
                'name' => 'Arsitektur & Furniture',
                'description' => 'Produk arsitektur dan furniture berbahan logam dengan desain modern dan fungsional.',
                'price' => 75000000,
                'image' => 'assets/img/produk barang/Arsitektur & Furniture.jpeg',
            ],
            [
                'name' => 'Work Aid Tools',
                'description' => 'Peralatan pendukung kerja untuk operasional lapangan dan instalasi.',
                'price' => 50000000,
                'image' => 'assets/img/produk barang/Work Aid Tools.png',
            ],
        ];

        foreach ($produkBarang as $item) {
            Product::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'type' => 'barang',
                'price' => $item['price'],
                'image' => $item['image'],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PRODUK JASA
        |--------------------------------------------------------------------------
        */
        $produkJasa = [
            [
                'name' => 'Service & Maintenance Transportable BTS ( Combat )',
                'description' => 'Layanan perawatan dan servis rutin BTS Combat agar tetap optimal dan siap operasional.',
                'price' => 50000000,
                'image' => 'assets/img/produk jasa/Service & Maintenance Transportable BTS ( Combat ).jpeg',
            ],
            [
                'name' => 'Service & Maintenance Guyed Mast tower',
                'description' => 'Perawatan berkala tower guyed mast untuk menjaga kestabilan dan keamanan struktur.',
                'price' => 40000000,
                'image' => 'assets/img/produk jasa/Service & Maintenance Guyed Mast tower.jpeg',
            ],
            [
                'name' => 'Service & Maintenance Truck Head',
                'description' => 'Servis kendaraan transporter combat untuk memastikan kelancaran mobilisasi.',
                'price' => 30000000,
                'image' => 'assets/img/produk jasa/Service & Maintenance Truck Head.jpg',
            ],
            [
                'name' => 'Delivery, Instalasi & Dismantel Combat & Guyed Mast',
                'description' => 'Layanan pengiriman, pemasangan, dan pembongkaran tower dan BTS sesuai standar keselamatan.',
                'price' => 60000000,
                'image' => 'assets/img/produk jasa/Delivery, Instalasi & Dismantel Combat & Guyed Mast.jpg',
            ],
            [
                'name' => 'Permanenisasi Combat',
                'description' => 'Proses permanenisasi BTS Combat menjadi instalasi jangka panjang.',
                'price' => 80000000,
                'image' => 'assets/img/produk jasa/Permanenisasi Combat.jpeg',
            ],
            [
                'name' => 'Relokasi Perangkat',
                'description' => 'Layanan pemindahan perangkat telekomunikasi secara aman dan terencana.',
                'price' => 45000000,
                'image' => 'assets/img/produk jasa/Relokasi Perangkat.jpeg',
            ],
            [
                'name' => 'Collocation CME',
                'description' => 'Layanan collocation CME untuk optimalisasi penggunaan infrastruktur tower.',
                'price' => 70000000,
                'image' => 'assets/img/produk jasa/Collocation CME.jpeg',
            ],
            [
                'name' => 'Desain Engineering',
                'description' => 'Perencanaan dan desain engineering sesuai kebutuhan proyek dan standar teknis.',
                'price' => 55000000,
                'image' => 'assets/img/produk jasa/Desain Engineering.jpg',
            ],
            [
                'name' => 'Machining',
                'description' => 'Layanan machining presisi tinggi untuk komponen industri dan telekomunikasi.',
                'price' => 65000000,
                'image' => 'assets/img/produk jasa/Machining.webp',
            ],
        ];

        foreach ($produkJasa as $item) {
            Product::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'type' => 'jasa',
                'price' => $item['price'],
                'image' => $item['image'],
            ]);
        }
    }
}
