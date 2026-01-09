<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    /**
     * Tampilkan daftar fasilitas.
     */
    public function index()
    {
        $facilities = Facility::latest()->get();
        return view('admin.tables.facility.index', compact('facilities'));
    }

    /**
     * Form tambah fasilitas.
     */
    public function create()
    {
        return view('admin.tables.facility.create');
    }

    /**
     * Simpan fasilitas baru ke storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'type' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama fasilitas harus diisi.',
            'description.required' => 'Deskripsi harus diisi.',
            'image.required' => 'Foto fasilitas harus diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',
            'type.required' => 'Jenis fasilitas harus diisi.',
        ]);

        $validatedData['publisher'] = Auth::user()->name;

        if ($request->hasFile('image')) {
            // Path: storage/app/public/facility_images
            // Kita gunakan basename agar yang tersimpan di DB hanya nama filenya saja (konsisten dengan produk)
            $path = $request->file('image')->store('facility_images', 'public');
            $validatedData['image'] = 'facility_images/' . basename($path);
        }

        Facility::create($validatedData);

        return redirect()->route('admin.facilities.index')->with('success', '✅ Fasilitas berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail fasilitas.
     */
    public function show(Facility $facility)
    {
        return view('admin.tables.facility.show', compact('facility'));
    }

    /**
     * Form edit fasilitas.
     */
    public function edit(Facility $facility)
    {
        return view('admin.tables.facility.edit', compact('facility'));
    }

    /**
     * Update fasilitas dan hapus foto lama.
     */
    public function update(Request $request, Facility $facility)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'type' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama fasilitas harus diisi.',
            'description.required' => 'Deskripsi harus diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',
            'type.required' => 'Jenis fasilitas harus diisi.',
        ]);

        $validatedData['publisher'] = Auth::user()->name;

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada di storage public
            if ($facility->image && Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }

            // Simpan foto baru
            $path = $request->file('image')->store('facility_images', 'public');
            $validatedData['image'] = 'facility_images/' . basename($path);
        }

        $facility->update($validatedData);

        return redirect()->route('admin.facilities.index')->with('success', '✅ Fasilitas berhasil diperbarui!');
    }

    /**
     * Hapus fasilitas dan file fotonya.
     */
    public function destroy(Facility $facility)
    {
        // Hapus file fisik agar tidak jadi sampah di Hostinger
        if ($facility->image && Storage::disk('public')->exists($facility->image)) {
            Storage::disk('public')->delete($facility->image);
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')->with('success', '🗑️ Fasilitas berhasil dihapus!');
    }
}
