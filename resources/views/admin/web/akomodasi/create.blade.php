@extends('admin.layouts.master')

@section('title', 'Tambah Akomodasi')

@section('content')
@php $breadcrumb = 'Tambah Akomodasi'; @endphp

<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">

        <h4 class="mb-4">Tambah Akomodasi</h4>

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

        <form action="{{ route('admin.web.akomodasi.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="row">
                <div class="col-md-8">

                    <div class="mb-3">
                        <label class="form-label">Nama Akomodasi</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe Akomodasi</label>
                        <input type="text" name="tipe" class="form-control" value="{{ old('tipe') }}" placeholder="Hotel, Homestay, Guesthouse...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" pattern="[0-9+\-\(\) ]+" class="form-control"
                            value="{{ old('telepon') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kisaran Harga</label>
                        <input type="text" name="price_range" class="form-control" value="{{ old('price_range') }}" placeholder="300K - 600K / malam">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link Google Maps (optional)</label>
                        <input type="url" name="maps_url" class="form-control" value="{{ old('maps_url') }}"
                            placeholder="https://maps.app.goo.gl/...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ringkasan (Excerpt)</label>
                        <textarea name="excerpt" rows="2" class="form-control">{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Lengkap</label>
                        <textarea name="deskripsi" rows="6" class="form-control">{{ old('deskripsi') }}</textarea>
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="mb-3">
                        <label class="form-label">Fasilitas</label>

                        <div id="fasilitas-wrapper">
                            @if (is_array(old('fasilitas')))
                                @foreach (old('fasilitas') as $f)
                                    <div class="input-group mb-2 fasilitas-item">
                                        <input type="text" name="fasilitas[]" class="form-control" value="{{ $f }}">
                                        <button type="button" class="btn btn-danger remove-fasilitas">X</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 fasilitas-item">
                                    <input type="text" name="fasilitas[]" class="form-control" placeholder="Wifi, AC, Sarapan...">
                                    <button type="button" class="btn btn-danger remove-fasilitas">X</button>
                                </div>
                            @endif
                        </div>

                        <button type="button" id="add-fasilitas" class="btn btn-secondary btn-sm mt-2">+ Tambah Fasilitas</button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar (bisa upload max 5 file)</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <small class="text-primary">Max per file: 3MB | Format: jpg, png, webp</small>
                    </div>

                    <div class="mb-3 form-check mt-3">
                        <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published">
                        <label for="is_published" class="form-check-label">Publikasikan</label>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.web.akomodasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>

                </div>
            </div>

        </form>

    </div>
</div>

<script>
document.addEventListener('click', function(e){
    if (e.target.closest('.remove-fasilitas')) {
        e.preventDefault();
        e.target.closest('.fasilitas-item').remove();
    }
});

document.querySelector('#add-fasilitas').addEventListener('click', function(){
    let wrapper = document.querySelector('#fasilitas-wrapper');
    wrapper.insertAdjacentHTML('beforeend', `
        <div class="input-group mb-2 fasilitas-item">
            <input type="text" name="fasilitas[]" class="form-control" placeholder="Wifi, AC, Sarapan...">
            <button type="button" class="btn btn-danger remove-fasilitas">X</button>
        </div>
    `);
});

document.querySelector('form').addEventListener('submit', function(){
    this.querySelector('button[type=submit]').disabled = true;
});
</script>

@endsection
