<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Tampilkan semua testimoni (termasuk yang pending).
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        // Disamakan dengan path folder yang Anda gunakan di view sebelumnya
        return view('admin.tables.testimonials.index', compact('testimonials'));
    }

    /**
     * Form tambah testimoni baru.
     */
    public function create()
    {
        return view('admin.tables.testimonials.create');
    }

    /**
     * Simpan testimoni baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($request->hasFile('image')) {
            // Folder penyimpanan disederhanakan ke 'testimonials' agar mudah diakses
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan!');
    }

    /**
     * Update status testimoni secara cepat (Approve/Reject).
     * Digunakan untuk tombol centang di halaman daftar table.
     */
    public function updateStatus($id, $status)
    {
        $testimonial = Testimonial::findOrFail($id);

        if (in_array($status, ['approved', 'pending', 'rejected'])) {
            // Menggunakan save() agar lebih stabil di SQLite
            $testimonial->status = $status;
            $testimonial->save();

            return back()->with('success', "Status testimoni berhasil diubah menjadi " . ucfirst($status));
        }

        return back()->with('error', 'Status tidak valid.');
    }

    /**
     * Form edit testimoni.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.tables.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update testimoni lengkap.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($request->hasFile('image')) {
            // Hapus foto lama hanya jika file fisiknya benar-benar ada
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui!');
    }

    /**
     * Hapus testimoni dan filenya.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Bersihkan storage dari gambar terkait agar tidak memenuhi server
        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus!');
    }

    /**
     * Lihat detail testimoni.
     */
    public function show(Testimonial $testimonial)
    {
        return view('admin.tables.testimonials.show', compact('testimonial'));
    }
}
