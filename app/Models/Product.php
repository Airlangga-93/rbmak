<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * Semua field di sini HARUS dimasukkan agar data bisa disimpan
     * menggunakan mass assignment (Product::create($data)).
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'type', // 🛑 KOREKSI: Tambahkan 'type' agar bisa disimpan
        'slug',
    ];

    /**
     * The attributes that should be cast to native types.
     * (Opsional: Berguna jika 'price' perlu dikelola sebagai float)
     */
    protected $casts = [
        'price' => 'decimal:0', // Menyimpan harga sebagai desimal/integer
    ];
}
