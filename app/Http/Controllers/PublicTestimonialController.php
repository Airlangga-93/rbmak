<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class PublicTestimonialController extends Controller
{
    /**
     * Menampilkan daftar testimoni yang SUDAH DISETUJUI oleh admin.
     */
    public function index()
    {
        // Hanya mengambil yang statusnya 'approved' agar yang 'pending' tidak muncul
        $testimonials = Testimonial::where('status', 'approved')
                        ->latest()
                        ->get();

        return view('pages.testimonials.index', compact('testimonials'));
    }

    /**
     * Menampilkan halaman form pengiriman testimoni.
     */
    public function create()
    {
        return view('pages.testimonials.create');
    }

    /**
     * Menyimpan testimoni baru dari form publik.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        $data = $request->only(['name', 'company', 'message']);

        // Logika: Secara default status adalah 'pending' (sesuai migration)
        $data['status'] = 'pending';

        // Menangani upload foto jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('testimonials', 'public');
            $data['image'] = $path;
        }

        Testimonial::create($data);

        // Berikan pesan yang jelas bahwa data tidak langsung muncul
        return redirect()->route('testimonials.index')->with('success', 'Terima kasih! Testimoni Anda telah terkirim. Admin akan meninjau pesan Anda sebelum dipublikasikan.');
    }
}
