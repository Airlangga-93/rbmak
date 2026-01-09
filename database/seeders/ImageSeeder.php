<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Image::create([
            'title' => 'PortraitImage',
            'path' => 'assets/img/image.png',
            'alt' => 'Portrait Image',
            'description' => 'Sample portrait image for facilities',
        ]);

        \App\Models\Image::create([
            'title' => 'PortraitImage',
            'path' => 'assets/img/image.png',
            'alt' => 'Portrait Image 2',
            'description' => 'Another sample portrait image',
        ]);

        \App\Models\Image::create([
            'title' => 'PortraitImage',
            'path' => 'assets/img/image.png',
            'alt' => 'Portrait Image 3',
            'description' => 'Third sample portrait image',
        ]);

        \App\Models\Image::create([
            'title' => 'FacilityImage',
            'path' => 'assets/img/image.png',
            'alt' => 'Facility Image',
            'description' => 'Sample facility image',
        ]);
    }
}
