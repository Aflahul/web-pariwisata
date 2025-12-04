@extends('admin.layouts.master')

@section('title', 'Edit Galeri')

@section('content')

    @php $breadcrumb = 'Edit Galeri'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            <h4 class="mb-4">Edit Item Galeri</h4>

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

            <form action="{{ route('admin.web.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- LEFT --}}
                    <div class="col-md-8">

                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control"
                                value="{{ old('judul', $galeri->judul) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe Media</label>
                            <select name="tipe_media" class="form-select" id="tipe_media">
                                <option value="image" {{ $galeri->tipe_media === 'image' ? 'selected' : '' }}>Foto</option>
                                <option value="video" {{ $galeri->tipe_media === 'video' ? 'selected' : '' }}>Video
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi (opsional)</label>
                            <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-md-4">

                        {{-- IMAGE MODE --}}
                        <div id="wrap_foto" class="{{ $galeri->tipe_media === 'image' ? '' : 'd-none' }}">

                            <label class="form-label">Foto Saat Ini</label>

                            @if ($galeri->file_path)
                                <div class="card mb-2">
                                    <img src="{{ asset('storage/' . $galeri->file_path) }}" class="card-img-top"
                                        style="height:160px;object-fit:cover;">
                                </div>

                                {{-- delete foto pakai modal global --}}
                                <button type="button" class="btn btn-sm btn-danger mb-3 btn-delete"
                                    data-url="{{ route('admin.web.galeri.hapus-file', $galeri->id) }}"
                                    data-msg="Hapus foto ini?" data-remove=".card">
                                    <i class="fa fa-times me-1"></i> Hapus Foto
                                </button>
                            @else
                                <p class="text-muted mb-3">Belum ada foto.</p>
                            @endif

                            <label class="form-label">Upload Foto Baru</label>
                            <input type="file" name="file_path" class="form-control" accept="image/*">
                            <small class="text-muted">Max 2MB • JPG, PNG, WEBP</small>

                        </div>

                        {{-- VIDEO MODE --}}
                        <div id="wrap_video" class="{{ $galeri->tipe_media === 'video' ? '' : 'd-none' }}">

                            <label class="form-label">URL Video</label>
                            <input type="url" name="video_url" value="{{ old('video_url', $galeri->video_url) }}"
                                class="form-control" placeholder="https://youtu.be/...">
                            <small class="text-muted">
                                Hanya YouTube atau Vimeo
                            </small>

                        </div>

                        <div class="form-check mt-3">
                            <input type="checkbox" name="is_published" value="1" class="form-check-input"
                                id="publish" {{ $galeri->is_published ? 'checked' : '' }}>
                            <label for="publish" class="form-check-label">Publikasikan</label>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.web.galeri.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>

    <script>
        function toggleMediaInputs() {
            let tipe = document.getElementById('tipe_media').value;

            document.getElementById('wrap_foto').classList.toggle('d-none', tipe !== 'image');
            document.getElementById('wrap_video').classList.toggle('d-none', tipe !== 'video');
        }

        document.getElementById('tipe_media').addEventListener('change', toggleMediaInputs);
        toggleMediaInputs();
    </script>

@endsection
