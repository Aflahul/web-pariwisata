<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Culture;
use App\Helpers\SafeUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CultureController extends Controller
{
    public function index()
    {
        $data = Culture::orderBy('id', 'desc')->paginate(15);
        return view('admin.web.budaya.index', compact('data'));
    }

    public function create()
    {
        return view('admin.web.budaya.create');
    }

    public function store(Request $r)
    {
        $this->validateForm($r);

        $culture = new Culture();
        $this->fillBaseFields($culture, $r);

        // generate slug
        $culture->slug = Str::slug($r->judul . '-' . uniqid());

        // upload gambar
        if ($r->hasFile('gambar')) {
            $file = $r->file('gambar');

            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['gambar' => 'File gambar tidak valid'])->withInput();
            }

            $culture->gambar = SafeUpload::upload(
                file: $file,
                folder: 'uploads/budaya',
                resize: true,
                optimize: true,
                isHero: false,
                maxWidth: 1600,
                quality: 85
            );
        }

        $culture->save();

        return redirect()
            ->route('admin.web.budaya.index')
            ->with('success', 'Data budaya berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $budaya = Culture::findOrFail($id);
        return view('admin.web.budaya.edit', compact('budaya'));
    }

    public function update(Request $r, $id)
    {
        $this->validateForm($r, update: true);

        $culture = Culture::findOrFail($id);

        // jika judul berubah → slug diganti juga
        if ($culture->judul !== $r->judul) {
            $culture->slug = Str::slug($r->judul . '-' . uniqid());
        }

        $this->fillBaseFields($culture, $r);

        // upload gambar baru
        if ($r->hasFile('gambar')) {
            $file = $r->file('gambar');

            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['gambar' => 'File gambar tidak valid'])->withInput();
            }

            // hapus lama
            if ($culture->gambar && Storage::disk('public')->exists($culture->gambar)) {
                Storage::disk('public')->delete($culture->gambar);
            }

            $culture->gambar = SafeUpload::upload(
                file: $file,
                folder: 'uploads/budaya',
                resize: true,
                optimize: true,
                isHero: false,
                maxWidth: 1600,
                quality: 85
            );
        }

        $culture->save();

        return redirect()
            ->route('admin.web.budaya.index')
            ->with('success', 'Data budaya berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $culture = Culture::findOrFail($id);

        if ($culture->gambar && Storage::disk('public')->exists($culture->gambar)) {
            Storage::disk('public')->delete($culture->gambar);
        }

        $culture->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()
            ->route('admin.web.budaya.index')
            ->with('success', 'Data budaya berhasil dihapus.');
    }

    private function validateForm(Request $r, bool $update = false)
    {
        return $r->validate([
            'jenis'      => 'required|in:tradisi,adat,tarian,musik,kuliner,kerajinan,sejarah',
            'judul'      => 'required|max:255',
            'ringkasan'  => 'required|max:255',
            'deskripsi'  => 'required',
            'lokasi'     => 'nullable|max:255',
            'gambar'     => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',
            'status'     => 'required|boolean',
        ]);
    }

    private function fillBaseFields(Culture $c, Request $r)
    {
        $c->jenis     = $r->jenis;
        $c->judul     = $r->judul;
        $c->ringkasan = $r->ringkasan;
        $c->deskripsi = $r->deskripsi;
        $c->lokasi    = $r->lokasi;
        $c->status    = $r->boolean('status');
    }
}
