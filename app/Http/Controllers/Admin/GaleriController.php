<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Helpers\SafeUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * LIST GALERI
     */
    public function index()
    {
        $data = Galeri::orderByDesc('id')->paginate(12);
        return view('admin.web.galeri.index', compact('data'));
    }

    /**
     * FORM TAMBAH
     */
    public function create()
    {
        return view('admin.web.galeri.create');
    }

    /**
     * SIMPAN GALERI BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'nullable|string|max:255',
            'tipe_media'   => 'required|in:image,video',
            'deskripsi'    => 'nullable|string',
            'is_published' => 'nullable|boolean',

            'file_path'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',
            'video_url'    => 'nullable|url|max:500',
        ]);

        $galeri = new Galeri();
        $galeri->judul        = $request->judul;
        $galeri->tipe_media   = $request->tipe_media;
        $galeri->deskripsi    = $request->deskripsi;
        $galeri->is_published = $request->boolean('is_published');

        /**
         * MODE FOTO
         */
        if ($request->tipe_media === 'image') {

            if (!$request->hasFile('file_path')) {
                return back()->withErrors(['file_path' => 'Foto wajib diunggah.']);
            }

            $file = $request->file('file_path');

            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['file_path' => 'File foto tidak valid atau berbahaya.']);
            }

            $galeri->file_path = SafeUpload::upload(
                file: $file,
                folder: 'uploads/galeri',
                resize: true,
                optimize: true,
                maxWidth: 1600,
                quality: 85
            );

            $galeri->video_url = null;
        }

        /**
         * MODE VIDEO
         */
        if ($request->tipe_media === 'video') {

            if (!preg_match('/(youtube\.com|youtu\.be|vimeo\.com)/i', $request->video_url)) {
                return back()->withErrors(['video_url' => 'Hanya URL YouTube atau Vimeo yang diperbolehkan.']);
            }

            $galeri->file_path = null;
            $galeri->video_url = $request->video_url;
        }

        $galeri->save();

        return redirect()->route('admin.web.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.web.galeri.edit', compact('galeri'));
    }

    /**
     * UPDATE GALERI
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'        => 'nullable|string|max:255',
            'tipe_media'   => 'required|in:image,video',
            'deskripsi'    => 'nullable|string',
            'is_published' => 'nullable|boolean',

            'file_path'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',
            'video_url'    => 'nullable|url|max:500',
        ]);

        $galeri = Galeri::findOrFail($id);

        $galeri->judul        = $request->judul;
        $galeri->tipe_media   = $request->tipe_media;
        $galeri->deskripsi    = $request->deskripsi;
        $galeri->is_published = $request->boolean('is_published');

        /**
         * MODE FOTO
         */
        if ($request->tipe_media === 'image') {

            // Upload foto baru (opsional)
            if ($request->hasFile('file_path')) {

                $file = $request->file('file_path');

                if (!SafeUpload::isRealImage($file)) {
                    return back()->withErrors(['file_path' => 'File foto tidak valid atau berbahaya.']);
                }

                // Hapus file lama jika ada
                if ($galeri->file_path && Storage::disk('public')->exists($galeri->file_path)) {
                    Storage::disk('public')->delete($galeri->file_path);
                }

                $galeri->file_path = SafeUpload::upload(
                    file: $file,
                    folder: 'uploads/galeri',
                    resize: true,
                    optimize: true,
                    maxWidth: 1600,
                    quality: 85
                );
            }

            // Ganti mode → setel menjadi foto
            $galeri->video_url = null;
        }

        /**
         * MODE VIDEO
         */
        if ($request->tipe_media === 'video') {

            if (!preg_match('/(youtube\.com|youtu\.be|vimeo\.com)/i', $request->video_url)) {
                return back()->withErrors(['video_url' => 'Hanya URL YouTube atau Vimeo yang diperbolehkan.']);
            }

            // Hapus file foto lama bila ada
            if ($galeri->file_path && Storage::disk('public')->exists($galeri->file_path)) {
                Storage::disk('public')->delete($galeri->file_path);
            }

            $galeri->file_path = null;
            $galeri->video_url = $request->video_url;
        }

        $galeri->save();

        return redirect()->route('admin.web.galeri.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * HAPUS RECORD + FILE
     */
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->file_path && Storage::disk('public')->exists($galeri->file_path)) {
            Storage::disk('public')->delete($galeri->file_path);
        }

        $galeri->delete();

        return redirect()->route('admin.web.galeri.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }

    /**
     * HAPUS FILE FOTO SAJA
     */
    public function hapusFile(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->file_path && Storage::disk('public')->exists($galeri->file_path)) {
            Storage::disk('public')->delete($galeri->file_path);
        }

        $galeri->file_path = null;
        $galeri->save();

        return back()->with('success', 'File foto berhasil dihapus.');
    }
}
