@extends('admin.layouts.master')

@section('title', 'User Baru')

@section('content')

    @php $breadcrumb = 'Tambah User'; @endphp

    <div class="container-fluid pt-4 ">
        <div class="bg-light rounded p-4">

            <h4 class="mb-4">Tambah User Baru</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin
                            </option>
                        </select>
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-primary px-4">Simpan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </form>

        </div>
    </div>

@endsection
