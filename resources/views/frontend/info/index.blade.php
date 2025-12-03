@extends('frontend.layouts.master')

@section('title', $info->title ?? 'Tentang Supiori')
@section('meta_description', Str::limit(strip_tags($info->content), 160))

@section('content')

    {{-- PAGE HEADER  --}}
    <div class="container-fluid page-header py-5"
        style="background: linear-gradient(rgba(0, 58, 102, 0.3),rgba(0, 58, 102, 0.2)), 
                 url('{{ image_path($info->image ?? null) }}');
                background-size: cover;
                background-position: center;">
        <div class="container text-center py-5">
            <h1 class="display-4 text-light">{{ $info->title ?? 'Tentang Daerah' }}</h1>
            <p class="mb-0 text-light fw-semibold">{{ $info->subtitle }}</p>
        </div>
    </div>

    {{-- MAIN SECTION --}}
    <div class="container-fluid about py-5">
        <div class="container">

            <div class="row g-5 align-items-center">

                {{-- LEFT IMAGE --}}
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="rounded-3 overflow-hidden shadow-lg">
                        <img class="img-fluid w-100"
                            src="{{ $info && $info->image ? asset('storage/' . $info->image) : asset('frontend/img/default.jpg') }}"
                            alt="{{ $info->title }}">
                    </div>
                </div>

                {{-- RIGHT TEXT --}}
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    {{-- CONTENT WITH PARAGRAPH HANDLING --}}
                    @php
                        $paragraphs = preg_split("/\r\n|\n|\r/", trim($info->content));
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


                    {{-- Highlight Icons ala Travisa --}}
                    <div class="row gy-4 pt-2">

                        <div class="col-sm-6 d-flex align-items-center">
                            <i class="fa fa-map-marked-alt fa-3x text-primary"></i>
                            <h5 class="ms-3">Wilayah Kaya Alam</h5>
                        </div>

                        <div class="col-sm-6 d-flex align-items-center">
                            <i class="fa fa-water fa-3x text-primary"></i>
                            <h5 class="ms-3">Spot Diving & Snorkeling</h5>
                        </div>

                        <div class="col-sm-6 d-flex align-items-center">
                            <i class="fa fa-ship fa-3x text-primary"></i>
                            <h5 class="ms-3">Budaya & Sejarah</h5>
                        </div>

                        <div class="col-sm-6 d-flex align-items-center">
                            <i class="fa fa-users fa-3x text-primary"></i>
                            <h5 class="ms-3">Keramahan Lokal</h5>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
