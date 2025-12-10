@extends('admin.layouts.master')
@section('title', 'Daftar Kebudayaan')

@section('content')

    @php $breadcrumb = 'Kebudayaan'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            <div class="d-flex justify-content-between mb-4">
                <h4 class="mb-0">Kebudayaan</h4>
                <a href="{{ route('admin.web.budaya.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Tambah Budaya
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $d)
                            <tr class="budaya-row">
                                <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>

                                <td class="fw-semibold">
                                    {{ $d->judul }}
                                </td>

                                <td>
                                    {{ ucfirst($d->jenis) }}
                                </td>

                                <td>
                                    {{ $d->lokasi ?? '-' }}
                                </td>

                                <td>
                                    @if ($d->status)
                                        <span class="badge bg-success">Publish</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('admin.web.budaya.edit', $d->id) }}"
                                        class="btn btn-sm btn-warning me-1">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="btn btn-sm btn-danger btn-delete"
                                        data-url="{{ route('admin.web.budaya.destroy', $d->id) }}"
                                        data-msg="Hapus data budaya '{{ $d->judul }}'?" data-remove=".budaya-row">
                                        <i class="fa fa-trash"></i>
                                    </button>
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
