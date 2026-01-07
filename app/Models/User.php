<?php

namespace App\Models;

// Tambahkan use Carbon agar tidak error saat membandingkan waktu
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'last_seen' // Kolom ini wajib ada di fillable agar bisa diupdate otomatis
    ];

    /**
     * Kolom yang disembunyikan saat convert ke Array/JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen' => 'datetime', // Sangat penting agar bisa menggunakan fungsi ->diffForHumans() atau ->gt()
        ];
    }

    /**
     * Helper untuk cek apakah user sedang online
     * Dianggap online jika aktivitas terakhir kurang dari 5 menit yang lalu
     */
    public function isOnline()
    {
        // Jika last_seen kosong, otomatis offline
        if (!$this->last_seen) {
            return false;
        }

        // Cek apakah waktu last_seen lebih besar dari waktu 5 menit yang lalu
        return $this->last_seen->gt(now()->subMinutes(5));
    }

    /**
     * RELASI DATABASE
     */

    // Relasi ke tabel Reservasi
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Relasi ke tabel Pesan (sebagai pengirim)
    public function messagesAsSender()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Relasi ke tabel Pesan (sebagai penerima)
    public function messagesAsReceiver()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Mengambil pesan terakhir antara user ini dengan admin yang sedang login
     */
    public function latestMessageWithAdmin()
    {
        // Pastikan model Message sudah ada
        return Message::where(function($q) {
            $q->where('sender_id', $this->id)->where('receiver_id', auth()->id());
        })->orWhere(function($q) {
            $q->where('sender_id', auth()->id())->where('receiver_id', $this->id);
        })->latest()->first();
    }
}
