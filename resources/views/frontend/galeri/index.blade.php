@extends('frontend.layouts.master')

@section('title', 'Galeri Wisata Supiori')
@section('meta_description', 'Koleksi foto dan video keindahan alam serta destinasi wisata Kabupaten Supiori.')

@section('content')

    {{-- HERO --}}
    <div class="container-fluid page-header py-5"
        style="background:
            linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.4)),
            url('{{ image_path($fp->hero_image ?? null) }}');
            background-size: cover;
            background-position: center;">
        <div class="section-title text-center z-50 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style pt-4">
                <h5 class="sub-title text-light px-3">Galeri Wisata</h5>
            </div>
            <h1 class="display-4 text-light">Temukan Keindahan Wisata Supiori</h1>
            <p class="text-light fw-semibold mb-0">
                Kumpulan foto dan video terbaru dari Supiori.
            </p>
        </div>
    </div>

    {{-- GALERI LIST --}}
    <div class="container-fluid country py-5">
        <div class="container">

            <div class="row g-4">

                @foreach ($items as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.1 }}s">
                        <div class="country-item">

                            {{-- FOTO --}}
                            @if ($item['type'] === 'photo')
                                <div class="rounded country-img overflow-hidden mb-3">
                                    <img src="{{ image_path($item['src']) }}" class="img-fluid w-100 rounded"
                                        alt="{{ $item['title'] ?? 'foto wisata' }}">
                                </div>

                                {{-- VIDEO --}}
                            @elseif($item['type'] === 'video')
                                <div class="rounded overflow-hidden mb-3">
                                    <iframe width="100%" height="200" src="{{ $item['src'] }}" frameborder="0"
                                        allowfullscreen class="rounded">
                                    </iframe>
                                </div>
                            @endif
                            @if ($item['title'])
                                <div class="country-name">
                                    <a class="text-white fs-4">{{ $item['title'] }}</a>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach

            </div>

            {{-- PAGINATION --}}
            <div class="mt-4">
                {{ $items->links() }}
            </div>

        </div>
    </div>

@endsection
