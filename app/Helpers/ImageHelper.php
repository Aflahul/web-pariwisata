<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Generate path gambar yang aman dan fleksibel.
     */
    public static function imagePath($img)
    {
        // fallback
        if (!$img) {
            return asset('frontend/img/default.png');
        }

        // path public (frontend/img/…)
        if (str_starts_with($img, 'frontend/')) {
            return asset($img);
        }

        // path storage (uploads/…)
        return asset('storage/' . $img);
    }
}
