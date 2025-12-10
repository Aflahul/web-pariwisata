<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Akomodasi;

class AkomodasiController extends Controller
{
    /**
     * LISTING AKOMODASI
     */
    public function index()
    {
        $data = Akomodasi::where('is_published', 1)
            ->orderBy('nama')
            ->paginate(9);

        return view('frontend.akomodasi.index', compact('data'));
    }

    /**
     * DETAIL AKOMODASI
     */
    public function show($slug)
    {
        $data = Akomodasi::where('slug', $slug)
            ->where('is_published', 1)
            ->firstOrFail();

        // GALLERY fallback
        $gallery = $data->images;
        if (!$gallery || count($gallery) === 0) {
            $gallery = ['frontend/img/default.png'];
        }

        // FASILITAS fallback
        $fasilitas = $data->fasilitas ?? [];

        return view('frontend.akomodasi.show', compact(
            'data',
            'gallery',
            'fasilitas'
        ));
    }

}
