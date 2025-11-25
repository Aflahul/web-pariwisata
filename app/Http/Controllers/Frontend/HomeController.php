<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Galeri;
use App\Models\Akomodasi;
use App\Models\Destinasi;
use App\Models\PenyediaDiving;
use App\Models\InformasiDaerah;
use App\Models\FrontpageSetting;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil pengaturan frontpage
        $fp = FrontpageSetting::first();

        if ($fp && $fp->slider) {
            $sliderIDs = json_decode($fp->slider, true);
            $sliderItems = Destinasi::whereIn('id', $sliderIDs)->get();

        } else {
            $sliderItems = collect(); // empty collection
        }
        $info = InformasiDaerah::first();


        // Destinasi unggulan
        $unggulan = Destinasi::where('unggulan', 1)->get();


        // Akomodasi rekomendasi
        $akomodasi = Akomodasi::where('is_published', 1)
            ->latest()
            ->limit(3)
            ->get();

        // Diving rekomendasi
        $diving = PenyediaDiving::where('is_published', 1)
            ->latest()
            ->limit(3)
            ->get();

        // Galeri terbaru
        $galeri = Galeri::where('is_published', 1)
            ->latest()
            ->limit(8)
            ->get();

        return view('frontend.home.index', compact(
            'fp',
            'sliderItems',
            'unggulan',
            'akomodasi',
            'diving',
            'info',
            'galeri'
        ));
    }
}
