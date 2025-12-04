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
        $this->validateForm($request);

        $akom = new Akomodasi();
        $this->fillBaseFields($akom, $request);

        $akom->images = $this->processUploads($request);
        $akom->save();

        return redirect()
            ->route('admin.web.akomodasi.index')
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
        $this->validateForm($request);

        $akom = Akomodasi::findOrFail($id);
        $this->fillBaseFields($akom, $request);

        $existing = is_array($akom->images) ? $akom->images : [];

        // Tidak ada file baru diupload
        if (!$request->file('images')) {
            $akom->images = $existing;
            $akom->save();
            return redirect()
                ->route('admin.web.akomodasi.index')
                ->with('success', 'Akomodasi diperbarui.');
        }

        $incoming = $request->file('images');

        if (count($existing) + count($incoming) > 5) {
            return back()
                ->withErrors(['images' => 'Total gambar tidak boleh lebih dari 5.'])
                ->withInput();
        }

        foreach ($incoming as $file) {
            if (!SafeUpload::isRealImage($file)) {
                return back()
                    ->withErrors(['images' => 'File tidak valid.'])
                    ->withInput();
            }

            $existing[] = SafeUpload::upload(
                file: $file,
                folder: 'uploads/akomodasi',
                resize: true,
                optimize: true,
                isHero: false,
                maxWidth: 1600,
                quality: 85
            );
        }

        $akom->images = array_values($existing);
        $akom->save();

        return redirect()
            ->route('admin.web.akomodasi.index')
            ->with('success', 'Akomodasi diperbarui.');
    }

    /**
     * DELETE
     */
        public function destroy($id)
    {
        $akom = Akomodasi::findOrFail($id);

        // hapus gambar di storage
        if ($akom->images) {
            foreach ($akom->images as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $akom->delete();

        // ==== FIX DI SINI ====
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

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

        // ==== FIX DI SINI ====
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }


    /* ===========================================================
       HELPER METHOD: VALIDASI FORM
       =========================================================== */
    private function validateForm(Request $request)
    {
        return $request->validate([
            'nama'        => 'required|string|max:255',
            'tipe'        => 'nullable|string|max:255',
            'alamat'      => 'nullable|string|max:255',
            'telepon'     => 'nullable|string|max:255',
            'price_range' => 'nullable|string|max:255',
            'maps_url'    => 'nullable|url|max:500',
            'excerpt'     => 'nullable|string',
            'deskripsi'   => 'nullable|string',

            'fasilitas'        => 'nullable|array',
            'fasilitas.*'      => 'nullable|string|max:255',

            'images'           => 'nullable|array',
            'images.*'         => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',

            'is_published'     => 'nullable|boolean',
        ]);
    }

    /* ===========================================================
       HELPER METHOD: ISI FIELD TEXT
       =========================================================== */
    private function fillBaseFields(Akomodasi $akom, Request $request)
    {
        $akom->nama         = $request->nama;
        $akom->tipe         = $request->tipe;
        $akom->alamat       = $request->alamat;
        $akom->telepon      = $request->telepon;
        $akom->price_range  = $request->price_range;
        $akom->maps_url     = $request->maps_url;
        $akom->excerpt      = $request->excerpt;
        $akom->deskripsi    = $request->deskripsi;
        $akom->fasilitas    = $request->fasilitas ?? [];
        $akom->is_published = $request->boolean('is_published');
    }

    /* ===========================================================
       HELPER METHOD: UPLOAD GAMBAR BARU
       =========================================================== */
    private function processUploads(Request $request): array
    {
        if (!$request->file('images')) {
            return [];
        }

        $files = [];

        foreach ($request->file('images') as $file) {
            if (!SafeUpload::isRealImage($file)) {
                throw new \RuntimeException('File tidak valid.');
            }

            $files[] = SafeUpload::upload(
                file: $file,
                folder: 'uploads/akomodasi',
                resize: true,
                optimize: true,
                isHero: false,
                maxWidth: 1600,
                quality: 85
            );
        }

        return $files;
    }

    /* ===========================================================
       HELPER METHOD: CEK PATH GAMBAR AMAN
       =========================================================== */
    private function isValidImagePath(string $path): bool
    {
        return str_starts_with($path, 'uploads/akomodasi/');
    }
}
