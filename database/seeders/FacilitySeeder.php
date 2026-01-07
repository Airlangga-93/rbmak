<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('facilities')->truncate();

        DB::table('facilities')->insert([

            /*
            |------------------------------------------------------------------
            | PERALATAN PABRIKASI
            |------------------------------------------------------------------
            */
            [
                'name' => 'Mesin Plasma Cutting',
                'description' => 'Mesin pemotong baja presisi tinggi menggunakan teknologi plasma.',
                'image' => 'assets/img/pabrikasi/MesinPlasmaCutting2.png',
                'type' => 'Peralatan Pabrikasi',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mesin Bending',
                'description' => 'Mesin pembengkok plat baja untuk kebutuhan fabrikasi.',
                'image' => 'assets/img/pabrikasi/Mesin-bending.jpeg',
                'type' => 'Peralatan Pabrikasi',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mesin Las CO 3 Phase',
                'description' => 'Mesin las industri 3 phase untuk struktur baja.',
                'image' => 'assets/img/pabrikasi/Mesin-las-CO3-Phase.jpg',
                'type' => 'Peralatan Pabrikasi',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mesin Grinding',
                'description' => 'Mesin penghalus dan perapih hasil las.',
                'image' => 'assets/img/pabrikasi/Mesin-Grinding.jpg',
                'type' => 'Peralatan Pabrikasi',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mesin Cutting Circle',
                'description' => 'Mesin pemotong material berbentuk lingkaran.',
                'image' => 'assets/img/pabrikasi/Mesin-Cutting-Circle.jpg',
                'type' => 'Peralatan Pabrikasi',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mesin Kompresor',
                'description' => 'Penyedia tekanan udara operasional.',
                'image' => 'assets/img/pabrikasi/Mesin-Kompresor.jpeg',
                'type' => 'Peralatan Pabrikasi',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mesin Drilling Magnet',
                'description' => 'Mesin bor magnetik presisi tinggi.',
                'image' => 'assets/img/pabrikasi/Mesin Drilling Magnet.png',
                'type' => 'Peralatan Pabrikasi',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Tools Kit Pabrikasi',
                'description' => 'Perlengkapan tools fabrikasi.',
                'image' => 'assets/img/pabrikasi/Tools-Kit-Pabrikasi.jpg',
                'type' => 'Peralatan Pabrikasi',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            /*
            |------------------------------------------------------------------
            | PERALATAN MAINTENANCE
            |------------------------------------------------------------------
            */
            [
                'name' => 'Tension Meter',
                'description' => 'Alat ukur ketegangan kabel.',
                'image' => 'assets/img/maintenance/TensionMeter.jpg',
                'type' => 'Peralatan Maintenance',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ampere Pliers',
                'description' => 'Alat ukur arus listrik.',
                'image' => 'assets/img/maintenance/Ampere-Pliers.jpeg',
                'type' => 'Peralatan Maintenance',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Grounding Tester',
                'description' => 'Alat uji grounding.',
                'image' => 'assets/img/maintenance/Grounding-Tester.jpg',
                'type' => 'Peralatan Maintenance',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Theodolite',
                'description' => 'Alat ukur sudut dan elevasi.',
                'image' => 'assets/img/maintenance/Theodolite.jpg',
                'type' => 'Peralatan Maintenance',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Vernier Caliper',
                'description' => 'Alat ukur presisi.',
                'image' => 'assets/img/maintenance/Vernier-Caliper.jpg',
                'type' => 'Peralatan Maintenance',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Tools Kit Maintenance',
                'description' => 'Tools lapangan maintenance.',
                'image' => 'assets/img/maintenance/Tools-Kit-Maintenance.jpg',
                'type' => 'Peralatan Maintenance',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            /*
            |------------------------------------------------------------------
            | KENDARAAN OPERASIONAL
            |------------------------------------------------------------------
            */
            [
                'name' => 'Head Truck',
                'description' => 'Kendaraan pengangkut material.',
                'image' => 'assets/img/kendaraan/HeadTruck.png',
                'type' => 'Kendaraan Operasional',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pick Up',
                'description' => 'Mobilisasi cepat lapangan.',
                'image' => 'assets/img/kendaraan/PickUp.png',
                'type' => 'Kendaraan Operasional',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Minibus',
                'description' => 'Transportasi teknisi.',
                'image' => 'assets/img/kendaraan/MiniBus.jpg',
                'type' => 'Kendaraan Operasional',
                'publisher' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
