<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use App\Helpers\SafeUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

            'gambar'    => 'nullable|array|max:5',
            'gambar.*'  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',

            'unggulan'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('gambar') && !SafeUpload::validateMaxFiles($request->file('gambar'), 5)) {
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

        $gambarArr = [];

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {

                if (!SafeUpload::isRealImage($file)) {
                    return back()->withErrors(['gambar' => 'Ada file gambar yang tidak valid atau berbahaya.'])->withInput();
                }

                $gambarArr[] = SafeUpload::upload($file, 'uploads/destinasi');
            }
        }

        $dest->gambar = $gambarArr;
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
            'gambar.*'  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',

            'unggulan'  => 'nullable|boolean',
        ]);

        $dest = Destinasi::findOrFail($id);

        // update field biasa
        $dest->nama = $request->nama;
        $dest->kategori = $request->kategori;
        $dest->lokasi = $request->lokasi;
        $dest->maps_url = $request->maps_url;
        $dest->excerpt = $request->excerpt;
        $dest->deskripsi = $request->deskripsi;
        $dest->unggulan = $request->boolean('unggulan');

        $existing = $dest->gambar ?? [];

        // jika tidak upload gambar baru, langsung save
        if (!$request->hasFile('gambar')) {
            $dest->save();
            return redirect()->route('admin.web.destinasi.index')
                ->with('success', 'Destinasi berhasil diperbarui.');
        }

        // cek total sebelum upload
        $incoming = $request->file('gambar');
        $total = count($existing) + count($incoming);

        if ($total > 5) {
            return back()->withErrors(['gambar' => 'Total gambar tidak boleh lebih dari 5.'])->withInput();
        }

        // upload gambar baru
        foreach ($incoming as $file) {

            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['gambar' => 'Ada file gambar tidak valid atau berbahaya.'])->withInput();
            }

            $existing[] = SafeUpload::upload($file, 'uploads/destinasi');
        }

        // simpan array final
        $dest->gambar = $existing;
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
     * HAPUS 1 GAMBAR
     */
    public function hapusGambar(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'required|string'
        ]);

        $dest = Destinasi::findOrFail($id);
        $gambar = $request->gambar;

        if (in_array($gambar, $dest->gambar ?? [])) {

            if (Storage::disk('public')->exists($gambar)) {
                Storage::disk('public')->delete($gambar);
            }

            $updated = array_filter($dest->gambar, fn($img) => $img !== $gambar);
            $dest->gambar = array_values($updated);
            $dest->save();
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
