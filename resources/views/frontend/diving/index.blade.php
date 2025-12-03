@extends('frontend.layouts.master')

@section('title', 'Penyedia Jasa Wisata Supiori')
@section('meta_description', 'Daftar penyedia jasa wisata terbaik di Kabupaten Supiori.')

@section('content')
    <div class="container-fluid page-header py-5"
        style="background: linear-gradient(rgba(0, 58, 102, 0.3),rgba(0, 58, 102, 0.2)), 
                 url('{{ image_path($fp->hero_image ?? null) }}');
                background-size: cover;
                background-position: center;">
        <div class="section-title text-center z-50 wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 70px;">
            <div class="sub-style pt-4">
                <h5 class="sub-title text-light px-3 ">Penyedia Jasa Wisata</h5>
            </div>
            <h1 class="display-4 text-light">Penyedia Jasa dan Alat Diving di Supiori</h1>
            <p class="mb-0 text-light fw-semibold">Temukan penyedia alat diving profesional untuk eksplorasi bawah laut yang
                aman dan menyenangkan.
            </p>
        </div>
    </div>

    <div class="container-fluid office overflow-hidden py-5">
        <div class="container">


            <div class="row g-4">

                @foreach ($data as $dv)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.2 }}s">

                        <div class="office-item p-4">

                            {{-- FOTO --}}
                            <div class="office-img rounded overflow-hidden mb-4 text-center">
                                <img src="{{ image_path($dv->gambar[0] ?? null) }}" alt="{{ $dv->nama }}"
                                    class="img-fluid w-100">
                            </div>

                            {{-- NAMA --}}
                            <h5 class="mb-3">{{ $dv->nama }}</h5>

                            {{-- ALAMAT --}}
                            @if ($dv->alamat)
                                <p class="mb-2">
                                    <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                    {{ $dv->alamat }}
                                </p>
                            @endif

                            {{-- KONTAK --}}
                            @if ($dv->kontak)
                                <p class="mb-3">
                                    <i class="fa fa-phone text-primary me-2"></i>
                                    {{ $dv->kontak }}
                                </p>
                            @endif

                            {{-- LINK DETAIL --}}
                            <a class="btn btn-primary border-secondary rounded-pill py-3 px-5"
                                href="{{ route('front.diving.show', $dv->slug) }}">
                                Lihat Detail
                            </a>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>
    </div>

@endsection
