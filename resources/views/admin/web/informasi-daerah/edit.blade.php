@extends('admin.layouts.master')

@section('title', 'Informasi Daerah')

@section('content')

@php $breadcrumb = 'Informasi Daerah'; @endphp

<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">

        <h4 class="mb-4">Informasi Daerah</h4>

        {{-- ALERT SUCCESS --}}
        {{-- @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif --}}

        {{-- FORM --}}
        <form action="{{ route('admin.web.informasi-daerah.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- TITLE --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Judul</label>
                <input type="text" 
                       name="title" 
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $info->title) }}"
                       placeholder="Contoh: Ada apa dengan Supiori?">

                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- SUBTITLE --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Sub Judul</label>
                <input type="text" 
                       name="subtitle" 
                       class="form-control @error('subtitle') is-invalid @enderror"
                       value="{{ old('subtitle', $info->subtitle) }}"
                       placeholder="Opsional">

                @error('subtitle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- CONTENT --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="content" 
                          rows="6"
                          class="form-control @error('content') is-invalid @enderror"
                          placeholder="Tuliskan deskripsi informasi daerah...">{{ old('content', $info->content) }}</textarea>

                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- IMAGE --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Gambar Utama</label>
                <input type="file" 
                       name="image" 
                       class="form-control @error('image') is-invalid @enderror"
                       accept="image/*">

                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($info->image)
                    <div class="mt-3">
                        <p class="fw-bold">Preview Saat Ini:</p>
                        <img src="{{ asset('storage/' . $info->image) }}" 
                             alt="Gambar Informasi"
                             class="img-fluid rounded"
                             style="max-height: 250px;">
                    </div>
                @endif
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fa fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
