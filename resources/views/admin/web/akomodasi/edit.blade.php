@extends('admin.layouts.master')

@section('title', 'Edit Akomodasi')

@section('content')

    @php $breadcrumb = 'Edit Akomodasi'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            <h4 class="mb-4">Edit Akomodasi</h4>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi Kesalahan:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.web.akomodasi.update', $akom->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- KOLOM KIRI --}}
                    <div class="col-md-8">

                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Akomodasi</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $akom->nama) }}"
                                required>
                        </div>

                        {{-- TIPE --}}
                        <div class="mb-3">
                            <label class="form-label">Tipe Akomodasi</label>
                            <input type="text" name="tipe" class="form-control"
                                value="{{ old('tipe', $akom->tipe) }}">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control"
                                value="{{ old('alamat', $akom->alamat) }}">
                        </div>

                        {{-- TELEPON --}}
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control"
                                value="{{ old('telepon', $akom->telepon) }}">
                        </div>

                        {{-- PRICE RANGE --}}
                        <div class="mb-3">
                            <label class="form-label">Kisaran Harga</label>
                            <input type="text" name="price_range" class="form-control"
                                value="{{ old('price_range', $akom->price_range) }}">
                        </div>

                        {{-- MAPS URL --}}
                        <div class="mb-3">
                            <label class="form-label">Link Google Maps (optional)</label>
                            <input type="url" name="maps_url" class="form-control"
                                value="{{ old('maps_url', $akom->maps_url) }}">
                        </div>

                        {{-- EXCERPT --}}
                        <div class="mb-3">
                            <label class="form-label">Ringkasan (Excerpt)</label>
                            <textarea name="excerpt" rows="2" class="form-control">{{ old('excerpt', $akom->excerpt) }}</textarea>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" rows="6" class="form-control">{{ old('deskripsi', $akom->deskripsi) }}</textarea>
                        </div>

                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="col-md-4">

                        {{-- FASILITAS --}}
                        <div class="mb-3">
                            <label class="form-label">Fasilitas</label>

                            <div id="fasilitas-wrapper">
                                @if (old('fasilitas'))
                                    @foreach (old('fasilitas') as $f)
                                        <div class="input-group mb-2 fasilitas-item">
                                            <input type="text" name="fasilitas[]" class="form-control"
                                                value="{{ $f }}">
                                            <button type="button" class="btn btn-danger remove-fasilitas">X</button>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($akom->fasilitas ?? [''] as $f)
                                        <div class="input-group mb-2 fasilitas-item">
                                            <input type="text" name="fasilitas[]" class="form-control"
                                                value="{{ $f }}">
                                            <button type="button" class="btn btn-danger remove-fasilitas">X</button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <button type="button" id="add-fasilitas" class="btn btn-secondary btn-sm mt-2">
                                + Tambah Fasilitas
                            </button>
                        </div>


                        {{-- GAMBAR BARU --}}
                        <div class="mb-3">
                            <label class="form-label">Tambah Gambar Baru</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted">Gambar baru akan ditambahkan ke galeri.</small>
                        </div>

                        {{-- GALERI GAMBAR --}}
                        @if (!empty($akom->images) && is_array($akom->images))
                            <div class="mb-3">
                                <label class="form-label">Galeri Saat Ini</label>

                                <div class="row g-2">
                                    @foreach ($akom->images as $img)
                                        <div class="col-6">
                                            <div class="card position-relative">

                                                <img src="{{ Storage::url($img) }}" class="card-img-top"
                                                    style="height:120px;object-fit:cover;">


                                                {{-- Hapus 1 gambar --}}
                                                <form action="{{ route('admin.web.akomodasi.hapus-gambar', $akom->id) }}"
                                                    method="POST" class="position-absolute top-0 end-0 m-1">
                                                    @csrf
                                                    @method('DELETE')

                                                    <input type="hidden" name="gambar" value="{{ $img }}">

                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus gambar ini?')"
                                                        aria-label="Hapus gambar">
                                                        <i class="fa fa-times"></i>
                                                    </button>

                                                </form>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        @endif

                        {{-- PUBLISHED --}}
                        <div class="mb-3 form-check mt-3">
                            <input type="checkbox" name="is_published" value="1" class="form-check-input"
                                id="is_published" {{ $akom->is_published ? 'checked' : '' }}>
                            <label for="is_published" class="form-check-label">Publikasikan</label>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.web.akomodasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

    {{-- SCRIPT FASILITAS --}}
    <script>
        document.getElementById('add-fasilitas').addEventListener('click', function() {
            let wrapper = document.getElementById('fasilitas-wrapper');

            let html = `
        <div class="input-group mb-2 fasilitas-item">
            <input type="text" name="fasilitas[]" class="form-control" placeholder="Wifi, AC, Sarapan...">
            <button type="button" class="btn btn-danger remove-fasilitas">X</button>
        </div>
    `;

            wrapper.insertAdjacentHTML('beforeend', html);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-fasilitas')) {
                e.target.closest('.fasilitas-item').remove();
            }
        });
    </script>

@endsection
