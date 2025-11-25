@extends('admin.layouts.master')

@section('title', 'Tambah Akomodasi')

@section('content')

    @php $breadcrumb = 'Tambah Akomodasi'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            <h4 class="mb-4">Tambah Akomodasi</h4>

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

            <form action="{{ route('admin.web.akomodasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- KOLOM KIRI --}}
                    <div class="col-md-8">

                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Akomodasi</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        {{-- TIPE --}}
                        <div class="mb-3">
                            <label class="form-label">Tipe Akomodasi</label>
                            <input type="text" name="tipe" class="form-control" value="{{ old('tipe') }}"
                                placeholder="Hotel, Homestay, Guesthouse...">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                        </div>

                        {{-- TELEPON --}}
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" pattern="[0-9+\-() ]+" class="form-control"
                                value="{{ old('telepon') }}">
                        </div>

                        {{-- PRICE RANGE --}}
                        <div class="mb-3">
                            <label class="form-label">Kisaran Harga</label>
                            <input type="text" name="price_range" class="form-control" value="{{ old('price_range') }}"
                                placeholder="Contoh: 300K - 600K / malam">
                        </div>

                        {{-- MAPS URL --}}
                        <div class="mb-3">
                            <label class="form-label">Link Google Maps (optional)</label>
                            <input type="url" name="maps_url" class="form-control" value="{{ old('maps_url') }}"
                                placeholder="https://maps.app.goo.gl/...">
                        </div>

                        {{-- EXCERPT --}}
                        <div class="mb-3">
                            <label class="form-label">Ringkasan (Excerpt)</label>
                            <textarea name="excerpt" rows="2" class="form-control">{{ old('excerpt') }}</textarea>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" rows="6" class="form-control">{{ old('deskripsi') }}</textarea>
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
                                    <div class="input-group mb-2 fasilitas-item">
                                        <input type="text" name="fasilitas[]" class="form-control"
                                            placeholder="Wifi, AC, Sarapan...">
                                        <button type="button" class="btn btn-danger remove-fasilitas">X</button>
                                    </div>
                                @endif
                            </div>

                            <button type="button" id="add-fasilitas" class="btn btn-secondary btn-sm mt-2">
                                + Tambah Fasilitas
                            </button>
                        </div>

                        {{-- GAMBAR --}}
                        <div class="mb-3">
                            <label class="form-label">Gambar (bisa upload banyak)</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted">Max per file: 2MB | Format: jpg, png, webp</small>
                        </div>

                        {{-- PUBLISHED --}}
                        <div class="mb-3 form-check mt-3">
                            <input type="checkbox" name="is_published" value="1" class="form-check-input"
                                id="is_published">
                            <label for="is_published" class="form-check-label">Publikasikan</label>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.web.akomodasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button class="btn btn-primary">Simpan</button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

    {{-- SCRIPT DINAMIS TOMBOL TAMBAH FASILITAS --}}
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

        // Hapus fasilitas
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-fasilitas')) {
                e.preventDefault();
                e.target.closest('.fasilitas-item').remove();
            }

        });
    </script>

@endsection
