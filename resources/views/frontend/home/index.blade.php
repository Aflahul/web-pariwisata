@extends('frontend.layouts.master')

@section('title', 'Beranda - Pariwisata Supiori')
@section('meta_description', 'Informasi lengkap destinasi wisata, akomodasi, diving, dan galeri Kabupaten Supiori.')

@section('content')

    {{-- HERO SECTION --}}
    @include('frontend.home.hero')

    {{-- ABOUT / INFORMASI DAERAH --}}
    @include('frontend.home.about')

    {{-- PANDUAN WISATA (KENAPA HARUS SUPIORI?) --}}
    @include('frontend.home.panduan')
    
    {{-- DESTINASI WISATA --}}
    @include('frontend.home.destinasi')

    {{-- AKOMODASI REKOMENDASI --}}
    @include('frontend.home.akomodasi')
    {{-- PENYEDIA JASA --}}
    @include('frontend.home.diving')
    {{-- GALERI --}}
    {{-- @include('frontend.home.galeri') --}}


@endsection
