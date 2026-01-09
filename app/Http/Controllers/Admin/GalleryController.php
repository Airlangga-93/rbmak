<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

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
        // Validasi title dan image
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ], [
            'title.required' => 'Judul galeri harus diisi.',
            'image.required' => 'Foto harus diunggah.',
            'image.max' => 'Ukuran foto maksimal 4MB.'
        ]);

        // Simpan ke folder: storage/app/public/gallery
        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'image' => $path, // Menyimpan path lengkap: gallery/namafile.jpg
        ]);

        return redirect()->route('admin.galleries.index')->with('success', '✅ Galeri berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail galeri (Opsional).
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
     * Update galeri dan bersihkan file lama di server.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $gallery->title = $request->title;

        if ($request->hasFile('image')) {
            // Hapus file fisik lama dari storage Hostinger
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            // Simpan file baru
            $gallery->image = $request->file('image')->store('gallery', 'public');
        }

        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', '✅ Galeri berhasil diperbarui!');
    }

    /**
     * Hapus data dan file fisik secara permanen.
     */
    public function destroy(Gallery $gallery)
    {
        // Pastikan file fisik dihapus agar kapasitas hosting tetap lega
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', '🗑️ Galeri berhasil dihapus!');
    }
}
