<?php

namespace App\Helpers;

class ImageHelper
{
    public static function imagePath($img)
    {
        // Jika array → ambil elemen pertama
        if (is_array($img)) {
            $img = $img[0] ?? null;
        }

        // Jika null atau kosong → pakai default
        if (!$img || trim($img) === '') {
            return asset('frontend/img/default.png');
        }

        // Jika path public / langsung dari public/
        if (str_starts_with($img, 'frontend/') || str_starts_with($img, 'img/')) {
            return asset($img);
        }

        // Jika path storage
        return asset('storage/' . $img);
    }
}
