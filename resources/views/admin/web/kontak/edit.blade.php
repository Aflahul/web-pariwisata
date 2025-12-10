@extends('admin.layouts.master')

@section('title', 'Kontak Resmi')

@section('content')

@php $breadcrumb = 'Kontak Resmi'; @endphp

<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">

        <h4 class="mb-4">Pengaturan Kontak Resmi</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.web.kontak.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- KOLOM KIRI --}}
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Alamat Kantor</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $kontak->alamat) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control"
                               value="{{ old('telepon', $kontak->telepon) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" name="whatsapp" class="form-control"
                               value="{{ old('whatsapp', $kontak->whatsapp) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Resmi</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $kontak->email) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam Operasional</label>
                        <input type="text" name="jam_operasional" class="form-control"
                               value="{{ old('jam_operasional', $kontak->jam_operasional) }}"
                               placeholder="Contoh: Senin - Jumat, 08.00 - 16.00">
                    </div>

                </div>

                {{-- KOLOM KANAN --}}
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Google Maps URL</label>
                        <input type="url" name="maps_url" class="form-control"
                               value="{{ old('maps_url', $kontak->maps_url) }}">
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3">Sosial Media</h6>

                    <div class="mb-3">
                        <label class="form-label">Facebook</label>
                        <input type="url" name="facebook" class="form-control"
                               value="{{ old('facebook', $kontak->facebook) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Instagram</label>
                        <input type="url" name="instagram" class="form-control"
                               value="{{ old('instagram', $kontak->instagram) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">YouTube</label>
                        <input type="url" name="youtube" class="form-control"
                               value="{{ old('youtube', $kontak->youtube) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">TikTok</label>
                        <input type="url" name="tiktok" class="form-control"
                               value="{{ old('tiktok', $kontak->tiktok) }}">
                    </div>

                </div>

            </div>

            <div class="text-end mt-4">
                <button class="btn btn-primary px-4">Simpan Perubahan</button>
            </div>

        </form>

    </div>
</div>

@endsection
