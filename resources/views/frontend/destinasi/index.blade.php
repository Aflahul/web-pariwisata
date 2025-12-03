@extends('frontend.layouts.master')

@section('title', 'Destinasi Wisata Supiori')
@section('meta_description', 'Daftar lengkap destinasi wisata di Kabupaten Supiori.')

@section('content')
    <div class="container-fluid page-header py-5"
        style="background: linear-gradient(rgba(0, 58, 102, 0.3),rgba(0, 58, 102, 0.2)), 
                 url('{{ image_path($fp->hero_image ?? null) }}');
                background-size: cover;
                background-position: center;">
        <div class="section-title text-center z-50 wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 70px;">
            <div class="sub-style pt-4">
                <h5 class="sub-title text-light px-3 ">Destinasi Wisata</h5>
            </div>
            <h1 class="display-4 text-light">Temukan Keindahan Wisata Supiori</h1>
            <p class="mb-0 text-light fw-semibold">Jelajahi destinasi alam dan budaya terbaik di Kabupaten Supiori.</p>
        </div>
    </div>
    <div class="container-fluid service overflow-hidden pt-5">
        <div class="container py-5">
            {{-- GRID DESTINASI --}}
            <div class="row g-4">

                @foreach ($data as $dest)
                    <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.2 }}s">

                        <div class="service-item">
                            <div class="service-inner">

                                {{-- FOTO DESTINASI --}}
                                <div class="service-img">
                                    <img src="{{ image_path($dest->gambar[0] ?? null) }}" class="img-fluid w-100 rounded"
                                        alt="{{ $dest->nama }}">
                                </div>

                                {{-- TITLE --}}
                                <div class="service-title">
                                    <div class="service-title-name">
                                        <div class="bg-primary text-center rounded p-3 mx-5 mb-4">
                                            <a href="{{ route('front.destinasi.show', $dest->slug) }}"
                                                class="h4 text-white mb-0">
                                                {{ $dest->nama }}
                                            </a>
                                        </div>

                                        <a class="btn bg-light text-secondary rounded-pill py-3 px-5 mb-4"
                                            href="{{ route('front.destinasi.show', $dest->slug) }}">
                                            Lihat Detail
                                        </a>
                                    </div>

                                    {{-- CONTENT --}}
                                    <div class="service-content pb-4">
                                        <a href="{{ route('front.destinasi.show', $dest->slug) }}">
                                            <h4 class="text-white mb-4 py-3">{{ $dest->nama }}</h4>
                                        </a>

                                        <div class="px-4">
                                            <p class="mb-4">
                                                {{ $dest->excerpt ?? Str::limit(strip_tags($dest->deskripsi), 120) }}
                                            </p>
                                            <a class="btn btn-primary border-secondary rounded-pill text-white py-3 px-5"
                                                href="{{ route('front.destinasi.show', $dest->slug) }}">
                                                Lihat Detail
                                            </a>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                @endforeach

            </div>

        </div>
    </div>

@endsection
