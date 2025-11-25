<?php

use App\Helpers\ImageHelper;

if (!function_exists('image_path')) {
    function image_path($img)
    {
        return ImageHelper::imagePath($img);
    }
}
