@extends('admin.layouts.master')

@section('title', 'Edit Akomodasi')

@section('content')

@php $breadcrumb = 'Edit Akomodasi'; @endphp

<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">

        <h4 class="mb-4">Edit Akomodasi</h4>

        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form action="{{ route('admin.web.akomodasi.update', $akom->id) }}"
              method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">

                    <div class="mb-3">
                        <label class="form-label">Nama Akomodasi</label>
                        <input type="text" name="nama" class="form-control"
                               value="{{ old('nama', $akom->nama) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe Akomodasi</label>
                        <input type="text" name="tipe" class="form-control"
                               value="{{ old('tipe', $akom->tipe) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                               value="{{ old('alamat', $akom->alamat) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control"
                               pattern="[0-9+\-\(\) ]+"
                               value="{{ old('telepon', $akom->telepon) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kisaran Harga</label>
                        <input type="text" name="price_range" class="form-control"
                               value="{{ old('price_range', $akom->price_range) }}">
                    </div>

                    {{-- <div class="mb-3">
                        <label class="form-label">Link Google Maps (optional)</label>
                        <input type="url" name="maps_url" class="form-control"
                               value="{{ old('maps_url', $akom->maps_url) }}">
                    </div> --}}

                    <div class="mb-3">
                        <label class="form-label">Ringkasan (Excerpt)</label>
                        <textarea name="excerpt" rows="2"
                                  class="form-control">{{ old('excerpt', $akom->excerpt) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Lengkap</label>
                        <textarea name="deskripsi" rows="6"
                                  class="form-control">{{ old('deskripsi', $akom->deskripsi) }}</textarea>
                    </div>

                </div>

                <div class="col-md-4">

                    {{-- FASILITAS --}}
                    <div class="mb-3">
                        <label class="form-label">Fasilitas</label>

                        <div id="fasilitas-wrapper">
                            @php
                                $oldFasilitas = old('fasilitas');
                                $items = is_array($oldFasilitas) ? $oldFasilitas : ($akom->fasilitas ?? ['']);
                            @endphp

                            @foreach ($items as $f)
                                <div class="input-group mb-2 fasilitas-item">
                                    <input type="text" name="fasilitas[]" class="form-control"
                                           value="{{ $f }}">
                                    <button type="button" class="btn btn-danger remove-fasilitas">X</button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-fasilitas"
                                class="btn btn-secondary btn-sm mt-2">
                            + Tambah Fasilitas
                        </button>
                    </div>

                    {{-- UPLOAD GAMBAR --}}
                    <div class="mb-3">
                        <label class="form-label">Tambah Gambar Baru</label>
                        <input type="file" name="images[]" class="form-control"
                               multiple accept="image/*">
                        <small class="text-muted">Max total 5 gambar.</small>
                    </div>

                    {{-- GALERI --}}
                    @php $images = is_array($akom->images) ? $akom->images : []; @endphp

                    @if ($images)
                        <div class="mb-3">
                            <label class="form-label">Galeri Saat Ini</label>

                            <div class="row g-2">
                                @foreach ($images as $img)
                                    <div class="col-6 galeri-item">
                                        <div class="card position-relative">

                                            <img src="{{ Storage::url($img) }}"
                                                 class="card-img-top"
                                                 style="height:120px;object-fit:cover">

                                            <button type="button"
                                                class="btn btn-danger btn-sm btn-delete position-absolute top-0 end-0 m-1"
                                                data-url="{{ route('admin.web.akomodasi.hapus-gambar', $akom->id) }}"
                                                data-body='@json(["gambar" => $img])'
                                                data-remove=".galeri-item"
                                                data-msg="Hapus gambar ini?">
                                                <i class="fa fa-times"></i>
                                            </button>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- PUBLISH --}}
                    <div class="mb-3 form-check mt-3">
                        <input type="checkbox" name="is_published" value="1"
                               class="form-check-input" id="is_published"
                               {{ $akom->is_published ? 'checked' : '' }}>
                        <label for="is_published" class="form-check-label">
                            Publikasikan
                        </label>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.web.akomodasi.index') }}"
                           class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                </div>
            </div>

        </form>

    </div>
</div>

{{-- JS FASILITAS SAJA (DELETE SUDAH GLOBAL) --}}
<script>
document.addEventListener('click', e => {
    const rm = e.target.closest('.remove-fasilitas');
    if (rm) rm.closest('.fasilitas-item').remove();
});

document.getElementById('add-fasilitas').addEventListener('click', () => {
    document.getElementById('fasilitas-wrapper').insertAdjacentHTML('beforeend', `
        <div class="input-group mb-2 fasilitas-item">
            <input type="text" name="fasilitas[]" class="form-control">
            <button type="button" class="btn btn-danger remove-fasilitas">X</button>
        </div>
    `);
});

document.querySelector('form').addEventListener('submit', function(){
    this.querySelector('button[type=submit]').disabled = true;
});
</script>

@endsection
