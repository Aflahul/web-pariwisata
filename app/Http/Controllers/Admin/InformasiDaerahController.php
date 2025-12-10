<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiDaerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\SafeUpload;

class InformasiDaerahController extends Controller
{
    public function edit()
    {
        $info = InformasiDaerah::first() ?? new InformasiDaerah;
        return view('admin.web.informasi-daerah.edit', compact('info'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'content'   => 'required|string',

            // 4 MB
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $info = InformasiDaerah::first() ?? new InformasiDaerah;

        // Update text
        $info->title    = $request->title;
        $info->subtitle = $request->subtitle;
        $info->content  = $request->content;

        // Upload gambar
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['image' => 'File gambar tidak valid atau berbahaya.']);
            }

            // Hapus gambar lama
            if ($info->image && Storage::disk('public')->exists($info->image)) {
                Storage::disk('public')->delete($info->image);
            }

            // Upload baru (resize ON, optimize ON)
            $info->image = SafeUpload::upload(
                file: $file,
                folder: 'uploads/informasi-daerah',
                resize: true,
                optimize: true,
                maxWidth: 1600,
                quality: 85
            );
        }

        $info->save();

        return back()->with('success', 'Informasi daerah berhasil diperbarui.');
    }
}
