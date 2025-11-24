@extends('admin.layouts.master')
@section('title', 'Daftar Destinasi')
@section('content')
    @php $breadcrumb = 'Destinasi Wisata'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex justify-content-between mb-4">
                <h4 class="mb-0">Destinasi Wisata</h4>
                <a href="{{ route('admin.web.destinasi.create') }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i>
                    Tambah Destinasi</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Unggulan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                                <td class="fw-semibold">{{ $d->nama }}</td>
                                <td>{{ $d->kategori }}</td>
                                <td>
                                    @if ($d->maps_url)
                                        <a href="{{ $d->maps_url }}" target="_blank" rel="noopener noreferrer">Lihat</a>
                                    @else
                                        {{ $d->lokasi }}
                                    @endif
                                </td>
                                <td>
                                    @if ($d->unggulan)
                                        <span class="badge bg-success">Ya</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.web.destinasi.edit', $d->id) }}"
                                        class="btn btn-sm btn-warning me-1"><i class="fa fa-edit"></i></a>

                                    <form action="{{ route('admin.web.destinasi.destroy', $d->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus destinasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection
