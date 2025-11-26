@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')

    @php $breadcrumb = 'Dashboard'; @endphp

    <div class="container-fluid">
        <div class="bg-light rounded p-4">

            <!-- HEADER -->
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-0">Dashboard</h4>
            </div>

            <p>
                Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
                Anda login sebagai <strong>{{ auth()->user()->role }}</strong>.
            </p>

            <!-- STATISTICS CARDS -->
            <div class="row g-4 mt-4">

                <!-- Destinasi Total -->
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded border p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-2">Total Destinasi</p>
                            <h5 class="mb-0">{{ $totalDestinasi }}</h5>
                        </div>
                        <i class="fa fa-map fa-2x text-primary"></i>
                    </div>
                </div>

                <!-- Destinasi Unggulan -->
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded border p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-2">Destinasi Unggulan</p>
                            <h5 class="mb-0">{{ $destinasiUnggulan }}</h5>
                        </div>
                        <i class="fa fa-star fa-2x text-warning"></i>
                    </div>
                </div>

                <!-- Total Akomodasi -->
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded border p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-2">Total Akomodasi</p>
                            <h5 class="mb-0">{{ $totalAkomodasi }}</h5>
                        </div>
                        <i class="fa fa-hotel fa-2x text-success"></i>
                    </div>
                </div>

                <!-- Akomodasi Publish -->
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded border p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-2">Akomodasi Publish</p>
                            <h5 class="mb-0">{{ $akomodasiPublished }}</h5>
                        </div>
                        <i class="fa fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>

                <!-- Total Penyedia Diving -->
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded border p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-2">Penyedia Diving</p>
                            <h5 class="mb-0">{{ $totalDiving }}</h5>
                        </div>
                        <i class="fa fa-water fa-2x text-info"></i>
                    </div>
                </div>

                <!-- Diving Publish -->
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded border p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-2">Diving Publish</p>
                            <h5 class="mb-0">{{ $divingPublished }}</h5>
                        </div>
                        <i class="fa fa-check-circle fa-2x text-info"></i>
                    </div>
                </div>

                @if (auth()->user()->role === 'super_admin')
                    <!-- Total Admin -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-white rounded border p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-2">Total Admin</p>
                                <h5 class="mb-0">{{ $totalAdmin }}</h5>
                            </div>
                            <i class="fa fa-user-shield fa-2x text-secondary"></i>
                        </div>
                    </div>

                    <!-- Total Super Admin -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-white rounded border p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-2">Super Admin</p>
                                <h5 class="mb-0">{{ $totalSuperAdmin }}</h5>
                            </div>
                            <i class="fa fa-user-secret fa-2x text-danger"></i>
                        </div>
                    </div>
                @endif


            </div>
            <div class="row mt-4">
                <div class="col-12">

                    <ul class="nav nav-tabs" id="recentTab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                                type="button">
                                Semua
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="dest-tab" data-bs-toggle="tab" data-bs-target="#dest"
                                type="button">
                                Destinasi
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="akom-tab" data-bs-toggle="tab" data-bs-target="#akom"
                                type="button">
                                Akomodasi
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="diving-tab" data-bs-toggle="tab" data-bs-target="#diving"
                                type="button">
                                Jasa Wisata
                            </button>
                        </li>

                    </ul>

                    <div class="tab-content bg-white border border-top-0 p-3 rounded-bottom">

                        {{-- TAB: SEMUA --}}
                        <div class="tab-pane fade show active" id="all">
                            @if ($recentAll->count())
                                <ul class="list-group">
                                    @foreach ($recentAll as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">

                                            <div>
                                                {{-- Kategori --}}
                                                @if ($item instanceof \App\Models\Destinasi)
                                                    <span class="badge bg-primary">Destinasi</span>
                                                @elseif ($item instanceof \App\Models\Akomodasi)
                                                    <span class="badge bg-success">Akomodasi</span>
                                                @elseif ($item instanceof \App\Models\PenyediaDiving)
                                                    <span class="badge bg-warning text-dark">Jasa Wisata</span>
                                                @endif

                                                <span class="ms-2">{{ $item->nama }}</span>
                                            </div>

                                            <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada data.</p>
                            @endif
                        </div>

                        {{-- TAB: DESTINASI --}}
                        <div class="tab-pane fade" id="dest">
                            @if ($recentDestinasi->count())
                                <ul class="list-group">
                                    @foreach ($recentDestinasi as $item)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>{{ $item->nama }}</span>
                                            <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada destinasi.</p>
                            @endif
                        </div>

                        {{-- TAB: AKOMODASI --}}
                        <div class="tab-pane fade" id="akom">
                            @if ($recentAkomodasi->count())
                                <ul class="list-group">
                                    @foreach ($recentAkomodasi as $item)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>{{ $item->nama }}</span>
                                            <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada akomodasi.</p>
                            @endif
                        </div>

                        {{-- TAB: DIVING --}}
                        <div class="tab-pane fade" id="diving">
                            @if ($recentDiving->count())
                                <ul class="list-group">
                                    @foreach ($recentDiving as $item)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>{{ $item->nama }}</span>
                                            <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada jasa wisata.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
