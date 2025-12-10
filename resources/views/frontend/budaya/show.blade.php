@extends('frontend.layouts.master')

@section('title', $budaya->judul)
@section('meta_description', Str::limit(strip_tags($budaya->deskripsi), 160))

@section('content')

    {{-- HEADER --}}
    <div class="container-fluid page-header py-5"
        style="background: 
            linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.4)),
            url('{{ image_path($budaya->gambar) }}');
            background-size: cover;
            background-position: center;">
        <div class="container text-center py-5">
            <h1 class="display-4 text-light">{{ $budaya->judul }}</h1>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="container-fluid py-5">
        <div class="container">

            <div class="row g-5">

                {{-- LEFT CONTENT --}}
                <div class="col-lg-8">

                    {{-- MAIN IMAGE --}}
                    <div class="mb-4">
                        <img src="{{ image_path($budaya->gambar) }}" class="img-fluid rounded w-100"
                            alt="{{ $budaya->judul }}">
                    </div>
                </div>

                {{-- RIGHT SIDEBAR --}}
                <div class="col-lg-4">

                    <div class="bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.3s">

                        <h4 class="mb-3 text-primary">Informasi Budaya</h4>

                        {{-- JENIS --}}
                        <p class="mb-2 d-flex align-items-start">
                            <i class="fa fa-folder me-2 text-secondary"></i>
                            <span class="text-capitalize">{{ $budaya->jenis }}</span>
                        </p>

                        {{-- LOKASI --}}
                        @if ($budaya->lokasi)
                            <p class="mb-2 d-flex align-items-start">
                                <i class="fa fa-map-marker-alt me-2 text-secondary"></i>
                                <span>{{ $budaya->lokasi }}</span>
                            </p>
                        @endif

                        {{-- MAPS --}}
                        @if ($budaya->lokasi)
                            <div class="mt-3">
                                <h5 class="mb-2">Lokasi</h5>

                                <iframe src="https://www.google.com/maps?q={{ urlencode($budaya->lokasi) }}&output=embed"
                                    class="rounded" width="100%" height="250" style="border:0;" allowfullscreen
                                    loading="lazy">
                                </iframe>
                            </div>
                        @endif
                        {{-- DESCRIPTION --}}
                        <div class="wow fadeInUp" data-wow-delay="0.2s">

                            @php
                                $paragraphs = preg_split("/\r\n|\n|\r/", trim($budaya->deskripsi));
                            @endphp

                            <div class="text-dark content-format">
                                @foreach ($paragraphs as $p)
                                    @if (trim($p) !== '')
                                        <p>{{ $p }}</p>
                                    @else
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
