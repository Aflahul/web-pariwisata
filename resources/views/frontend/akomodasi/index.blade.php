@extends('frontend.layouts.master')

@section('title', 'Akomodasi di Supiori')
@section('meta_description', 'Daftar penginapan dan hotel terbaik di Kabupaten Supiori.')

@section('content')

    {{-- HERO SECTION --}}
    <div class="container-fluid page-header py-5"
        style="
            background:
                linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.4)),
                url('{{ image_path($fp->hero_image ?? null) }}');
            background-size: cover;
            background-position: center;
        ">
        <div class="section-title text-center z-50 wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 70px;">
            <div class="sub-style pt-4">
                <h5 class="sub-title text-light px-3">AKOMODASI</h5>
            </div>

            <h1 class="display-4 text-light">Akomodasi Rekomendasi di Supiori</h1>

            <p class="mb-0 text-light fw-semibold">
                Pilihan tempat menginap terbaik dengan kenyamanan dan akses mudah ke lokasi wisata.
            </p>
        </div>
    </div>

    {{-- LISTING --}}
    <div class="container-fluid training overflow-hidden py-5">
        <div class="container">

            <div class="row g-4 justify-content-center">

                @forelse ($data as $akom)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.15 }}s">

                        <div class="training-item">

                            {{-- IMAGE --}}
                            <div class="training-img">
                                <img src="{{ image_path($akom->images[0] ?? null) }}"
                                     alt="{{ $akom->nama }}"
                                     class="img-fluid w-100 rounded">

                                <div class="training-title-name">
                                    <span class="h4 text-white mb-0">{{ $akom->nama }}</span>
                                    <span class="h4 text-white mb-0">{{ $akom->tipe ?: 'Akomodasi' }}</span>
                                </div>
                            </div>

                            {{-- CONTENT --}}
                            <div class="training-content bg-secondary rounded-bottom p-4">

                                <h4 class="text-white mb-2">{{ $akom->nama }}</h4>

                                @if ($akom->price_range)
                                    <p class="text-white-50 mb-3">
                                        Harga: {{ $akom->price_range }}
                                    </p>
                                @endif

                                <a href="{{ route('front.akomodasi.show', $akom->slug) }}"
                                   class="btn btn-secondary rounded-pill text-white p-0 px-3 py-1">
                                    Lihat Detail <i class="fa fa-arrow-right ms-1"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                @empty
                    <div class="col-12 text-center py-5">
                        <h5 class="text-muted">Belum ada data akomodasi.</h5>
                    </div>
                @endforelse

            </div>

        </div>
    </div>

@endsection
