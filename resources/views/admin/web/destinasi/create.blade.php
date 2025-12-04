@extends('admin.layouts.master')
@section('title', 'Tambah Destinasi')
@section('content')
    @php $breadcrumb = 'Tambah Destinasi'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h4 class="mb-4">Tambah Destinasi</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.web.destinasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Nama Destinasi</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi (teks)</label>
                            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Google Maps (opsional)</label>
                            <input type="url" name="maps_url" class="form-control" value="{{ old('maps_url') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ringkasan (excerpt)</label>
                            <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" class="form-control" rows="6">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Gambar (bisa upload max 5 file)</label>
                            <input type="file" name="gambar[]" class="form-control" multiple accept="image/*">
                            <small class="text-primary">Format: jpg, png, webp. Max per file 3MB.</small>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="unggulan" value="1" class="form-check-input" id="unggulan">
                            <label for="unggulan" class="form-check-label">Tandai sebagai unggulan (untuk slider)</label>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="{{ route('admin.web.destinasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
