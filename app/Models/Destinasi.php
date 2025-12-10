<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destinasi extends Model
{
    protected $table = 'destinasi';

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'lokasi',
        'maps_url',
        'excerpt',
        'deskripsi',
        'gambar',
        'unggulan',
    ];

    protected $casts = [
        'gambar' => 'array',
        'unggulan' => 'boolean',
    ];

    // Generate slug otomatis ketika nama diisi
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty('nama')) {
                $model->slug = Str::slug($model->nama) . '-' . Str::random(5);
            }
        });
    }
}
