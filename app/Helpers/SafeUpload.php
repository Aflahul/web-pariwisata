<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class SafeUpload
{
    /**
     * Allowed image MIME types
     */
    protected static array $allowedImageMimes = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    /**
     * Max file size in bytes (2 MB)
     */
    protected const MAX_FILE_BYTES = 2097152;

    /**
     * Periksa apakah file benar-benar gambar (MIME + signature)
     */
    public static function isRealImage(UploadedFile $file): bool
    {
        // MIME dari PHP
        $mime = $file->getMimeType();
        if (!in_array($mime, self::$allowedImageMimes)) {
            return false;
        }

        // ukuran tidak boleh melebihi limit (double-check)
        if ($file->getSize() > self::MAX_FILE_BYTES) {
            return false;
        }

        // signature binary (getimagesize) -> false jika bukan image valid
        $check = @getimagesize($file->getRealPath());
        return $check !== false;
    }

    /**
     * Validasi video (mp4/webm) jika diperlukan
     */
    public static function isRealVideo(UploadedFile $file): bool
    {
        $allowed = ['video/mp4', 'video/webm'];
        return in_array($file->getMimeType(), $allowed) && $file->getSize() <= (10 * 1024 * 1024); // contoh 10MB cap
    }

    /**
     * Validasi jumlah file maksimal
     */
    public static function validateMaxFiles($files, int $max = 5): bool
    {
        if (!is_array($files)) return true;
        return count($files) <= $max;
    }

    /**
     * Generate nama file yang konsisten tanpa menyimpan file.
     * Berguna untuk prediksi path sebelum menyimpan (rollback, dsb).
     */
    public static function generatedPath(UploadedFile $file, string $folder, ?string $prefix = 'file_'): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $safeName = uniqid($prefix) . '_' . time() . '.' . $ext;
        return trim($folder, '/') . '/' . $safeName;
    }

    /**
     * Upload aman:
     *
     * @param UploadedFile $file
     * @param string $folder relative to storage/app/public
     * @param bool $resize apakah mau resize (default true)
     * @param int $maxWidth max width untuk resize (default 1600)
     * @param int $quality jpeg/webp quality (1-100) default 85
     * @return string path relatif di disk public (contoh: uploads/destinasi/...)
     *
     * Contoh:
     * SafeUpload::upload($file, 'uploads/destinasi', resize:true, maxWidth:1600, quality:85)
     */
    public static function upload(UploadedFile $file, string $folder, bool $resize = true, int $maxWidth = 1600, int $quality = 85): string
    {
        // validasi awal
        if ($file->getSize() > self::MAX_FILE_BYTES) {
            throw new \RuntimeException('Ukuran file melebihi batas 2MB.');
        }

        if (!self::isRealImage($file)) {
            throw new \RuntimeException('File bukan gambar valid atau berpotensi berbahaya.');
        }

        $ext = strtolower($file->getClientOriginalExtension());
        $ext = in_array($ext, ['jpg','jpeg','png','webp']) ? $ext : 'jpg';

        // Nama file aman
        $safeName = uniqid('img_') . '_' . time() . '.' . $ext;
        $relativePath = trim($folder, '/') . '/' . $safeName;

        // Pastikan folder ada di disk public
        $disk = Storage::disk('public');

        try {
            // Gunakan Intervention Image untuk optimasi
            // Create image instance
            $img = Image::make($file->getRealPath());

            // Only resize if requested and image width is larger than maxWidth
            if ($resize && $img->width() > $maxWidth) {
                $img->resize($maxWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Convert to appropriate format & encode with quality
            // For PNG, quality is 0-9 in Intervention, but encode() accepts quality as int; it will be handled internally.
            $encoded = $img->encode($ext, $quality)->__toString();

            // Simpan ke disk public
            $disk->put($relativePath, $encoded);

            // Return path relatif (untuk dipakai asset('storage/' . $path))
            return $relativePath;
        } catch (\Exception $e) {
            // Jika gagal, pastikan tidak ada file setengah jalan
            if ($disk->exists($relativePath)) {
                $disk->delete($relativePath);
            }
            throw $e;
        }
    }

    /**
     * Hapus file aman dari storage/public
     */
    public static function delete(string $relativePath): bool
    {
        return Storage::disk('public')->exists($relativePath)
            ? Storage::disk('public')->delete($relativePath)
            : false;
    }
}
