@extends('admin.layouts.master')

@section('title', 'Manajemen User')

@section('content')

    @php $breadcrumb = 'Manajemen User'; @endphp

    <div class="container-fluid pt-4 ">
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

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr>
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

                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-warning px-3 me-1"
                                        aria-label="Edit {{ $u->name }}">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    {{-- Tombol HAPUS dengan validasi UI --}}
                                    @if (auth()->id() === $u->id)
                                        {{-- Tidak boleh hapus diri sendiri --}}
                                        <button class="btn btn-sm btn-danger px-3 disabled"
                                            title="Anda tidak dapat menghapus akun Anda sendiri." disabled>
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    @else
                                        {{-- Hapus user lain --}}
                                        <button type="button" class="btn btn-sm btn-danger px-3" data-bs-toggle="modal"
                                            data-bs-target="#modalDelete" data-user-name="{{ $u->name }}"
                                            data-delete-url="{{ route('admin.users.destroy', $u->id) }}">
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


    <!-- Shared Delete Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-black">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus user <strong id="modalDeleteName"></strong>?</p>

                    <form id="deleteForm" method="POST" action="#">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 mt-3">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('modalDelete');
            modal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                var name = button.getAttribute('data-user-name');
                var url = button.getAttribute('data-delete-url');

                document.getElementById('modalDeleteName').textContent = name;
                document.getElementById('deleteForm').action = url;
            });
        });
    </script>

@endsection
