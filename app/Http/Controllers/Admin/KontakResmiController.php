<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakResmi;
use Illuminate\Http\Request;

class KontakResmiController extends Controller
{
    /**
     * Halaman edit kontak resmi
     */
    public function edit()
    {
        // Pastikan hanya 1 record
        $kontak = KontakResmi::first();

        if (!$kontak) {
            $kontak = KontakResmi::create([
                'alamat' => null,
                'telepon' => null,
                'whatsapp' => null,
                'email' => null,
                'jam_operasional' => null,
                'maps_url' => null,
                'facebook' => null,
                'instagram' => null,
                'youtube' => null,
                'tiktok' => null,
            ]);
        }

        return view('admin.web.kontak.edit', compact('kontak'));
    }

    /**
     * Update kontak resmi (AMAN)
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'alamat'          => 'nullable|string|max:500',
            'telepon'         => 'nullable|string|max:100',
            'whatsapp'        => 'nullable|string|max:100',
            'email'           => 'nullable|email|max:255',
            'jam_operasional' => 'nullable|string|max:255',
            'maps_url'        => 'nullable|url|max:500',

            'facebook'        => 'nullable|url|max:500',
            'instagram'       => 'nullable|url|max:500',
            'youtube'         => 'nullable|url|max:500',
            'tiktok'          => 'nullable|url|max:500',
        ]);

        $kontak = KontakResmi::firstOrFail();

        // Isi hanya kolom yang diizinkan
        $kontak->fill($validated);
        $kontak->save();

        return redirect()
            ->route('admin.web.kontak.edit')
            ->with('success', 'Kontak resmi berhasil diperbarui dengan aman.');
    }
}
