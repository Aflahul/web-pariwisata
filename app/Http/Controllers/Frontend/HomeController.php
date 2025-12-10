<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Galeri;
use App\Models\Culture;
use App\Models\Akomodasi;
use App\Models\Destinasi;
use App\Models\PenyediaDiving;
use App\Models\InformasiDaerah;
use App\Models\FrontpageSetting;
use Illuminate\Support\Collection;
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
        $unggulan = Destinasi::where('unggulan', 1)
            ->latest()
            ->limit(6)
            ->get();

        // Budaya terbaru
        $budaya = Culture::where('status', 1)
            ->latest()
            ->limit(6)
            ->get();


        // Akomodasi rekomendasi
        $akomodasi = Akomodasi::where('is_published', 1)
            ->latest()
            ->limit(3)
            ->get();

        // Diving rekomendasi
        $diving = PenyediaDiving::where('is_published', 1)
            ->latest()
            ->limit(4)
            ->get();

        $galeri = new Collection();
        // 1. Foto/Video dari tabel galeri umum
        $galeriUmum = Galeri::where('is_published', 1)
            ->latest()
            ->get()
            ->map(function ($g) {
                return [
                    'type'  => $g->jenis === 'video' ? 'video' : 'photo',
                    'src'   => $g->jenis === 'video' ? $g->video_url : $g->image,
                    'title' => $g->title,
                    'from'  => 'galeri'
                ];
            });

        $galeri = $galeri->merge($galeriUmum);

        // 2. Semua foto dari destinasi
       $destinasi = Destinasi::all();

        foreach ($destinasi as $dest) {

            if (empty($dest->gambar)) continue;  // karena sudah array, cukup cek kosong

            foreach ($dest->gambar as $img) {
                if (!$img) continue; // skip null atau string kosong
                $galeri->push([
                    'type'  => 'photo',
                    'src'   => $img,
                    'title' => $dest->nama,
                    'from'  => 'destinasi'
                ]);
            }
        }

        // 3. Galeri umum muncul dulu, destinasi di bawahnya
        $galeri = $galeri->sortByDesc('from')->values();

        // 4. Limit untuk beranda
        $galeri = $galeri->take(8);

        return view('frontend.home.index', compact(
            'fp',
            'sliderItems',
            'unggulan',
            'akomodasi',
            'diving',
            'info',
            'galeri',    
            'budaya'
        ));
    }
}
