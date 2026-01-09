<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.tables.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.tables.galleries.create');
    }

    public function store(Request $request)
    {
        // Validasi title dan image
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:4096',
        ]);

        $path = $request->file('image')->store('uploads/gallery', 'public');

        Gallery::create([
            'title' => $request->title, // Menyimpan judul ke kolom title
            'image' => $path,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function show(Gallery $gallery)
    {
        return view('admin.tables.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.tables.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        $gallery->title = $request->title;

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $gallery->image = $request->file('image')->store('uploads/gallery', 'public');
        }

        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Data berhasil dihapus!');
    }
}
