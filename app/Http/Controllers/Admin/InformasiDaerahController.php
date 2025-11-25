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

            // 4MB
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $info = InformasiDaerah::first() ?? new InformasiDaerah;

        // Update text field
        $info->title    = $request->title;
        $info->subtitle = $request->subtitle;
        $info->content  = $request->content;

        /**
         * HANDLE UPLOAD GAMBAR AMAN
         */
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['image' => 'File gambar tidak valid atau berbahaya.']);
            }

            // Hapus gambar lama (pakai path asli)
            if ($info->image && Storage::disk('public')->exists($info->image)) {
                Storage::disk('public')->delete($info->image);
            }

            // Upload dengan SafeUpload (resize aktif)
            $info->image = SafeUpload::upload(
                $file,
                'uploads/informasi-daerah',
                resize: true,
                maxWidth: 1600,
                quality: 85
            );
        }

        $info->save();

        return back()->with('success', 'Informasi daerah berhasil diperbarui.');
    }
}
