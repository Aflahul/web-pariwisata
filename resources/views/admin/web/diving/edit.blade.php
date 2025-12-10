@extends('admin.layouts.master')

@section('title', 'Edit Penyedia Menyelam')

@section('content')

@php $breadcrumb = 'Edit Penyedia Menyelam'; @endphp

<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">

        <h4 class="mb-4">Edit Penyedia Jasa Menyelam</h4>

        {{-- ERROR --}}
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form action="{{ route('admin.web.diving.update', $d->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- KOLOM KIRI --}}
                <div class="col-md-8">

                    <div class="mb-3">
                        <label class="form-label">Nama Penyedia</label>
                        <input type="text" name="nama" class="form-control"
                            value="{{ old('nama', $d->nama) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kontak</label>
                        <input type="text" name="kontak" class="form-control"
                            value="{{ old('kontak', $d->kontak) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                            value="{{ old('alamat', $d->alamat) }}">
                    </div>

                    {{-- <div class="mb-3">
                        <label class="form-label">Link Google Maps</label>
                        <input type="url" name="maps_url" class="form-control"
                            value="{{ old('maps_url', $d->maps_url) }}">
                    </div> --}}

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Lengkap</label>
                        <textarea name="deskripsi" class="form-control" rows="6">{{ old('deskripsi', $d->deskripsi) }}</textarea>
                    </div>

                </div>

                {{-- KOLOM KANAN --}}
                <div class="col-md-4">

                    {{-- PERALATAN --}}
                    <div class="mb-3">
                        <label class="form-label">Fasilitas</label>

                        <div id="peralatan-wrapper">
                            @foreach ($d->peralatan ?? [''] as $p)
                                <div class="input-group mb-2 peralatan-item">
                                    <input type="text" name="peralatan[]" class="form-control"
                                           value="{{ $p }}">
                                    <button type="button" class="btn btn-danger remove-peralatan">X</button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-peralatan"
                                class="btn btn-secondary btn-sm mt-2">
                            + Tambah Fasilitas
                        </button>
                    </div>

                    {{-- PAKET --}}
                    <div class="mb-3">
                        <label class="form-label">Paket Wisata</label>

                        <div id="paket-wrapper">
                            @foreach ($d->paket ?? [''] as $p)
                                <div class="input-group mb-2 paket-item">
                                    <input type="text" name="paket[]" class="form-control"
                                           value="{{ $p }}">
                                    <button type="button" class="btn btn-danger remove-paket">X</button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-paket"
                                class="btn btn-secondary btn-sm mt-2">
                            + Tambah Paket
                        </button>
                    </div>

                    {{-- UPLOAD GAMBAR --}}
                    <div class="mb-3">
                        <label class="form-label">Tambah Gambar Baru</label>
                        <input type="file" name="gambar[]" class="form-control"
                               multiple accept="image/*">
                        <small class="text-muted">Gambar baru akan ditambahkan ke galeri.</small>
                    </div>

                    {{-- GALERI --}}
                    @if (!empty($d->gambar))
                        <div class="mb-3">
                            <label class="form-label">Galeri Saat Ini</label>

                            <div class="row g-2">
                                @foreach ($d->gambar as $img)
                                    <div class="col-6">
                                        <div class="card position-relative">

                                            <img src="{{ Storage::url($img) }}" class="card-img-top"
                                                 style="height:120px;object-fit:cover;">

                                            {{-- HAPUS GAMBAR (pakai delete global) --}}
                                            <button type="button"
                                                    class="btn btn-danger btn-sm delete-img position-absolute top-0 end-0 m-1 
                                                           btn-delete"
                                                    data-url="{{ route('admin.web.diving.hapus-gambar', $d->id) }}"
                                                    data-body='@json(["gambar" => $img])'
                                                    data-msg="Hapus gambar ini?"
                                                    data-remove=".col-6">
                                                <i class="fa fa-times"></i>
                                            </button>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- PUBLISH --}}
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_published" value="1"
                               class="form-check-input" id="publish"
                               {{ $d->is_published ? 'checked' : '' }}>
                        <label class="form-check-label" for="publish">
                            Publikasikan
                        </label>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.web.diving.index') }}" class="btn btn-secondary me-2">
                            Batal
                        </a>
                        <button class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                </div>

            </div>

        </form>

    </div>
</div>

{{-- SCRIPT --}}
<script>
    // Tambah Peralatan
    document.getElementById('add-peralatan').addEventListener('click', () => {
        document.getElementById('peralatan-wrapper').insertAdjacentHTML('beforeend', `
            <div class="input-group mb-2 peralatan-item">
                <input type="text" name="peralatan[]" class="form-control">
                <button type="button" class="btn btn-danger remove-peralatan">X</button>
            </div>
        `);
    });

    // Tambah Paket
    document.getElementById('add-paket').addEventListener('click', () => {
        document.getElementById('paket-wrapper').insertAdjacentHTML('beforeend', `
            <div class="input-group mb-2 paket-item">
                <input type="text" name="paket[]" class="form-control">
                <button type="button" class="btn btn-danger remove-paket">X</button>
            </div>
        `);
    });

    // Remove item (delegation)
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-peralatan')) {
            e.target.closest('.peralatan-item').remove();
        }
        if (e.target.classList.contains('remove-paket')) {
            e.target.closest('.paket-item').remove();
        }
    });
</script>

@endsection
