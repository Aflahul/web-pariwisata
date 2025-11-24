<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Akomodasi extends Model
{
    protected $table = 'akomodasi';

    protected $fillable = [
        'nama',
        'slug',
        'tipe',
        'alamat',
        'telepon',
        'price_range',
        'maps_url',
        'excerpt',
        'deskripsi',
        'fasilitas',
        'images',
        'is_published',
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'images' => 'array',
        'is_published' => 'boolean',
    ];

    // Auto slug ketika disimpan
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
