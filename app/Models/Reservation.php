<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'services',
        'total_price',
        'date',
        'time',
        'status',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
        'total_price' => 'integer',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($reservation) {
            if (empty($reservation->status)) {
                $reservation->status = 'pending';
            }
        });
    }
}
