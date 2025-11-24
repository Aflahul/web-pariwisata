<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiDaerah extends Model
{
    protected $table = 'informasi_daerah';

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'image',
    ];
}
