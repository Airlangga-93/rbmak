<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset data agar tidak terjadi duplikasi saat seeding ulang
        Schema::disableForeignKeyConstraints();
        Facility::truncate();
        Schema::enableForeignKeyConstraints();

        /*
        |--------------------------------------------------------------------------
        | FASILITAS KENDARAAN
        |--------------------------------------------------------------------------
        */
        $kendaraan = [
            [
                'name' => 'Pickup',
                'description' => 'Kendaraan pickup untuk transportasi barang dan personel di area proyek.',
                'image' => 'assets/img/kendaraan/pickup.png',
                'type' => 'kendaraan',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Head Truck',
                'description' => 'Truk head untuk pengangkutan material berat dan peralatan konstruksi.',
                'image' => 'assets/img/kendaraan/head-truck.png',
                'type' => 'kendaraan',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Mini Bus',
                'description' => 'Mini bus untuk transportasi tim kerja dan kunjungan lapangan.',
                'image' => 'assets/img/kendaraan/mini-bus.jpg',
                'type' => 'kendaraan',
                'publisher' => 'PT RBM',
            ],
        ];

        foreach ($kendaraan as $item) {
            Facility::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'image' => $item['image'],
                'type' => $item['type'],
                'publisher' => $item['publisher'],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FASILITAS MAINTENANCE
        |--------------------------------------------------------------------------
        */
        $maintenance = [
            [
                'name' => 'Ampere Pliers',
                'description' => 'Tang ampere untuk pengukuran arus listrik dalam perawatan peralatan.',
                'image' => 'assets/img/maintenance/ampere-pliers.jpeg',
                'type' => 'maintenance',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Grounding Tester',
                'description' => 'Alat uji grounding untuk memastikan keselamatan instalasi listrik.',
                'image' => 'assets/img/maintenance/grounding-tester.jpg',
                'type' => 'maintenance',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Tensionmeter',
                'description' => 'Tensionmeter untuk pengukuran tegangan kabel dan struktur.',
                'image' => 'assets/img/maintenance/tensionmeter.jpg',
                'type' => 'maintenance',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Theodolite',
                'description' => 'Theodolite untuk pengukuran sudut dan survei lapangan.',
                'image' => 'assets/img/maintenance/theodolite.jpg',
                'type' => 'maintenance',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Tools Kit Maintenance',
                'description' => 'Kit peralatan lengkap untuk kegiatan maintenance dan perbaikan.',
                'image' => 'assets/img/maintenance/tools-kit-maintenance.jpg',
                'type' => 'maintenance',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Vernier Caliper',
                'description' => 'Vernier caliper untuk pengukuran presisi dimensi komponen.',
                'image' => 'assets/img/maintenance/vernier-caliper.jpg',
                'type' => 'maintenance',
                'publisher' => 'PT RBM',
            ],
        ];

        foreach ($maintenance as $item) {
            Facility::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'image' => $item['image'],
                'type' => $item['type'],
                'publisher' => $item['publisher'],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FASILITAS PABRIKASI
        |--------------------------------------------------------------------------
        */
        $pabrikasi = [
            [
                'name' => 'Mesin Drilling Magnet',
                'description' => 'Mesin drilling magnet untuk pembuatan lubang presisi pada logam.',
                'image' => 'assets/img/pabrikasi/mesin-drilling-magnet.png',
                'type' => 'pabrikasi',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Mesin Cutting Circle',
                'description' => 'Mesin cutting untuk pemotongan melingkar pada material logam.',
                'image' => 'assets/img/pabrikasi/mesin-cutting-circle.jpg',
                'type' => 'pabrikasi',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Mesin Las CO3 Phase',
                'description' => 'Mesin las CO3 phase untuk pengelasan berkualitas tinggi.',
                'image' => 'assets/img/pabrikasi/mesin-las-co3-phase.jpg',
                'type' => 'pabrikasi',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Mesin Plasma Cutting',
                'description' => 'Mesin plasma cutting untuk pemotongan logam dengan presisi.',
                'image' => 'assets/img/pabrikasi/mesin-plasma-cutting2.png',
                'type' => 'pabrikasi',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Tools Kit Pabrikasi',
                'description' => 'Kit peralatan pabrikasi untuk berbagai kebutuhan produksi.',
                'image' => 'assets/img/pabrikasi/tools-kit-pabrikasi.jpg',
                'type' => 'pabrikasi',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Mesin Grinding',
                'description' => 'Mesin grinding untuk penghalusan dan finishing permukaan logam.',
                'image' => 'assets/img/pabrikasi/mesin-grinding.jpg',
                'type' => 'pabrikasi',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Mesin Kompresor',
                'description' => 'Mesin kompresor untuk penyediaan udara bertekanan dalam proses pabrikasi.',
                'image' => 'assets/img/pabrikasi/mesin-kompresor.jpeg',
                'type' => 'pabrikasi',
                'publisher' => 'PT RBM',
            ],
            [
                'name' => 'Mesin Bending',
                'description' => 'Mesin bending untuk pembentukan logam sesuai kebutuhan.',
                'image' => 'assets/img/pabrikasi/mesin-bending.jpeg',
                'type' => 'pabrikasi',
                'publisher' => 'PT RBM',
            ],
        ];

        foreach ($pabrikasi as $item) {
            Facility::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'image' => $item['image'],
                'type' => $item['type'],
                'publisher' => $item['publisher'],
            ]);
        }
    }
}