<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Validation\Rule; // Diperlukan untuk Rule::unique

class AboutController extends Controller
{
    /**
     * Menampilkan daftar semua data About (Visi, Misi, Tujuan).
     */
    public function index()
    {
        $abouts = About::all();
        // Pastikan path view sesuai, saya asumsikan 'admin.tables.abouts.index'
        return view('admin.tables.abouts.index', compact('abouts'));
    }

    /**
     * Menampilkan form untuk membuat data About baru.
     */
    public function create()
    {
        // Cegah membuat lebih dari 1 data (Good practice for singletons like Visi/Misi)
        if (About::count() >= 1) {
            return redirect()->route('admin.abouts.index')
                ->with('error', 'Data Visi, Misi & Tujuan sudah ada, tidak bisa tambah lagi.');
        }

        return view('admin.tables.abouts.create');
    }

    /**
     * Menyimpan data About yang baru.
     */
    public function store(Request $request)
    {
        // 🚨 KOREKSI: 'goal' dan 'image' diubah menjadi 'nullable'
        $data = $request->validate([
            'vision' => 'required|string|max:2000', // Batasan panjang
            'mission' => 'required|string|max:2000', // Batasan panjang
            'objective' => 'nullable|string|max:2000', // Asumsi nama kolom yang benar: objective (sesuai Blade), jika goal gunakan 'goal'
            'goal' => 'nullable|string|max:2000', // Menggunakan 'goal' sesuai kode Anda
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096' // Batasan MIME type dan ukuran (4MB)
        ]);

        if ($request->hasFile('image')) {
            // Store the file and update the 'image' field in $data
            $data['image'] = $request->file('image')->store('uploads/about', 'public');
        }

        About::create($data);

        return redirect()->route('admin.abouts.index')
            ->with('success', 'Data Visi, Misi & Tujuan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail data About.
     */
    public function show(About $about)
    {
        return view('admin.tables.abouts.show', compact('about'));
    }

    /**
     * Menampilkan form untuk mengedit data About.
     */
    public function edit(About $about)
    {
        return view('admin.tables.abouts.edit', compact('about'));
    }

    /**
     * Memperbarui data About.
     */
    public function update(Request $request, About $about)
    {
        // 🚨 KOREKSI: 'goal' dan 'image' diubah menjadi 'nullable'
        $data = $request->validate([
            'vision' => 'required|string|max:2000',
            'mission' => 'required|string|max:2000',
            'objective' => 'nullable|string|max:2000', // Asumsi nama kolom yang benar: objective
            'goal' => 'nullable|string|max:2000', // Menggunakan 'goal' sesuai kode Anda
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($about->image && Storage::disk('public')->exists($about->image)) {
                Storage::disk('public')->delete($about->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('uploads/about', 'public');
        }
        // 💡 Catatan: Jika tidak ada file baru diunggah, $data tidak akan memiliki kunci 'image',
        // yang secara otomatis mempertahankan nilai lama di database saat update.

        $about->update($data);

        return redirect()->route('admin.abouts.index')
            ->with('success','Data Visi, Misi & Tujuan berhasil diperbarui!');
    }

    /**
     * Menghapus data About.
     */
    public function destroy(About $about)
    {
        // Hapus file gambar dari storage sebelum menghapus record
        if ($about->image && Storage::disk('public')->exists($about->image)) {
            Storage::disk('public')->delete($about->image);
        }

        $about->delete();

        return redirect()->route('admin.abouts.index')
            ->with('success','Data Visi, Misi & Tujuan berhasil dihapus!');
    }
}
