<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PenyediaDiving;

class DivingController extends Controller
{
    /**
     * LISTING PENYEDIA DIVING
     */
    public function index()
    {
        $data = PenyediaDiving::where('is_published', 1)
            ->orderBy('nama')
            ->paginate(9);

        return view('frontend.diving.index', compact('data'));
    }

    /**
     * DETAIL PENYEDIA DIVING
     */
    public function show($slug)
    {
        $diving = PenyediaDiving::where('slug', $slug)
            ->where('is_published', 1)
            ->firstOrFail();

        // GALLERY fallback
        $gallery = $diving->gambar;
        if (!$gallery || count($gallery) === 0) {
            $gallery = ['frontend/img/default.png'];
        }

        // PERALATAN
        $peralatan = $diving->peralatan ?? [];

        // PAKET
        $paket = $diving->paket ?? [];

        return view('frontend.diving.show', compact(
            'diving',
            'gallery',
            'peralatan',
            'paket'
        ));
    }

}
