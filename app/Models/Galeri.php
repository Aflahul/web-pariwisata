<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'judul',
        'tipe_media',
        'file_path',
        'video_url',
        'deskripsi',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Helper method untuk menampilkan media
    public function getMediaUrlAttribute()
    {
        if ($this->tipe_media === 'image' && $this->file_path) {
            return asset('storage/' . $this->file_path);
        }

        if ($this->tipe_media === 'video' && $this->video_url) {
            return $this->video_url;
        }

        return null;
    }
}
