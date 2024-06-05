<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $fillable = [
        'user_id',
        'judul',
        'waktu',
        'lokasi',
    ];

    public function detailGaleri()
    {
        return $this->hasMany(DetailGaleri::class, 'galeri_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
