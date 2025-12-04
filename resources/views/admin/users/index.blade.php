@extends('admin.layouts.master')

@section('title', 'Manajemen User')

@section('content')

@php $breadcrumb = 'Manajemen User'; @endphp

<div class="container-fluid pt-4">
    <div class="bg-light rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Manajemen User</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> User Baru
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $u)
                        <tr class="user-row">
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">{{ $u->name }}</td>

                            <td>{{ $u->email }}</td>

                            <td>
                                @if ($u->role === 'super_admin')
                                    <span class="badge bg-success px-3 py-2">Super Admin</span>
                                @else
                                    <span class="badge bg-primary px-3 py-2">Admin</span>
                                @endif
                            </td>

                            <td>

                                <a href="{{ route('admin.users.edit', $u->id) }}"
                                   class="btn btn-sm btn-warning px-3 me-1">
                                   <i class="fa fa-edit"></i>
                                </a>

                                @if (auth()->id() === $u->id)
                                    <button class="btn btn-sm btn-danger px-3 disabled" disabled>
                                        <i class="fa fa-ban"></i>
                                    </button>
                                @else
                                    <button 
                                        class="btn btn-sm btn-danger px-3 btn-delete"
                                        data-url="{{ route('admin.users.destroy', $u->id) }}"
                                        data-msg="Hapus user '{{ $u->name }}'?"
                                        data-remove=".user-row"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
