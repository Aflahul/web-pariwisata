@extends('frontend.layouts.master')

@section('title', $data->nama)
@section('meta_description', Str::limit(strip_tags($data->deskripsi), 160))

@section('content')

    {{-- HEADER --}}
    <div class="container-fluid page-header py-5">
        <div class="container text-center py-5">
            <h1 class="display-4 text-primary">{{ $data->nama }}</h1>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">

            <div class="row g-5">

                {{-- MAIN CONTENT --}}
                <div class="col-lg-8">

                    {{-- GALLERY --}}
                    @if (count($gallery) > 0)
                        <div id="akomCarousel" class="carousel slide mb-4" data-bs-ride="carousel">

                            <div class="carousel-inner">
                                @foreach ($gallery as $img)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ image_path($img) }}" class="d-block w-100 rounded"
                                            alt="{{ $data->nama }}">
                                    </div>
                                @endforeach
                            </div>

                            @if (count($gallery) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#akomCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#akomCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif

                        </div>
                    @endif

                    {{-- DESKRIPSI --}}
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <h3 class="mb-4">Deskripsi</h3>
                        <div class="text-dark">
                            {!! $data->deskripsi !!}
                        </div>
                    </div>

                </div>

                {{-- SIDEBAR --}}
                <div class="col-lg-4">

                    <div class="bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.3s">

                        <h4 class="mb-4 text-primary">Informasi Akomodasi</h4>

                        {{-- ALAMAT --}}
                        @if ($data->alamat)
                            <p class="mb-2">
                                <i class="fa fa-map-marker-alt me-2 text-secondary"></i>
                                {{ $data->alamat }}
                            </p>
                        @endif

                        {{-- TELEPON --}}
                        @if ($data->telepon)
                            <p class="mb-2">
                                <i class="fa fa-phone me-2 text-secondary"></i>
                                {{ $data->telepon }}
                            </p>
                        @endif

                        {{-- HARGA --}}
                        @if ($data->price_range)
                            <p class="mb-2">
                                <i class="fa fa-tag me-2 text-secondary"></i>
                                {{ $data->price_range }}
                            </p>
                        @endif

                        {{-- FASILITAS --}}
                        @if (count($fasilitas))
                            <div class="mt-3">
                                <h5>Fasilitas</h5>
                                <ul class="ps-3">
                                    @foreach ($fasilitas as $f)
                                        <li>{{ $f }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- MAPS --}}
                        @if ($data->maps_url)
                            <div class="mt-3">
                                <h5>Lokasi</h5>
                                <iframe src="{{ $data->maps_url }}" width="100%" height="250" style="border:0;"
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
