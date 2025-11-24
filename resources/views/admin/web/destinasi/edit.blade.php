@extends('admin.layouts.master')
@section('title', 'Edit Destinasi')
@section('content')
    @php $breadcrumb = 'Edit Destinasi'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h4 class="mb-4">Edit Destinasi</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.web.destinasi.update', $dest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Nama Destinasi</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $dest->nama) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control"
                                value="{{ old('kategori', $dest->kategori) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi (teks)</label>
                            <input type="text" name="lokasi" class="form-control"
                                value="{{ old('lokasi', $dest->lokasi) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Google Maps (opsional)</label>
                            <input type="url" name="maps_url" class="form-control"
                                value="{{ old('maps_url', $dest->maps_url) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ringkasan (excerpt)</label>
                            <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $dest->excerpt) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" class="form-control" rows="6">{{ old('deskripsi', $dest->deskripsi) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tambah Gambar (multiple)</label>
                            <input type="file" name="gambar[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted">Gambar baru akan ditambahkan ke galeri destinasi.</small>
                        </div>

                        @if (!empty($dest->gambar) && is_array($dest->gambar))
                            <div class="mb-3">
                                <label class="form-label">Galeri Saat Ini</label>
                                <div class="row g-2">
                                    @foreach ($dest->gambar as $img)
                                        <div class="col-6">
                                            <div class="card position-relative">

                                                <img src="{{ Storage::url($img) }}" class="card-img-top"
                                                    style="height:120px;object-fit:cover;" loading="lazy"
                                                    alt="Gambar destinasi">
                                                <form action="{{ route('admin.web.destinasi.hapus-gambar', $dest->id) }}"
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

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="unggulan" value="1" class="form-check-input" id="unggulan"
                                {{ $dest->unggulan ? 'checked' : '' }}>
                            <label for="unggulan" class="form-check-label">Tandai sebagai unggulan</label>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="{{ route('admin.web.destinasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
