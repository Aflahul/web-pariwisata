<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakResmi extends Model
{
    protected $table = 'kontak_resmi';

    protected $fillable = [
        'alamat',
        'telepon',
        'whatsapp',
        'email',
        'jam_operasional',
        'maps_url',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
    ];
}
