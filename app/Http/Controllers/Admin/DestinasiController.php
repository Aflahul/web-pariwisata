<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use App\Helpers\SafeUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DestinasiController extends Controller
{
    /**
     * LIST DESTINASI
     */
    public function index()
    {
        $data = Destinasi::orderBy('nama')->paginate(10);
        return view('admin.web.destinasi.index', compact('data'));
    }

    /**
     * HALAMAN TAMBAH
     */
    public function create()
    {
        return view('admin.web.destinasi.create');
    }

    /**
     * SIMPAN DESTINASI
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:255',
            'lokasi'    => 'nullable|string|max:255',
            'maps_url'  => 'nullable|url|max:500',

            'excerpt'   => 'nullable|string',
            'deskripsi' => 'nullable|string',

            // batas jumlah file + per-file size (2048 KB = 2MB)
            'gambar'    => 'nullable|array|max:5',
            'gambar.*'  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'unggulan'  => 'nullable|boolean',
        ]);

        // tambahan safety: pastikan jumlah file <= 5 (double-check)
        if ($request->hasFile('gambar') && !SafeUpload::validateMaxFiles($request->file('gambar'))) {
            return back()->withErrors(['gambar' => 'Maksimal 5 file.'])->withInput();
        }

        $dest = new Destinasi();
        $dest->nama = $request->nama;
        $dest->kategori = $request->kategori;
        $dest->lokasi = $request->lokasi;
        $dest->maps_url = $request->maps_url;
        $dest->excerpt = $request->excerpt;
        $dest->deskripsi = $request->deskripsi;
        $dest->unggulan = $request->boolean('unggulan');

        $gambarArray = [];

        // UPLOAD GAMBAR (MULTIPLE) - aman
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {

                // extra safety check
                if (!SafeUpload::isRealImage($file)) {
                    return back()->withErrors(['gambar' => 'Ada file gambar yang tidak valid atau berbahaya.'])->withInput();
                }

                $path = SafeUpload::upload($file, 'uploads/destinasi'); // returns path relative to disk 'public'
                $gambarArray[] = $path;
            }
        }

        $dest->gambar = $gambarArray;
        $dest->save();

        return redirect()->route('admin.web.destinasi.index')
                         ->with('success', 'Destinasi berhasil ditambahkan.');
    }

    /**
     * HALAMAN EDIT
     */
    public function edit($id)
    {
        $dest = Destinasi::findOrFail($id);
        return view('admin.web.destinasi.edit', compact('dest'));
    }

    /**
     * UPDATE DESTINASI
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:255',
            'lokasi'    => 'nullable|string|max:255',
            'maps_url'  => 'nullable|url|max:500',

            'excerpt'   => 'nullable|string',
            'deskripsi' => 'nullable|string',

            'gambar'    => 'nullable|array|max:5',
            'gambar.*'  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'unggulan'  => 'nullable|boolean',
        ]);

        // double-check jumlah file
        if ($request->hasFile('gambar') && !SafeUpload::validateMaxFiles($request->file('gambar'))) {
            return back()->withErrors(['gambar' => 'Maksimal 5 file.'])->withInput();
        }

        $dest = Destinasi::findOrFail($id);

        $dest->nama = $request->nama;
        $dest->kategori = $request->kategori;
        $dest->lokasi = $request->lokasi;
        $dest->maps_url = $request->maps_url;
        $dest->excerpt = $request->excerpt;
        $dest->deskripsi = $request->deskripsi;
        $dest->unggulan = $request->boolean('unggulan');

        $gambarBaru = $dest->gambar ?? [];

        // UPLOAD GAMBAR BARU (ditambahkan ke array yang ada)
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {

                if (!SafeUpload::isRealImage($file)) {
                    return back()->withErrors(['gambar' => 'Ada file gambar yang tidak valid atau berbahaya.'])->withInput();
                }

                $path = SafeUpload::upload($file, 'uploads/destinasi');
                $gambarBaru[] = $path;
            }

            // Pastikan total tidak melebihi 5 setelah penambahan
            if (count($gambarBaru) > 5) {
                // rollback uploaded new files for cleanliness
                foreach ($gambarBaru as $p) {
                    // hapus semua yang baru di-upload (cek di disk public)
                    if (Storage::disk('public')->exists($p)) {
                        Storage::disk('public')->delete($p);
                    }
                }
                return back()->withErrors(['gambar' => 'Total gambar tidak boleh lebih dari 5.'])->withInput();
            }
        }

        $dest->gambar = $gambarBaru;
        $dest->save();

        return redirect()->route('admin.web.destinasi.index')
                         ->with('success', 'Destinasi berhasil diperbarui.');
    }

    /**
     * HAPUS DESTINASI
     */
    public function destroy($id)
    {
        $dest = Destinasi::findOrFail($id);

        // Hapus semua gambar dari storage/public
        if ($dest->gambar) {
            foreach ($dest->gambar as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $dest->delete();

        return redirect()->route('admin.web.destinasi.index')
                         ->with('success', 'Destinasi berhasil dihapus.');
    }

    /**
     * HAPUS 1 GAMBAR (AJAX atau form)
     */
    public function hapusGambar(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'required|string'
        ]);

        $dest = Destinasi::findOrFail($id);

        $gambar = $request->input('gambar');

        // Pastikan gambar ada di array
        $current = $dest->gambar ?? [];
        if (!in_array($gambar, $current)) {
            return back()->withErrors(['gambar' => 'Gambar tidak ditemukan pada destinasi ini.']);
        }

        // hapus file dari storage/public jika ada
        if (Storage::disk('public')->exists($gambar)) {
            Storage::disk('public')->delete($gambar);
        }

        // update array JSON (hapus elemen)
        $updated = array_filter($current, function ($img) use ($gambar) {
            return $img !== $gambar;
        });

        $dest->gambar = array_values($updated); // reset index array
        $dest->save();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
