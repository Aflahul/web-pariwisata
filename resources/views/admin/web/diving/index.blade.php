@extends('admin.layouts.master')

@section('title', 'Penyedia Jasa Menyelam')

@section('content')

@php $breadcrumb = 'Penyedia Jasa Menyelam'; @endphp

<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Penyedia Jasa Menyelam</h4>
            <a href="{{ route('admin.web.diving.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Tambah Penyedia
            </a>
        </div>

        {{-- Success Alert --}}
        {{-- @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif --}}

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Alamat / Maps</th>
                        <th>Status</th>
                        <th width="120px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>

                            <td class="fw-semibold">{{ $item->nama }}</td>

                            <td>{{ $item->kontak ?? '-' }}</td>

                            <td>
                                @if ($item->maps_url)
                                    <a href="{{ $item->maps_url }}" target="_blank" rel="noopener">
                                        {{ $item->alamat ?? 'Lihat Maps' }}
                                    </a>
                                @else
                                    {{ $item->alamat ?? '-' }}
                                @endif
                            </td>

                            <td>
                                @if ($item->is_published)
                                    <span class="badge bg-success">Dipublikasikan</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.web.diving.edit', $item->id) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="fa fa-edit"></i>
                                </a>

                                {{-- Global Delete Button --}}
                                <button class="btn btn-sm btn-danger btn-delete"
                                        data-url="{{ route('admin.web.diving.destroy', $item->id) }}"
                                        data-msg="Hapus penyedia diving ini?"
                                        data-remove="tr">
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
