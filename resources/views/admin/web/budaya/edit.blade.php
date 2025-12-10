@extends('admin.layouts.master')
@section('title', 'Edit Budaya')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            <h4 class="mb-4">Edit Data Kebudayaan</h4>

            <form action="{{ route('admin.web.budaya.update', $budaya->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                @include('admin.web.budaya._form')

                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>

        </div>
    </div>

@endsection
