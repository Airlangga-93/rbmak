<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image; // Pastikan model Image ada
use App\Models\Facility;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PublicFacilityController extends Controller
{
    /**
     * Menampilkan halaman daftar fasilitas.
     */
    public function index(Request $request)
    {
        // 1. Ambil semua tipe fasilitas yang unik untuk tombol filter di UI
        $types = Facility::select('type')->distinct()->pluck('type');

        // 2. Ambil gambar dekorasi untuk grid (sesuai logika lama Anda)
        $gridImages = Image::where('title', 'PortraitImage')->take(3)->get();
        $facilityImages = Image::where('title', 'FacilityImage')->first();

        // 3. Query dasar untuk fasilitas dengan filter
        $facilityQuery = Facility::query();

        // Terapkan filter jika ada parameter 'type' di URL
        if ($request->filled('type')) {
            $facilityQuery->where('type', $request->type);
        }

        // Ambil data fasilitas hasil filter
        $facilities = $facilityQuery->latest()->get();

        // 4. Kelompokkan semua fasilitas berdasarkan tipe (untuk tampilan per kategori)
        // Kita ambil data fresh agar tidak bentrok dengan filter di atas
        $groupedFacilities = Facility::latest()->get()->groupBy('type');

        return view('pages.facilities.index', [
            'facilities' => $facilities,
            'types' => $types,
            'facilityImages' => $facilityImages,
            'currentType' => $request->type, // Untuk menandai tombol filter yang aktif
            'groupedFacilities' => $groupedFacilities,
            'gridImages' => $gridImages,
        ]);
    }

    /**
     * Menampilkan detail satu fasilitas.
     */
    public function show($id)
    {
        // Menggunakan findOrFail agar jika ID tidak ada langsung muncul 404
        $facility = Facility::findOrFail($id);

        // Ambil fasilitas lain secara acak untuk rekomendasi/sidebar
        $otherFacilities = Facility::where('id', '!=', $facility->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('pages.facilities.show', [
            'facility' => $facility,
            'otherFacilities' => $otherFacilities
        ]);
    }
}
