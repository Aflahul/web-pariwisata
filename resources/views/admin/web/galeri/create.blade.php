@extends('admin.layouts.master')

@section('title', 'Tambah Galeri')

@section('content')

@php $breadcrumb = 'Tambah Galeri'; @endphp

<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">

        <h4 class="mb-4">Tambah Item Galeri</h4>

        {{-- ERROR --}}
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

        <form action="{{ route('admin.web.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                {{-- KOLOM KIRI --}}
                <div class="col-md-8">

                    {{-- JUDUL --}}
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
                    </div>

                    {{-- TIPE MEDIA --}}
                    <div class="mb-3">
                        <label class="form-label">Tipe Media</label>
                        <select name="tipe_media" class="form-select" id="tipe_media">
                            <option value="image" {{ old('tipe_media') == 'image' ? 'selected' : '' }}>Foto</option>
                            <option value="video" {{ old('tipe_media') == 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mb-3">
                        <label class="form-label">Deskripsi (opsional)</label>
                        <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi') }}</textarea>
                    </div>

                </div>

                {{-- KOLOM KANAN --}}
                <div class="col-md-4">

                    {{-- UPLOAD FOTO --}}
                    <div class="mb-3" id="wrap_foto">
                        <label class="form-label">Upload Foto</label>
                        <input type="file" name="file_path" class="form-control" accept="image/*">
                        <small class="text-primary">Maks 2MB. Format: JPG, PNG, WEBP.</small>
                    </div>

                    {{-- VIDEO URL --}}
                    <div class="mb-3 d-none" id="wrap_video">
                        <label class="form-label">URL Video</label>
                        <input type="url" name="video_url" 
                               class="form-control"
                               placeholder="Hanya YouTube atau Vimeo">
                        <small class="text-muted">Contoh: https://youtu.be/... atau https://vimeo.com/...</small>
                    </div>

                    {{-- PUBLISH --}}
                    <div class="form-check mb-3 mt-3">
                        <input type="checkbox" name="is_published" value="1" class="form-check-input" id="publish">
                        <label for="publish" class="form-check-label">Publikasikan</label>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.web.galeri.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </div>

            </div>

        </form>

    </div>
</div>

{{-- TOGGLE FORM FOTO/VIDEO --}}
<script>
    function toggleMediaInputs() {
        let tipe = document.getElementById('tipe_media').value;

        if (tipe === 'image') {
            document.getElementById('wrap_foto').classList.remove('d-none');
            document.getElementById('wrap_video').classList.add('d-none');
        } else {
            document.getElementById('wrap_foto').classList.add('d-none');
            document.getElementById('wrap_video').classList.remove('d-none');
        }
    }

    document.getElementById('tipe_media').addEventListener('change', toggleMediaInputs);
    toggleMediaInputs();
</script>

@endsection
