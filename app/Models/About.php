<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * * Memastikan field-field ini bisa diisi secara massal (mass assignment).
     */
    protected $fillable = [
        'vision',
        'mission',
        'goal', // 💡 Catatan: Pastikan ini sesuai dengan nama kolom di database Anda.
        'image',
    ];

    /**
     * The attributes that should be cast.
     *
     * Digunakan untuk memastikan format yang benar saat diakses, terutama untuk timestamp.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
