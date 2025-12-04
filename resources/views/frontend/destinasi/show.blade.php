@extends('frontend.layouts.master')

@section('title', $dest->nama)
@section('meta_description', Str::limit(strip_tags($dest->deskripsi), 160))

@section('content')

    {{-- HEADER --}}
    <div class="container-fluid page-header py-5"
        style="background: 
        linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.4)),
                 url('{{ image_path($dest->gambar[0] ?? null) }}');
                background-size: cover;
                background-position: center;">
        <div class="container text-center py-5">
            <h1 class="display-4 text-light">{{ $dest->nama }}</h1>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="container-fluid py-5">
        <div class="container">

            <div class="row g-5">

                {{-- LEFT CONTENT --}}
                <div class="col-lg-8">

                    {{-- GALLERY --}}
                    @if (count($gallery) > 0)
                        <div id="galleryCarousel" class="carousel slide mb-4" data-bs-ride="carousel">

                            <div class="carousel-inner">
                                @foreach ($gallery as $img)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ image_path($img) }}" class="d-block w-100 rounded"
                                            alt="{{ $dest->nama }}">
                                    </div>
                                @endforeach
                            </div>

                            @if (count($gallery) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif

                        </div>
                    @endif

                    {{-- DESCRIPTION --}}
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        {{-- <h3 class="mb-4">Deskripsi</h3> --}}

                        @php
                            $paragraphs = preg_split("/\r\n|\n|\r/", trim($dest->deskripsi));
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

                {{-- RIGHT SIDEBAR --}}
                <div class="col-lg-4">

                    <div class="bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.3s">

                        <h4 class="mb-3 text-primary">Informasi Detail</h4>

                        @if ($dest->lokasi)
                            <p class="mb-2">
                                <i class="fa fa-map-marker-alt me-2 text-secondary"></i>
                                {{ $dest->lokasi }}
                            </p>
                        @endif

                        @if ($dest->kategori)
                            <p class="mb-2">
                                <i class="fa fa-tag me-2 text-secondary"></i>
                                {{ $dest->kategori }}
                            </p>
                        @endif

                        {{-- MAPS --}}
                        @if ($dest->maps_url)
                            <div class="mt-3">
                                <h5 class="mb-2">Lokasi</h5>
                                <iframe src="{{ $dest->maps_url }}" width="100%" height="250" style="border:0;"
                                    allowfullscreen="" loading="lazy">
                                </iframe>
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
