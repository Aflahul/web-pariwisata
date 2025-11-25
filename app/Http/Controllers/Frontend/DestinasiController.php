<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;

class DestinasiController extends Controller
{
    /**
     * LISTING DESTINASI
     */
    public function index()
    {
        $data = Destinasi::orderBy('nama')
            ->paginate(9);

        return view('frontend.destinasi.index', compact('data'));
    }

    /**
     * DETAIL DESTINASI
     */
    public function show($slug)
    {
        $dest = Destinasi::where('slug', $slug)
            ->firstOrFail();

        // GALLERY fallback
        $gallery = $dest->gambar;
        if (!$gallery || count($gallery) === 0) {
            $gallery = ['frontend/img/default.png'];
        }

        return view('frontend.destinasi.show', compact(
            'dest',
            'gallery'
        ));
    }

}
