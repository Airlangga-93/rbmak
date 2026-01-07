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
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua berita dari database, diurutkan dari yang terbaru
        $news = News::latest()->get();

        return view("admin.tables.news.index", compact("news"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.tables.news.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5048',
            'description' => 'required|string',
            'date_published' => 'required|date',
        ]);

        // Mengisi nama penerbit secara otomatis dari user yang login
        $validatedData['publisher'] = Auth::user()->name;

        // Proses upload gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Slug akan dibuat otomatis oleh model News melalui static::creating
        News::create($validatedData);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        // Menggunakan Route Model Binding (otomatis mencari berdasarkan slug)
        return view('admin.tables.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        // Menggunakan Route Model Binding
        return view('admin.tables.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5048',
            'description' => 'required|string',
            'date_published' => 'required|date',
        ]);

        $validatedData['publisher'] = Auth::user()->name;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada gambar baru yang diupload
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $imagePath = $request->file('image')->store('news_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Slug akan diupdate otomatis oleh model jika title berubah (isDirty)
        $news->update($validatedData);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Hapus file gambar dari storage sebelum menghapus data di database
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
