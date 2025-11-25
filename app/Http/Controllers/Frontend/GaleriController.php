<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Destinasi;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class GaleriController extends Controller
{
    /**
     * LISTING GALERI (Destinasi + Galeri Umum)
     */
    public function index()
    {
        $items = new Collection();

        // 1. AMBIL GALERI UMUM (foto/video)
        $galeriUmum = Galeri::where('is_published', 1)
            ->latest()
            ->get()
            ->map(function ($g) {
                return [
                    'type' => $g->jenis === 'video' ? 'video' : 'photo',
                    'src' => $g->jenis === 'video' ? $g->video_url : $g->image,
                    'title' => $g->title,
                    'from' => 'galeri'
                ];
            });

        $items = $items->merge($galeriUmum);

        // 2. AMBIL SEMUA FOTO DARI DESTINASI
        $destinasi = Destinasi::where('is_published', 1)->get();

        foreach ($destinasi as $dest) {
            if (is_array($dest->gambar)) {
                foreach ($dest->gambar as $img) {
                    $items->push([
                        'type' => 'photo',
                        'src' => $img,
                        'title' => $dest->nama,
                        'from' => 'destinasi'
                    ]);
                }
            }
        }

        // 3. URUTKAN (galeri umum lebih baru → duluan)
        $items = $items->sortByDesc('from')->values();

        // 4. PAGINATION MANUAL (karena array gabungan)
        $page = request()->get('page', 1);
        $perPage = 12;

        $paginated = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('frontend.galeri.index', [
            'items' => $paginated
        ]);
    }
}
