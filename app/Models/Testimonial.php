<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * fillable memungkinkan kolom-kolom ini diisi secara massal
     * melalui Testimonial::create($data) atau $testimonial->update($data).
     */
    protected $fillable = [
        'name',
        'company',
        'message',
        'image',  // Menggunakan 'image' agar sinkron dengan migration dan controller
        'status', // WAJIB ada agar logika "Tayangkan" (Moderasi) berfungsi
    ];

    /**
     * Opsional: Default nilai status jika tidak diisi
     */
    protected $attributes = [
        'status' => 'pending',
    ];
}
