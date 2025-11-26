<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenyediaDiving;
use App\Helpers\SafeUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyediaDivingController extends Controller
{
    /**
     * INDEX
     */
    public function index()
    {
        $data = PenyediaDiving::orderBy('nama')->paginate(10);
        return view('admin.web.diving.index', compact('data'));
    }

    /**
     * CREATE
     */
    public function create()
    {
        return view('admin.web.diving.create');
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'kontak'      => 'nullable|string|max:255',
            'alamat'      => 'nullable|string|max:255',
            'maps_url'    => 'nullable|url|max:500',
            'deskripsi'   => 'nullable|string',

            'peralatan'   => 'nullable|array',
            'peralatan.*' => 'nullable|string|max:255',

            'paket'       => 'nullable|array',
            'paket.*'     => 'nullable|string|max:255',

            'gambar'      => 'nullable|array|max:5',
            'gambar.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3048',

            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('gambar') && !SafeUpload::validateMaxFiles($request->file('gambar'), 5)) {
            return back()->withErrors(['gambar' => 'Maksimal 5 file gambar.'])->withInput();
        }

        $d = new PenyediaDiving();
        $d->nama         = $request->nama;
        $d->kontak       = $request->kontak;
        $d->alamat       = $request->alamat;
        $d->maps_url     = $request->maps_url;
        $d->deskripsi    = $request->deskripsi;
        $d->peralatan    = $request->peralatan;
        $d->paket        = $request->paket;
        $d->is_published = $request->boolean('is_published');

        $images = [];

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {

                if (!SafeUpload::isRealImage($file)) {
                    return back()->withErrors(['gambar' => 'Ada file gambar tidak valid atau berbahaya.'])->withInput();
                }

                $images[] = SafeUpload::upload(
                    file: $file,
                    folder: 'uploads/diving',
                    resize: true,
                    optimize: true,
                    maxWidth: 1600,
                    quality: 85
                );
            }
        }

        $d->gambar = $images;
        $d->save();

        return redirect()->route('admin.web.diving.index')
            ->with('success', 'Penyedia diving berhasil ditambahkan.');
    }

    /**
     * EDIT
     */
    public function edit($id)
    {
        $d = PenyediaDiving::findOrFail($id);
        return view('admin.web.diving.edit', compact('d'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'kontak'      => 'nullable|string|max:255',
            'alamat'      => 'nullable|string|max:255',
            'maps_url'    => 'nullable|url|max:500',
            'deskripsi'   => 'nullable|string',

            'peralatan'   => 'nullable|array',
            'peralatan.*' => 'nullable|string|max:255',

            'paket'       => 'nullable|array',
            'paket.*'     => 'nullable|string|max:255',

            'gambar'      => 'nullable|array|max:5',
            'gambar.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3048',

            'is_published' => 'nullable|boolean',
        ]);

        $d = PenyediaDiving::findOrFail($id);

        $d->nama         = $request->nama;
        $d->kontak       = $request->kontak;
        $d->alamat       = $request->alamat;
        $d->maps_url     = $request->maps_url;
        $d->deskripsi    = $request->deskripsi;
        $d->peralatan    = $request->peralatan;
        $d->paket        = $request->paket;
        $d->is_published = $request->boolean('is_published');

        $existing = $d->gambar ?? [];

        if ($request->hasFile('gambar')) {

            $incoming = $request->file('gambar');
            $total = count($existing) + count($incoming);

            if ($total > 5) {
                return back()->withErrors(['gambar' => 'Total gambar tidak boleh lebih dari 5.'])->withInput();
            }

            foreach ($incoming as $file) {

                if (!SafeUpload::isRealImage($file)) {
                    return back()->withErrors(['gambar' => 'Ada file tidak valid atau berbahaya.'])->withInput();
                }

                $existing[] = SafeUpload::upload(
                    file: $file,
                    folder: 'uploads/diving',
                    resize: true,
                    optimize: true,
                    maxWidth: 1600,
                    quality: 85
                );
            }
        }

        $d->gambar = $existing;
        $d->save();

        return redirect()->route('admin.web.diving.index')
            ->with('success', 'Penyedia diving berhasil diperbarui.');
    }

    /**
     * DELETE RECORD
     */
    public function destroy($id)
    {
        $d = PenyediaDiving::findOrFail($id);

        if ($d->gambar) {
            foreach ($d->gambar as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $d->delete();

        return redirect()->route('admin.web.diving.index')
            ->with('success', 'Penyedia diving berhasil dihapus.');
    }

    /**
     * DELETE SINGLE IMAGE
     */
    public function hapusGambar(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'required|string'
        ]);

        $d = PenyediaDiving::findOrFail($id);
        $target = $request->gambar;

        if (in_array($target, $d->gambar ?? [])) {

            if (Storage::disk('public')->exists($target)) {
                Storage::disk('public')->delete($target);
            }

            $updated = array_filter($d->gambar, fn($path) => $path !== $target);

            $d->gambar = array_values($updated);
            $d->save();
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
