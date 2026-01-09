<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Tampilkan daftar berita.
     */
    public function index()
    {
        // Mengambil semua berita, diurutkan dari yang terbaru
        $news = News::latest()->get();
        return view("admin.tables.news.index", compact("news"));
    }

    /**
     * Form tambah berita.
     */
    public function create()
    {
        return view("admin.tables.news.create");
    }

    /**
     * Simpan berita baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:5048',
            'description' => 'required|string',
            'date_published' => 'required|date',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'image.required' => 'Gambar berita wajib diunggah.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        // Mengisi nama penerbit secara otomatis
        $validatedData['publisher'] = Auth::user()->name;

        // Proses upload gambar ke folder: storage/app/public/news_images
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news_images', 'public');
            // Simpan path lengkap agar konsisten dengan pemanggilan di Blade
            $validatedData['image'] = 'news_images/' . basename($path);
        }

        // Slug dibuat otomatis oleh model News
        News::create($validatedData);

        return redirect()->route('admin.news.index')->with('success', '✅ Berita berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail berita.
     */
    public function show(News $news)
    {
        return view('admin.tables.news.show', compact('news'));
    }

    /**
     * Form edit berita.
     */
    public function edit(News $news)
    {
        return view('admin.tables.news.edit', compact('news'));
    }

    /**
     * Update berita dan hapus gambar lama dari server.
     */
    public function update(Request $request, News $news)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5048',
            'description' => 'required|string',
            'date_published' => 'required|date',
        ]);

        $validatedData['publisher'] = Auth::user()->name;

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage Hostinger jika ada
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }

            // Simpan gambar baru
            $path = $request->file('image')->store('news_images', 'public');
            $validatedData['image'] = 'news_images/' . basename($path);
        }

        $news->update($validatedData);

        return redirect()->route('admin.news.index')->with('success', '✅ Berita berhasil diperbarui!');
    }

    /**
     * Hapus berita dan file gambarnya secara permanen.
     */
    public function destroy(News $news)
    {
        // Bersihkan storage agar tidak penuh dengan gambar sampah
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', '🗑️ Berita berhasil dihapus!');
    }
}
