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
     * List galeri
     */
    public function index()
    {
        $data = Galeri::orderByDesc('id')->paginate(12);
        return view('admin.web.galeri.index', compact('data'));
    }

    /**
     * Form tambah
     */
    public function create()
    {
        return view('admin.web.galeri.create');
    }

    /**
     * Simpan galeri baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'nullable|string|max:255',
            'tipe_media'   => 'required|in:image,video',
            'deskripsi'    => 'nullable|string',
            'is_published' => 'nullable|boolean',

            // Foto
            'file_path'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // Video
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

            // Signature check
            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['file_path' => 'File foto tidak valid atau berbahaya.']);
            }

            $path = SafeUpload::upload($file, 'uploads/galeri');
            $galeri->file_path = $path;
            $galeri->video_url = null;
        }

        /**
         * MODE VIDEO
         */
        if ($request->tipe_media === 'video') {

            // Sanitasi dasar: hanya YouTube atau Vimeo
            if (!preg_match('/(youtube\.com|youtu\.be|vimeo\.com)/i', $request->video_url)) {
                return back()->withErrors([
                    'video_url' => 'Hanya URL YouTube atau Vimeo yang diperbolehkan.'
                ]);
            }

            $galeri->file_path = null;
            $galeri->video_url = $request->video_url;
        }

        $galeri->save();

        return redirect()->route('admin.web.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.web.galeri.edit', compact('galeri'));
    }

    /**
     * Update galeri
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'        => 'nullable|string|max:255',
            'tipe_media'   => 'required|in:image,video',
            'deskripsi'    => 'nullable|string',
            'is_published' => 'nullable|boolean',

            'file_path'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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

            if ($request->hasFile('file_path')) {

                $file = $request->file('file_path');

                if (!SafeUpload::isRealImage($file)) {
                    return back()->withErrors(['file_path' => 'File foto tidak valid atau berbahaya.']);
                }

                // Hapus file lama
                if ($galeri->file_path) {
                    $oldPath = 'uploads/galeri/' . basename($galeri->file_path);

                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                $path = SafeUpload::upload($file, 'uploads/galeri');
                $galeri->file_path = $path;
            }

            // ganti mode → pastikan video_url kosong
            $galeri->video_url = null;
        }

        /**
         * MODE VIDEO
         */
        if ($request->tipe_media === 'video') {

            // Hanya YouTube atau Vimeo
            if (!preg_match('/(youtube\.com|youtu\.be|vimeo\.com)/i', $request->video_url)) {
                return back()->withErrors([
                    'video_url' => 'Hanya URL YouTube atau Vimeo yang diperbolehkan.'
                ]);
            }

            // Hapus file foto lama
            if ($galeri->file_path) {
                $oldPath = 'uploads/galeri/' . basename($galeri->file_path);

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $galeri->file_path = null;
            $galeri->video_url = $request->video_url;
        }

        $galeri->save();

        return redirect()->route('admin.web.galeri.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Hapus 1 record + file foto
     */
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->file_path) {

            $path = 'uploads/galeri/' . basename($galeri->file_path);

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $galeri->delete();

        return redirect()->route('admin.web.galeri.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }

    /**
     * Hapus file foto tanpa hapus record
     */
    public function hapusFile(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->file_path) {

            $path = 'uploads/galeri/' . basename($galeri->file_path);

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $galeri->file_path = null;
        $galeri->save();

        return back()->with('success', 'File foto berhasil dihapus.');
    }
}
