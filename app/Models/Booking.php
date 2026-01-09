<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'services',
        'date',
        'time',
        'total_price',
        'note',
        'status',
        'last_reply_by',
        'is_read_by_admin',
        'is_read_by_user',
    ];

    protected $casts = [
        'date' => 'date',
        'total_price' => 'decimal:2',
        'is_read_by_admin' => 'boolean',
        'is_read_by_user' => 'boolean',
    ];

    // Accessor untuk memecah string services (misal: "Potong, Cuci") menjadi Array
    public function getServiceListAttribute()
    {
        return $this->services ? explode(',', $this->services) : [];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'booking_id');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
