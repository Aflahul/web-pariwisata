<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontpageSetting extends Model
{
    protected $table = 'frontpage_settings';

    protected $fillable = [
        // HERO
        'hero_title',
        'hero_subtitle',
        'hero_image',

        // WELCOME
        'welcome_title',
        'welcome_text',
        'welcome_image',

        // PANDUAN
        'guide1_title',
        'guide1_text',
        'guide2_title',
        'guide2_text',
        'guide3_title',
        'guide3_text',

        // SLIDER DESTINASI
        'slider',

        // FOOTER/KONTAK
        'contact_address',
        'contact_phone',
        'contact_email',

        // LOGO & FAVICON
        'logo',
        'favicon',
    ];

    protected $casts = [
        'slider' => 'array', // JSON array
    ];
}
