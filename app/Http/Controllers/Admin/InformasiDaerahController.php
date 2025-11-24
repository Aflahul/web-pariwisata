<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiDaerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\SafeUpload;

class InformasiDaerahController extends Controller
{
    /**
     * Halaman edit informasi daerah
     */
    public function edit()
    {
        $info = InformasiDaerah::first() ?? new InformasiDaerah;
        return view('admin.web.informasi-daerah.edit', compact('info'));
    }

    /**
     * Update informasi daerah
     */
    public function update(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'content'   => 'required|string',

            // file tunggal max 2MB
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $info = InformasiDaerah::first() ?? new InformasiDaerah;

        // update teks
        $info->title = $request->title;
        $info->subtitle = $request->subtitle;
        $info->content = $request->content;

        /**
         * 1. HANDLE UPLOAD GAMBAR AMAN
         */
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            // Validasi signature file (anti fake image)
            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['image' => 'File gambar tidak valid atau berbahaya.']);
            }

            // Hapus gambar lama jika ada
            if ($info->image) {
                $oldPath = 'uploads/informasi-daerah/' . basename($info->image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Upload baru dengan SafeUpload
            $path = SafeUpload::upload($file, 'uploads/informasi-daerah');

            $info->image = $path;
        }

        $info->save();

        return back()->with('success', 'Informasi daerah berhasil diperbarui.');
    }
}
