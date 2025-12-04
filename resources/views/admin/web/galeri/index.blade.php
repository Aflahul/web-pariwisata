@extends('admin.layouts.master')

@section('title', 'Galeri Daerah')

@section('content')

    @php $breadcrumb = 'Galeri Daerah'; @endphp

    <div class="container-fluid pt-4 px-4">

        <div class="bg-light rounded p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Galeri Daerah</h4>
                <a href="{{ route('admin.web.galeri.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Tambah Galeri
                </a>
            </div>

            {{-- @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif --}}

            @if ($data->count() == 0)
                <div class="text-center py-5">
                    <h5 class="text-muted">Belum ada item galeri</h5>
                </div>
            @else
                <div class="row g-3">

                    @foreach ($data as $item)
                        <div class="col-md-3 col-sm-6">

                            <div class="card shadow-sm h-100">

                                {{-- THUMBNAIL --}}
                                @if ($item->tipe_media === 'image' && $item->file_path)
                                    <img src="{{ asset('storage/' . $item->file_path) }}" class="card-img-top w-100"
                                        style="height:180px;object-fit:cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-dark text-white"
                                        style="height:180px;">
                                        <i class="fa fa-play-circle fa-3x"></i>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <h6 class="fw-semibold mb-1">{{ $item->judul ?? '(Tanpa Judul)' }}</h6>

                                    <small class="text-muted mb-2 d-block">
                                        {{ $item->tipe_media === 'image' ? 'Foto' : 'Video' }}
                                    </small>

                                    @if ($item->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </div>

                                <div class="card-footer bg-white d-flex justify-content-between">

                                    <a href="{{ route('admin.web.galeri.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning px-3">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="btn btn-sm btn-danger px-3 btn-delete"
                                        data-url="{{ route('admin.web.galeri.destroy', $item->id) }}"
                                        data-msg="Hapus item galeri ini?" data-remove=".col-md-3">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

                <div class="mt-4">
                    {{ $data->links() }}
                </div>

            @endif

        </div>

    </div>

@endsection
