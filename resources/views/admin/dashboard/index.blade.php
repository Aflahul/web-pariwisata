@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')


    @php $breadcrumb = 'Dashboard'; @endphp


    <div class="container-fluid pt-4 ">
        <div class="bg-light rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-0">Dashboard</h4>
            </div>


            <p>Selamat datang, <strong>{{ auth()->user()?->name }}</strong>. Anda login sebagai
                <strong>{{ auth()->user()?->role }}</strong>.</p>


            <!-- contoh card singkat -->
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded d-flex align-items-center justify-content-between p-4 border">
                        <div>
                            <p class="mb-2">Total Admin</p>
                            <h6 class="mb-0">{{ \App\Models\User::count() }}</h6>
                        </div>
                        <i class="fa fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection
