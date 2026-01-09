<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',   // Ditambahkan agar bisa menyimpan relasi booking jika ada
        'sender_id',
        'receiver_id',
        'message',      // Boleh null jika hanya mengirim gambar
        'image',        // Path file dari Cloudinary/Storage
        'sender_type',  // 'admin' atau 'user'
        'device_info',  // Menyimpan info browser/perangkat
        'is_read'       // Status pesan (true/false)
    ];

    /**
     * Casting status read agar selalu berupa boolean (true/false)
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi ke Booking
     * Pesan bisa saja terikat dengan satu transaksi booking tertentu
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Relasi ke Pengirim (User)
     * Sangat penting untuk fitur Notifikasi Email (mengambil nama pengirim)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relasi ke Penerima (User/Admin)
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Scope untuk mengambil pesan yang belum dibaca (Helper)
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
