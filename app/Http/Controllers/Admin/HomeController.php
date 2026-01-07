<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class HomeController extends Controller
{
    /**
     * 🔹 Tampilkan halaman utama (Home)
     */
    public function index()
    {
        // Inisialisasi koleksi kosong untuk mencegah error jika query gagal
        $products = collect();
        $testimonials = collect();
        $galleryItems = collect();
        $partners = collect();
        $facilities = collect();

        // -------------------------------
        // 🛍️ PRODUK TERBARU
        // -------------------------------
        try {
            $products = Product::latest()->take(4)->get();
        } catch (\Throwable $e) {
            Log::warning('Gagal mengambil produk: ' . $e->getMessage());
        }

        // -------------------------------
        // 💬 TESTIMONI
        // -------------------------------
        try {
            $testimonials = Testimonial::latest()->take(3)->get();
        } catch (\Throwable $e) {
            Log::warning('Gagal mengambil testimonial: ' . $e->getMessage());
        }

        // -------------------------------
        // 🖼️ GALERI
        // -------------------------------
        try {
            $galleryItems = Gallery::latest()->take(4)->get();
        } catch (\Throwable $e) {
            Log::warning('Gagal mengambil galeri: ' . $e->getMessage());
        }

        // -------------------------------
        // 🌿 PARTNERS
        // -------------------------------
        try {
            $partners = Partner::latest()->take(6)->get();
        } catch (\Throwable $e) {
            Log::warning('Gagal mengambil partners: ' . $e->getMessage());
        }

        // -------------------------------
        // 🏢 FACILITIES
        // -------------------------------
        try {
            $facilities = Facility::latest()->take(6)->get();
        } catch (\Throwable $e) {
            Log::warning('Gagal mengambil facilities: ' . $e->getMessage());
        }

        // -------------------------------
        // 🌿 KEUNGGULAN (STATIC DATA)
        // -------------------------------
        $advantages = [
            'Tenaga Profesional & Bersertifikasi',
            'Pelayanan Homecare & Onsite',
            'Fasilitas Lengkap & Nyaman',
            'Prioritas Keamanan dan Higienitas',
            'Konsultasi Gratis Sebelum Tindakan',
            'Buka Setiap Hari (By Appointment)',
        ];

        // -------------------------------
        // 🩷 KATEGORI LAYANAN (STATIC)
        // -------------------------------
        $allServiceCategories = [
            (object) [
                'title' => 'Perawatan Ibu Hamil',
                'link' => 'ibu-hamil',
                'img_url' => 'https://images.unsplash.com/photo-1579783902672-91041935b3e6?auto=format&fit=crop&w=800&q=60',
            ],
            (object) [
                'title' => 'Perawatan Bayi & Anak',
                'link' => 'bayi-anak',
                'img_url' => 'https://images.unsplash.com/photo-1543088339-b9d9c288f6b7?auto=format&fit=crop&w=800&q=60',
            ],
            (object) [
                'title' => 'Perawatan Pasca Lahir',
                'link' => 'pasca-lahir',
                'img_url' => 'https://images.unsplash.com/photo-1574676643202-09c063b4f621?auto=format&fit=crop&w=800&q=60',
            ],
            (object) [
                'title' => 'Konsultasi Kebidanan',
                'link' => 'konsultasi',
                'img_url' => 'https://images.unsplash.com/photo-1576092764977-943e86c99c7d?auto=format&fit=crop&w=800&q=60',
            ],
        ];

        // -------------------------------
        // 💬 TESTIMONI WA (STATIC)
        // -------------------------------
        $waTestimonialUrls = [
            'https://via.placeholder.com/400x500?text=Testimoni+WA+1',
            'https://via.placeholder.com/400x500?text=Testimoni+WA+2',
            'https://via.placeholder.com/400x500?text=Testimoni+WA+3',
        ];

        // -------------------------------
        // 🚀 RETURN KE VIEW
        // -------------------------------
        return view('welcome', compact(
            'products',
            'advantages',
            'allServiceCategories',
            'testimonials',
            'waTestimonialUrls',
            'galleryItems',
            'partners',
            'facilities'
        ));
    }
}
