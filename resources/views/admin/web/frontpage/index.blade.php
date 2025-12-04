@extends('admin.layouts.master')

@section('title', 'Pengaturan Halaman Depan')

@section('content')

    @php $breadcrumb = 'Pengaturan Halaman Depan'; @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            <h4 class="mb-4">Pengaturan Halaman Depan</h4>

            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Notifikasi error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.web.frontpage.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- NAV TABS --}}
                <ul class="nav nav-tabs" id="frontpageTabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tabHero">Hero</a></li>
                    {{-- <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabWelcome">Welcome</a></li> --}}
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabGuide">Daya Tarik Wilayah</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabSlider">Slider Destinasi</a>
                    </li>
                    {{-- <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabFooter">Kontak Footer</a></li> --}}
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabLogo">Logo</a></li>
                </ul>

                <div class="tab-content p-4">

                    {{-- TAB HERO --}}
                    <div class="tab-pane fade show active" id="tabHero">
                        <h5 class="mb-3">Hero Section</h5>

                        <div class="mb-3">
                            <label class="form-label">Judul (Hero Title)</label>
                            <input type="text" name="hero_title" class="form-control"
                                value="{{ old('hero_title', $settings->hero_title ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subjudul (Hero Subtitle)</label>
                            <textarea name="hero_subtitle" class="form-control">{{ old('hero_subtitle', $settings->hero_subtitle ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Hero</label><br>
                            <small class="text-primary">file Max 3MB| Format: JPG, PNG, WEBP</small>
                            <input type="file" name="hero_image" class="form-control">

                            @if (!empty($settings->hero_image))
                                <img src="{{ asset('storage/' . $settings->hero_image) }}" class="img-fluid mt-3 rounded"
                                    style="max-height: 200px;">
                            @endif
                        </div>
                    </div>

                    {{-- TAB WELCOME
                    <div class="tab-pane fade" id="tabWelcome">
                        <h5 class="mb-3">Welcome Section</h5>

                        <div class="mb-3">
                            <label class="form-label">Judul Welcome</label>
                            <input type="text" name="welcome_title" class="form-control"
                                value="{{ old('welcome_title', $settings->welcome_title ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Welcome</label>
                            <textarea name="welcome_text" class="form-control">{{ old('welcome_text', $settings->welcome_text ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Welcome</label>
                            <input type="file" name="welcome_image" class="form-control">

                            @if (!empty($settings->welcome_image))
                                <img src="{{ asset('storage/' . $settings->welcome_image) }}" class="img-fluid mt-3 rounded"
                                    style="max-height: 200px;">
                            @endif
                        </div>
                    </div> --}}

                    {{-- TAB GUIDE --}}
                    <div class="tab-pane fade" id="tabGuide">
                        <h5 class="mb-3">Mengapa Harus Ke Supiori?</h5>

                        <div class="row">
                            {{-- Card 1 --}}
                            <div class="col-md-4">
                                <label>Daya Tarik 1</label>
                                <input name="guide1_title" class="form-control mb-2"
                                    value="{{ old('guide1_title', $settings->guide1_title ?? '') }}">
                                <textarea name="guide1_text" class="form-control">{{ old('guide1_text', $settings->guide1_text ?? '') }}</textarea>
                            </div>

                            {{-- Card 2 --}}
                            <div class="col-md-4">
                                <label>Daya Tarik 2</label>
                                <input name="guide2_title" class="form-control mb-2"
                                    value="{{ old('guide2_title', $settings->guide2_title ?? '') }}">
                                <textarea name="guide2_text" class="form-control">{{ old('guide2_text', $settings->guide2_text ?? '') }}</textarea>
                            </div>

                            {{-- Card 3 --}}
                            <div class="col-md-4">
                                <label>Daya Tarik 3</label>
                                <input name="guide3_title" class="form-control mb-2"
                                    value="{{ old('guide3_title', $settings->guide3_title ?? '') }}">
                                <textarea name="guide3_text" class="form-control">{{ old('guide3_text', $settings->guide3_text ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- TAB SLIDER --}}
                    <div class="tab-pane fade" id="tabSlider">
                        <h5 class="mb-3">Slider Destinasi Unggulan</h5>
                        <p class="text-muted">Pilih destinasi yang ingin ditampilkan sebagai slider di halaman utama.</p>

                        @foreach ($destinasi as $d)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="slider[]" value="{{ $d->id }}"
                                    {{ in_array($d->id, old('slider', $settings->slider ?? [])) ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    {{ $d->nama }}
                                    @if ($d->kategori)
                                        <small class="text-muted">({{ $d->kategori }})</small>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>


                    {{-- TAB FOOTER --}}
                    {{-- <div class="tab-pane fade" id="tabFooter">
                        <h5 class="mb-3">Kontak Footer</h5>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <input name="contact_address" class="form-control"
                                value="{{ old('contact_address', $settings->contact_address ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label>Telepon</label>
                            <input name="contact_phone" class="form-control"
                                value="{{ old('contact_phone', $settings->contact_phone ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input name="contact_email" class="form-control"
                                value="{{ old('contact_email', $settings->contact_email ?? '') }}">
                        </div>
                    </div> --}}

                    {{-- TAB LOGO --}}
                    <div class="tab-pane fade" id="tabLogo">
                        <h5 class="mb-3">Logo </h5>

                        <div class="mb-3">
                            <label class="form-label">Logo Daerah</label><br>
                            <small class="text-primary">file Max 3MB | Format: JPG, PNG, WEBP</small>
                            <input type="file" name="logo" class="form-control">

                            @if (!empty($settings->logo))
                                <img src="{{ asset('storage/' . $settings->logo) }}" class="img-fluid mt-3 rounded"
                                    style="max-height: 120px;">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Logo Dinas</label><br>
                            <small class="text-primary">file Max 3MB | Format: JPG, PNG, WEBP</small>
                            <input type="file" name="favicon" class="form-control">

                            @if (!empty($settings->favicon))
                                <img src="{{ asset('storage/' . $settings->favicon) }}" class="img-fluid mt-3 rounded"
                                    style="max-height: 80px;">
                            @endif
                        </div>
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Simpan Pengaturan</button>

            </form>

        </div>
    </div>

@endsection
