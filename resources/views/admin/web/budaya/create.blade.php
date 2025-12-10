@extends('admin.layouts.master')
@section('title', 'Tambah Budaya')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            <h4 class="mb-4">Tambah Data Kebudayaan</h4>

            <form action="{{ route('admin.web.budaya.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('admin.web.budaya._form')

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>

        </div>
    </div>

@endsection
