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
        $this->validateForm($request);

        $d = new PenyediaDiving();
        $this->fillBaseFields($d, $request);

        $d->gambar = $this->processUploads($request, []);
        $d->save();

        return redirect()
            ->route('admin.web.diving.index')
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
        $this->validateForm($request);

        $d = PenyediaDiving::findOrFail($id);
        $this->fillBaseFields($d, $request);

        $existing = is_array($d->gambar) ? $d->gambar : [];

        // jika tidak upload gambar baru
        if (!$request->hasFile('gambar')) {
            $d->save();
            return redirect()
                ->route('admin.web.diving.index')
                ->with('success', 'Penyedia diving berhasil diperbarui.');
        }

        // ada upload baru
        $incoming = $request->file('gambar');
        if (count($existing) + count($incoming) > 5) {
            return back()->withErrors(['gambar' => 'Total gambar tidak boleh lebih dari 5.'])
                         ->withInput();
        }

        $d->gambar = $this->processUploads($request, $existing);
        $d->save();

        return redirect()
            ->route('admin.web.diving.index')
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

        // JSON response untuk modal global delete
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()
            ->route('admin.web.diving.index')
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

            $d->gambar = array_values(array_filter(
                $d->gambar,
                fn($path) => $path !== $target
            ));
            $d->save();
        }

        // jika request dari modal delete global
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }



    /* ===========================================================
       VALIDASI FORM
    =========================================================== */
    private function validateForm(Request $request)
    {
        return $request->validate([
            'nama'        => 'required|string|max:255',
            'kontak'      => 'nullable|string|max:255',
            'alamat'      => 'nullable|string|max:255',
            'maps_url'    => 'nullable|url|max:500',
            'deskripsi'   => 'nullable|string',

            'peralatan'      => 'nullable|array',
            'peralatan.*'    => 'nullable|string|max:255',

            'paket'          => 'nullable|array',
            'paket.*'        => 'nullable|string|max:255',

            'gambar'         => 'nullable|array',
            'gambar.*'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3048',

            'is_published'   => 'nullable|boolean',
            ], [
        // custom message bahasa Indonesia
        'nama.required' => 'Nama penyedia wajib diisi.',
        'gambar.*.max'  => 'Setiap gambar maksimal 3MB.',
        'gambar.*.mimes'=> 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
        'maps_url.url'  => 'Format URL Google Maps tidak valid.',
    
        ]);
    }


    /* ===========================================================
       ISI FIELD TEXT
    =========================================================== */
    private function fillBaseFields(PenyediaDiving $d, Request $request)
    {
        $d->nama         = $request->nama;
        $d->kontak       = $request->kontak;
        $d->alamat       = $request->alamat;
        $d->maps_url     = $request->maps_url;
        $d->deskripsi    = $request->deskripsi;

        $d->peralatan    = $request->peralatan ?? [];
        $d->paket        = $request->paket ?? [];

        $d->is_published = $request->boolean('is_published');
    }


    /* ===========================================================
       UPLOAD GAMBAR
    =========================================================== */
    private function processUploads(Request $request, array $existing = []): array
    {
        if (!$request->hasFile('gambar')) {
            return $existing;
        }

        foreach ($request->file('gambar') as $file) {

            if (!SafeUpload::isRealImage($file)) {
                throw new \RuntimeException('File gambar tidak valid / berbahaya.');
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

        return $existing;
    }
}
