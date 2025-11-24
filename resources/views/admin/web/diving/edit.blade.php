@extends('admin.layouts.master')

@section('title', 'Edit Penyedia Menyelam')

@section('content')

    @php $breadcrumb = 'Edit Penyedia Menyelam'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            <h4 class="mb-4">Edit Penyedia Jasa Menyelam</h4>

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

            <form action="{{ route('admin.web.diving.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- KOLOM KIRI --}}
                    <div class="col-md-8">

                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Penyedia</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $d->nama) }}"
                                required>
                        </div>

                        {{-- KONTAK --}}
                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control"
                                value="{{ old('kontak', $d->kontak) }}">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control"
                                value="{{ old('alamat', $d->alamat) }}">
                        </div>

                        {{-- GOOGLE MAPS --}}
                        <div class="mb-3">
                            <label class="form-label">Link Google Maps</label>
                            <input type="url" name="maps_url" class="form-control"
                                value="{{ old('maps_url', $d->maps_url) }}">
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" class="form-control" rows="6">{{ old('deskripsi', $d->deskripsi) }}</textarea>
                        </div>

                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="col-md-4">

                        {{-- PERALATAN --}}
                        <div class="mb-3">
                            <label class="form-label">Peralatan Tersedia</label>

                            <div id="peralatan-wrapper">
                                @foreach ($d->peralatan ?? [''] as $p)
                                    <div class="input-group mb-2 peralatan-item">
                                        <input type="text" name="peralatan[]" class="form-control"
                                            value="{{ $p }}">
                                        <button type="button" class="btn btn-danger remove-peralatan">X</button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-peralatan" class="btn btn-secondary btn-sm mt-2">
                                + Tambah Peralatan
                            </button>
                        </div>

                        {{-- PAKET --}}
                        <div class="mb-3">
                            <label class="form-label">Paket Diving</label>

                            <div id="paket-wrapper">
                                @foreach ($d->paket ?? [''] as $p)
                                    <div class="input-group mb-2 paket-item">
                                        <input type="text" name="paket[]" class="form-control"
                                            value="{{ $p }}">
                                        <button type="button" class="btn btn-danger remove-paket">X</button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-paket" class="btn btn-secondary btn-sm mt-2">
                                + Tambah Paket
                            </button>
                        </div>

                        {{-- UPLOAD GAMBAR BARU --}}
                        <div class="mb-3">
                            <label class="form-label">Tambah Gambar Baru</label>
                            <input type="file" name="gambar[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted">Gambar baru akan ditambahkan ke galeri.</small>
                        </div>

                        {{-- GALERI LAMA --}}
                        @if (!empty($d->gambar) && is_array($d->gambar))
                            <div class="mb-3">
                                <label class="form-label">Galeri Saat Ini</label>

                                <div class="row g-2">
                                    @foreach ($d->gambar as $img)
                                        <div class="col-6">
                                            <div class="card position-relative">

                                                <img src="{{ asset('storage/' . $img) }}" class="card-img-top"
                                                    style="height: 120px; object-fit: cover;">

                                                {{-- HAPUS SATU GAMBAR --}}
                                                <form action="{{ route('admin.web.diving.hapus-gambar', $d->id) }}"
                                                    method="POST" class="position-absolute top-0 end-0 m-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="gambar" value="{{ $img }}">

                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus gambar ini?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- PUBLISH --}}
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_published" value="1" class="form-check-input"
                                id="publish" {{ $d->is_published ? 'checked' : '' }}>
                            <label for="publish" class="form-check-label">Publikasikan</label>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.web.diving.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button class="btn btn-primary">Simpan Perubahan</button>
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
            wrapper.insertAdjacentHTML('beforeend', `
        <div class="input-group mb-2 peralatan-item">
            <input type="text" name="peralatan[]" class="form-control" placeholder="Masker, fins, BCD...">
            <button type="button" class="btn btn-danger remove-peralatan">X</button>
        </div>
    `);
        });

        document.getElementById('add-paket').addEventListener('click', function() {
            let wrapper = document.getElementById('paket-wrapper');
            wrapper.insertAdjacentHTML('beforeend', `
        <div class="input-group mb-2 paket-item">
            <input type="text" name="paket[]" class="form-control" placeholder="Paket Dive Rp...">
            <button type="button" class="btn btn-danger remove-paket">X</button>
        </div>
    `);
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
