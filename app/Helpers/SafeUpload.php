<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class SafeUpload
{
    /**
     * Validasi image asli (mencegah spoofing dan malware).
     */
    public static function isRealImage($file)
    {
        $allowedMime = [
            'image/jpeg',
            'image/png',
            'image/webp',
        ];

        // Cek MIME asli dari fileupload
        if (!in_array($file->getMimeType(), $allowedMime)) {
            return false;
        }

        // Cek signature binary (anti fake jpg/png)
        $check = @getimagesize($file->getRealPath());
        return $check !== false;
    }

    /**
     * Validasi video aman (jika nanti dipakai).
     */
    public static function isRealVideo($file)
    {
        $allowedMime = [
            'video/mp4',
            'video/webm',
        ];

        return in_array($file->getMimeType(), $allowedMime);
    }

    /**
     * Upload file aman → langsung ke storage/app/public/{folder}
     */
    public static function upload($file, $folder)
    {
        $ext = strtolower($file->getClientOriginalExtension());

        // Penamaan aman & unik
        $safeName = uniqid('file_') . '_' . time() . '.' . $ext;

        // Simpan ke storage/public/{folder}
        return $file->storeAs($folder, $safeName, 'public');
    }

    /**
     * Validasi jumlah file max 5
     */
    public static function validateMaxFiles($files)
    {
        if (is_array($files) && count($files) > 5) {
            return false;
        }
        return true;
    }
}
