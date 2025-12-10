@extends('admin.layouts.master')

@section('title', 'Tambah Penyedia Menyelam')

@section('content')

    @php $breadcrumb = 'Tambah Penyedia Menyelam'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            <h4 class="mb-4">Tambah Penyedia Jasa Menyelam</h4>

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

            <form action="{{ route('admin.web.diving.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- KOLOM KIRI --}}
                    <div class="col-md-8">

                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Penyedia</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        {{-- KONTAK --}}
                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control" value="{{ old('kontak') }}">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                        </div>

                        {{-- GOOGLE MAPS --}}
                        {{-- <div class="mb-3">
                            <label class="form-label">Link Google Maps (opsional)</label>
                            <input type="url" name="maps_url" class="form-control"
                                placeholder="https://maps.app.goo.gl/..." value="{{ old('maps_url') }}">
                        </div> --}}

                        {{-- DESKRIPSI --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" rows="6" class="form-control">{{ old('deskripsi') }}</textarea>
                        </div>

                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="col-md-4">

                        {{-- PERALATAN --}}
                        <div class="mb-3">
                            <label class="form-label">Fasilitas</label>

                            <div id="peralatan-wrapper">
                                <div class="input-group mb-2 peralatan-item">
                                    <input type="text" name="peralatan[]" class="form-control"
                                        placeholder="Masker, Fins, Snorkel...">
                                    <button type="button" class="btn btn-danger remove-peralatan">X</button>
                                </div>
                            </div>

                            <button type="button" id="add-peralatan" class="btn btn-secondary btn-sm mt-2">
                                + Tambah Fasilitas
                            </button>
                        </div>

                        {{-- PAKET DIVE --}}
                        <div class="mb-3">
                            <label class="form-label">Paket Wisata</label>

                            <div id="paket-wrapper">
                                <div class="input-group mb-2 paket-item">
                                    <input type="text" name="paket[]" class="form-control"
                                        placeholder="Paket Intro Dive Rp...">
                                    <button type="button" class="btn btn-danger remove-paket">X</button>
                                </div>
                            </div>

                            <button type="button" id="add-paket" class="btn btn-secondary btn-sm mt-2">
                                + Tambah Paket
                            </button>
                        </div>

                        {{-- GAMBAR --}}
                        <div class="mb-3">
                            <label class="form-label">Gambar ()bisa upload max 5 file)</label>
                            <input type="file" name="gambar[]" class="form-control" multiple accept="image/*">
                            <small class=" text-primary">Max 3MB per file | Format: JPG, PNG, WEBP</small>
                        </div>

                        {{-- PUBLISH --}}
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_published" value="1" class="form-check-input"
                                id="publish">
                            <label for="publish" class="form-check-label">Publikasikan</label>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.web.diving.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button class="btn btn-primary">Simpan</button>
                        </div>

                    </div>

                </div>

            </form>
        </div>
    </div>

    {{-- SCRIPT DINAMIS --}}
    <script>
        document.getElementById('add-peralatan').addEventListener('click', function() {
            let wrapper = document.getElementById('peralatan-wrapper');
            let html = `
        <div class="input-group mb-2 peralatan-item">
            <input type="text" name="peralatan[]" class="form-control" placeholder="Masker, Fins, Snorkel...">
            <button type="button" class="btn btn-danger remove-peralatan">X</button>
        </div>`;
            wrapper.insertAdjacentHTML('beforeend', html);
        });

        document.getElementById('add-paket').addEventListener('click', function() {
            let wrapper = document.getElementById('paket-wrapper');
            let html = `
        <div class="input-group mb-2 paket-item">
            <input type="text" name="paket[]" class="form-control" placeholder="Paket Dive Rp...">
            <button type="button" class="btn btn-danger remove-paket">X</button>
        </div>`;
            wrapper.insertAdjacentHTML('beforeend', html);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-peralatan')) {
                e.target.closest('.peralatan-item').remove();
            }
            if (e.target.classList.contains('remove-paket')) {
                e.target.closest('.paket-item').remove();
            }
        });
    </script>

@endsection
