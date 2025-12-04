@extends('frontend.layouts.master')

@section('title', 'Penyedia Jasa Wisata Supiori')
@section('meta_description', 'Daftar penyedia jasa wisata terbaik di Kabupaten Supiori.')

@section('content')

    {{-- HERO --}}
    <div class="container-fluid page-header py-5"
        style="background:
        linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.4)),
        url('{{ image_path($fp->hero_image ?? null) }}');
        background-size: cover;
        background-position: center;">
        <div class="section-title text-center z-50 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style pt-4">
                <h5 class="sub-title text-light px-3">Penyedia Jasa Wisata</h5>
            </div>
            <h1 class="display-4 text-light">Penyedia Jasa dan Alat Diving di Supiori</h1>
            <p class="mb-0 text-light fw-semibold">
                Temukan penyedia alat diving profesional untuk eksplorasi bawah laut yang aman.
            </p>
        </div>
    </div>

    {{-- LIST --}}
    <div class="container-fluid contact overflow-hidden py-5">
        <div class="container">

            @if ($data->count() == 0)
                <div class="text-center py-5">
                    <h5 class="text-muted">Belum ada penyedia jasa wisata yang tersedia.</h5>
                </div>
            @else
                <div class="row g-4 office justify-content-center">

                    @foreach ($data as $dv)
                        <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.2 }}s">

                            <div class="office-item p-4 ">

                                {{-- FOTO --}}
                                <div class="office-img mb-4">
                                    <img src="{{ image_path($dv->gambar[0] ?? null) }}" class="img-fluid w-100 rounded"
                                        alt="{{ $dv->nama }}">
                                </div>

                                {{-- CONTENT --}}
                                <div class="office-content d-flex flex-column">

                                    <h4 class="mb-2">{{ $dv->nama }}</h4>

                                    @if ($dv->kontak)
                                        <a href="tel:{{ $dv->kontak }}" class="text-secondary fs-5 mb-2">
                                            {{ $dv->kontak }}
                                        </a>
                                    @endif

                                    @if ($dv->email)
                                        <a href="mailto:{{ $dv->email }}" class="text-muted fs-5 mb-2">
                                            {{ $dv->email }}
                                        </a>
                                    @endif

                                    @if ($dv->alamat)
                                        <p class="mb-0">{{ $dv->alamat }}</p>
                                    @endif

                                    {{-- Detail --}}
                                    <a href="{{ route('front.diving.show', $dv->slug) }}"
                                        class="btn btn-primary rounded-pill mt-3 px-4 py-2">
                                        Lihat Detail
                                    </a>

                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

            @endif

        </div>
    </div>

@endsection
