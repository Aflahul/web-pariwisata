@extends('frontend.layouts.master')

@section('title', 'Akomodasi di Supiori')
@section('meta_description', 'Daftar penginapan dan hotel terbaik di Kabupaten Supiori.')

@section('content')
    <div class="container-fluid page-header py-5"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.4)),
                 url('{{ image_path($fp->hero_image ?? null) }}');
                background-size: cover;
                background-position: center;">
        <div class="section-title text-center z-50 wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 70px;">
            <div class="sub-style pt-4">
                <h5 class="sub-title text-light px-3 ">AKOMODASI</h5>
            </div>
            <h1 class="display-4 text-light">Akomodasi Rekomendasi di Supiori</h1>
            <p class="mb-0 text-light fw-semibold">Pilihan tempat menginap terbaik dengan kenyamanan dan akses
                mudah ke lokasi wisata.</p>
        </div>
    </div>
    <div class="container-fluid training overflow-hidden py-5">
        <div class="container">
            <div class="row g-4">
                @foreach ($data as $akom)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.2 }}s">
                        <div class="training-item p-4">

                            {{-- FOTO --}}
                            <div class="training-img mb-4 rounded overflow-hidden">
                                <img src="{{ image_path($akom->images[0] ?? null) }}" alt="{{ $akom->nama }}"
                                    class="img-fluid w-100">
                            </div>

                            {{-- NAMA --}}
                            <h5 class="mb-3">{{ $akom->nama }}</h5>

                            {{-- TIPE & HARGA --}}
                            <p class="mb-2">
                                <i class="fa fa-home text-primary me-2"></i>
                                {{ $akom->tipe ?: 'Akomodasi' }}
                            </p>

                            @if ($akom->price_range)
                                <p class="mb-3">
                                    <i class="fa fa-tag text-primary me-2"></i>
                                    {{ $akom->price_range }}
                                </p>
                            @endif

                            {{-- LINK DETAIL --}}
                            <a class="btn btn-primary border-secondary rounded-pill py-3 px-5"
                                href="{{ route('front.akomodasi.show', $akom->slug) }}">
                                Lihat Detail
                            </a>

                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>

@endsection
