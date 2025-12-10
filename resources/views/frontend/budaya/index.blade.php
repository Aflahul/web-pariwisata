@extends('frontend.layouts.master')

@section('title', 'Budaya Kabupaten Supiori')
@section('meta_description', 'Kumpulan tradisi, adat, tarian, kerajinan dan warisan budaya di Kabupaten Supiori.')

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
                <h5 class="sub-title text-light px-3">Budaya Supiori</h5>
            </div>
            <h1 class="display-4 text-light">Warisan Tradisi dan Identitas Supiori</h1>
            <p class="text-light fw-semibold mb-0">
                Mengenal kekayaan budaya, adat, dan karya masyarakat Supiori.
            </p>
        </div>
    </div>

    {{-- LIST --}}
    <div class="container-fluid service overflow-hidden bg-light pt-5">
        <div class="container py-5">

            {{-- CEK DATA --}}
            @if ($data->count() == 0)
                <div class="text-center py-5">
                    <h5 class="text-muted">Belum ada data budaya tersedia.</h5>
                </div>
            @else
                <div class="row g-4 justify-content-center">

                    @foreach ($data as $b)
                        <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.2 }}s">

                            <div class="service-item">
                                <div class="service-inner">

                                    {{-- FOTO --}}
                                    <div class="service-img">
                                        <img src="{{ image_path($b->gambar) }}" class="img-fluid w-100 rounded"
                                            alt="{{ $b->judul }}">
                                    </div>

                                    {{-- TITLE --}}
                                    <div class="service-title">
                                        <div class="service-title-name">
                                            <div class="bg-primary text-center rounded p-3 mx-5 mb-4">
                                                <a href="{{ route('front.budaya.show', $b->slug) }}"
                                                    class="h4 text-white mb-0">
                                                    {{ $b->judul }}
                                                </a>
                                            </div>

                                            <a href="{{ route('front.budaya.show', $b->slug) }}"
                                                class="btn bg-light text-secondary rounded-pill py-3 px-5 mb-4">
                                                Lihat Detail
                                            </a>
                                        </div>

                                        {{-- CONTENT --}}
                                        <div class="service-content pb-4">
                                            <div class="px-4">
                                                <p class="mb-4">
                                                    {{ Str::limit(strip_tags($b->ringkasan), 120) }}
                                                </p>

                                                <a href="{{ route('front.budaya.show', $b->slug) }}"
                                                    class="btn btn-primary rounded-pill text-white py-3 px-5">
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

                {{-- PAGINATION --}}
                <div class="mt-5">
                    {{ $data->links() }}
                </div>

            @endif

        </div>
    </div>

@endsection
