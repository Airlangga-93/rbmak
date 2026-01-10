<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Tampilkan semua data galeri.
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.tables.galleries.index', compact('galleries'));
    }

    /**
     * Form tambah galeri.
     */
    public function create()
    {
        return view('admin.tables.galleries.create');
    }

    /**
     * Simpan data ke storage dan database.
     */
    public function store(Request $request)
    {
        // Validasi diperketat: max 2MB agar tidak loading lama saat buka index
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'title.required' => 'Judul galeri harus diisi.',
            'image.required' => 'Foto harus diunggah.',
            'image.max' => 'Ukuran foto maksimal 2MB agar website tetap cepat.'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Membuat nama file unik agar tidak terjadi tabrakan nama di folder gallery
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Simpan ke: storage/app/public/gallery
            $path = $file->storeAs('gallery', $fileName, 'public');

            Gallery::create([
                'title' => $request->title,
                'image' => $path, // Hasil di DB: "gallery/namafile.jpg"
            ]);
        }

        return redirect()->route('admin.galleries.index')->with('success', '✅ Galeri berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail galeri.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.tables.galleries.show', compact('gallery'));
    }

    /**
     * Form edit galeri.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.tables.galleries.edit', compact('gallery'));
    }

    /**
     * Update galeri dan bersihkan file lama.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $gallery->title = $request->title;

        if ($request->hasFile('image')) {
            // 1. Hapus file fisik lama jika bukan file bawaan assets
            if ($gallery->image && !str_contains($gallery->image, 'assets/')) {
                if (Storage::disk('public')->exists($gallery->image)) {
                    Storage::disk('public')->delete($gallery->image);
                }
            }

            // 2. Simpan file baru
            $file = $request->file('image');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('gallery', $fileName, 'public');

            $gallery->image = $path;
        }

        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', ' Galeri berhasil diperbarui!');
    }

    /**
     * Hapus data dan file fisik secara permanen.
     */
    public function destroy(Gallery $gallery)
    {
        // Pastikan file fisik dihapus agar storage lokal/hosting tidak bengkak
        if ($gallery->image && !str_contains($gallery->image, 'assets/')) {
            if (Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
        }

        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', ' Galeri berhasil dihapus!');
    }
}
