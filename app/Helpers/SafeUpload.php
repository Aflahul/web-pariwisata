<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;

class SafeUpload
{
    protected static array $allowedImageMimes = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    protected const MAX_FILE_BYTES = 3145728; // 3 MB default

    public static function isRealImage(UploadedFile $file): bool
    {
        if (!in_array($file->getMimeType(), self::$allowedImageMimes)) {
            return false;
        }

        if ($file->getSize() > (5 * 1024 * 1024)) {
            return false;
        }

        return @getimagesize($file->getRealPath()) !== false;
    }

    public static function validateMaxFiles($files, int $max = 5): bool
    {
        if (!is_array($files)) return true;
        return count($files) <= $max;
    }

    public static function upload(
        UploadedFile $file,
        string $folder,
        bool $resize = true,
        bool $optimize = true,
        bool $isHero = false,
        int $maxWidth = 1600,
        int $quality = 85
    ): string {

        // Hero image boleh sampai 4MB
        $maxBytes = $isHero ? (4 * 1024 * 1024) : self::MAX_FILE_BYTES;

        if ($file->getSize() > $maxBytes) {
            throw new \RuntimeException('Ukuran file melebihi batas yang diizinkan.');
        }

        if (!self::isRealImage($file)) {
            throw new \RuntimeException('File bukan gambar valid.');
        }

        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $ext = 'jpg';
        }

        $safeName = uniqid('img_') . '_' . time() . '.' . $ext;
        $relativePath = trim($folder, '/') . '/' . $safeName;

        $disk = Storage::disk('public');
        $manager = new ImageManager(new GdDriver());

        try {
            // Skip full processing untuk hero/logo/favicon
            if (!$resize && !$optimize) {
                $disk->put($relativePath, file_get_contents($file->getRealPath()));
                return $relativePath;
            }

            $img = $manager->read($file->getRealPath());

            if ($resize && $img->width() > $maxWidth) {
                $img = $img->resize($maxWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Pilih encoder sesuai extension
            switch ($ext) {
                case 'png':
                    $encoded = $img->encode(new PngEncoder());
                    break;

                case 'webp':
                    $encoded = $img->encode(new WebpEncoder(quality: $quality));
                    break;

                default: // jpg/jpeg
                    $encoded = $img->encode(new JpegEncoder(quality: $quality));
                    break;
            }

            $disk->put($relativePath, $encoded);

            return $relativePath;

        } catch (\Exception $e) {
            if ($disk->exists($relativePath)) {
                $disk->delete($relativePath);
            }
            throw $e;
        }
    }

    public static function delete(string $relativePath): bool
    {
        return Storage::disk('public')->exists($relativePath)
            ? Storage::disk('public')->delete($relativePath)
            : false;
    }
}
