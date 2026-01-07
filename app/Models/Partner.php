<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug', // Tambahkan ini agar database mengizinkan pengisian slug
        'description',
        'logo',
        'sector',
        'city',
        'company_contact',
        'publisher',
        'partnership_date',
    ];

    /**
     * Menggunakan ID untuk Route Model Binding agar konsisten dengan penggunaan ID di admin.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}
