<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akomodasi;
use App\Helpers\SafeUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AkomodasiController extends Controller
{
    /**
     * INDEX
     */
    public function index()
    {
        $data = Akomodasi::orderBy('nama')->paginate(10);
        return view('admin.web.akomodasi.index', compact('data'));
    }

    /**
     * CREATE
     */
    public function create()
    {
        return view('admin.web.akomodasi.create');
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'tipe'        => 'nullable|string|max:255',
            'alamat'      => 'nullable|string|max:255',
            'telepon'     => 'nullable|string|max:255',
            'price_range' => 'nullable|string|max:255',
            'maps_url'    => 'nullable|url|max:500',

            'excerpt'     => 'nullable|string',
            'deskripsi'   => 'nullable|string',

            'fasilitas'   => 'nullable|array',
            'fasilitas.*' => 'nullable|string|max:255',

            'images'      => 'nullable|array|max:5',
            'images.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',

            'is_published'=> 'nullable|boolean',
        ]);

        if ($request->hasFile('images') && !SafeUpload::validateMaxFiles($request->file('images'))) {
            return back()->withErrors(['images' => 'Maksimal 5 file.'])->withInput();
        }

        $akom = new Akomodasi();

        $akom->nama        = $request->nama;
        $akom->tipe        = $request->tipe;
        $akom->alamat      = $request->alamat;
        $akom->telepon     = $request->telepon;
        $akom->price_range = $request->price_range;
        $akom->maps_url    = $request->maps_url;
        $akom->excerpt     = $request->excerpt;
        $akom->deskripsi   = $request->deskripsi;
        $akom->fasilitas   = $request->fasilitas;
        $akom->is_published = $request->boolean('is_published');

        $files = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {

                if (!SafeUpload::isRealImage($file)) {
                    return back()->withErrors(['images' => 'Ada file yang tidak valid atau berbahaya.'])->withInput();
                }

                $files[] = SafeUpload::upload($file, 'uploads/akomodasi');
            }
        }

        $akom->images = $files;
        $akom->save();

        return redirect()->route('admin.web.akomodasi.index')
            ->with('success', 'Akomodasi berhasil ditambahkan.');
    }

    /**
     * EDIT
     */
    public function edit($id)
    {
        $akom = Akomodasi::findOrFail($id);
        return view('admin.web.akomodasi.edit', compact('akom'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'tipe'        => 'nullable|string|max:255',
            'alamat'      => 'nullable|string|max:255',
            'telepon'     => 'nullable|string|max:255',
            'price_range' => 'nullable|string|max:255',
            'maps_url'    => 'nullable|url|max:500',

            'excerpt'     => 'nullable|string',
            'deskripsi'   => 'nullable|string',

            'fasilitas'   => 'nullable|array',
            'fasilitas.*' => 'nullable|string|max:255',

            'images'      => 'nullable|array|max:5',
            'images.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',

            'is_published'=> 'nullable|boolean',
        ]);

        if ($request->hasFile('images') && !SafeUpload::validateMaxFiles($request->file('images'))) {
            return back()->withErrors(['images' => 'Maksimal 5 file.'])->withInput();
        }

        $akom = Akomodasi::findOrFail($id);

        $akom->nama        = $request->nama;
        $akom->tipe        = $request->tipe;
        $akom->alamat      = $request->alamat;
        $akom->telepon     = $request->telepon;
        $akom->price_range = $request->price_range;
        $akom->maps_url    = $request->maps_url;
        $akom->excerpt     = $request->excerpt;
        $akom->deskripsi   = $request->deskripsi;
        $akom->fasilitas   = $request->fasilitas;
        $akom->is_published = $request->boolean('is_published');

        $files = $akom->images ?? [];

        if ($request->hasFile('images')) {

            // upload baru
            foreach ($request->file('images') as $file) {

                if (!SafeUpload::isRealImage($file)) {
                    return back()->withErrors(['images' => 'Ada file tidak valid atau berbahaya.'])->withInput();
                }

                $files[] = SafeUpload::upload($file, 'uploads/akomodasi');
            }

            if (count($files) > 5) {

                // rollback file baru
                foreach ($files as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }

                return back()->withErrors(['images' => 'Total gambar tidak boleh lebih dari 5.'])->withInput();
            }
        }

        $akom->images = $files;
        $akom->save();

        return redirect()->route('admin.web.akomodasi.index')
            ->with('success', 'Akomodasi berhasil diperbarui.');
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        $akom = Akomodasi::findOrFail($id);

        if ($akom->images) {
            foreach ($akom->images as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $akom->delete();

        return redirect()->route('admin.web.akomodasi.index')
            ->with('success', 'Akomodasi berhasil dihapus.');
    }

    /**
     * DELETE ONE IMAGE
     */
    public function hapusGambar(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'required|string'
        ]);

        $akom = Akomodasi::findOrFail($id);
        $gambar = $request->gambar;

        if (in_array($gambar, $akom->images ?? [])) {

            if (Storage::disk('public')->exists($gambar)) {
                Storage::disk('public')->delete($gambar);
            }

            $updated = array_filter($akom->images, fn($img) => $img !== $gambar);
            $akom->images = array_values($updated);
            $akom->save();
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
