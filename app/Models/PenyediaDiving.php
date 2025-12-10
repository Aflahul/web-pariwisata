<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PenyediaDiving extends Model
{
    protected $table = 'penyedia_diving';

    protected $fillable = [
        'nama',
        'slug',
        'kontak',
        'alamat',
        'maps_url',
        'peralatan',
        'paket',
        'gambar',
        'deskripsi',
        'is_published',
    ];

    protected $casts = [
        'peralatan' => 'array',
        'paket'     => 'array',
        'gambar'    => 'array',
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty('nama')) {
                $model->slug = Str::slug($model->nama) . '-' . Str::random(5);
            }
        });
    }
}
