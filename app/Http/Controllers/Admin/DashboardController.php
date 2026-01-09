<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Testimonial;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
// use App\Models\Service; // BARIS INI DIHAPUS

class DashboardController extends Controller
{
    public function index()
    {
        // contoh ringkasan (jika model belum ada, ganti dengan 0)
        $products = class_exists(Product::class) ? Product::count() : 0;
        $reservations = class_exists(Reservation::class) ? Reservation::count() : 0;
        $testimonials = class_exists(Testimonial::class) ? Testimonial::count() : 0;

        // $items = Service::all(); // BARIS INI DIHAPUS (Tidak ada Model Service lagi)
        $items = collect(); // Mengganti dengan koleksi kosong jika Anda masih ingin mengirim variabel 'items'

        // return view('admin.dashboard', compact('products', 'reservations', 'testimonials', 'items')); // DIUBAH
        return view('admin.dashboard', compact('products', 'reservations', 'testimonials', 'items'));
    }
}
