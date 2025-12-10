@extends('frontend.layouts.master')

@section('title', $diving->nama)
@section('meta_description', Str::limit(strip_tags($diving->deskripsi), 160))

@section('content')

    {{-- HEADER --}}
    <div class="container-fluid page-header py-5"
        style="background: 
        linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.4)),
        url('{{ image_path($diving->gambar[0] ?? null) }}');
        background-size: cover;
        background-position: center;">
        <div class="container text-center py-5">
            <h1 class="display-4 text-light">{{ $diving->nama }}</h1>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">

            <div class="row g-5">

                {{-- MAIN CONTENT --}}
                <div class="col-lg-8">

                    {{-- GALLERY --}}
                    @if (count($gallery) > 0)
                        <div id="divingCarousel" class="carousel slide mb-4" data-bs-ride="carousel">

                            <div class="carousel-inner">
                                @foreach ($gallery as $img)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ image_path($img) }}" class="d-block w-100 rounded"
                                            alt="{{ $diving->nama }}">
                                    </div>
                                @endforeach
                            </div>

                            @if (count($gallery) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#divingCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#divingCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif

                        </div>
                    @endif

                    {{-- DESKRIPSI --}}
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        {{-- <h3 class="mb-4">Deskripsi</h3> --}}
                        @php
                            $paragraphs = preg_split("/\r\n|\n|\r/", trim($diving->deskripsi));
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

                {{-- SIDEBAR --}}
                <div class="col-lg-4">

                    <div class="bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.3s">

                        <h4 class="mb-4 text-primary">Informasi Umum</h4>

                        @if ($diving->alamat)
                            <p class="mb-2">
                                <i class="fa fa-map-marker-alt me-2 text-secondary"></i>
                                {{ $diving->alamat }}
                            </p>
                        @endif

                        @if ($diving->kontak)
                            <p class="mb-2">
                                <i class="fa fa-phone me-2 text-secondary"></i>
                                {{ $diving->kontak }}
                            </p>
                        @endif

                        @if (count($peralatan))
                            <div class="mt-3">
                                <h5>Peralatan</h5>
                                <ul class="ps-3">
                                    @foreach ($peralatan as $p)
                                        <li>{{ $p }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (count($paket))
                            <div class="mt-3">
                                <h5>Paket Layanan</h5>
                                <ul class="ps-3">
                                    @foreach ($paket as $pk)
                                        <li>{{ $pk }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($diving->alamat)
                            <div class="mt-3">
                                <h5 class="mb-2">Lokasi</h5>
                                <iframe src="https://www.google.com/maps?q={{ urlencode($diving->alamat) }}&output=embed"
                                    class="rounded" width="100%" height="250" style="border:0;" allowfullscreen
                                    loading="lazy">
                                </iframe>
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
