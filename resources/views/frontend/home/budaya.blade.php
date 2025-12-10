{{-- BUDAYA SUPIORI --}}
<div class="container-fluid service overflow-hidden pt-5">
    <div class="container py-5">

        {{-- JUDUL --}}
        <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h5 class="sub-title text-primary px-3">Budaya Supiori</h5>
            </div>
            <h1 class="display-5 mb-3">Warisan Tradisi & Kearifan Lokal</h1>
            <p class="mb-0">
                Mengenal kekayaan budaya, adat, dan kisah masyarakat Supiori.
            </p>
        </div>

        @if ($budaya->count())

            {{-- LIST BUDAYA --}}
            <div class="row g-4 justify-content-center">

                @foreach ($budaya as $b)
                    <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.2 }}s">

                        <div class="service-item">
                            <div class="service-inner">

                                {{-- GAMBAR --}}
                                <div class="service-img">
                                    <img src="{{ image_path($b->gambar) }}" class="img-fluid w-100 rounded"
                                        alt="{{ $b->judul }}">
                                </div>

                                <div class="service-title">
                                    <div class="service-title-name">

                                        <div class="bg-primary text-center rounded p-3 mx-5 mb-4">
                                            <a href="{{ route('front.budaya.show', $b->slug) }}"
                                                class="h4 text-white mb-0">
                                                {{ $b->judul }}
                                            </a>
                                        </div>

                                        <a href="{{ route('front.budaya.show', $b->slug) }}"
                                            class="btn bg-light text-secondary rounded-pill py-3 px-5 mb-4">
                                            Lihat Detail
                                        </a>

                                    </div>

                                    {{-- CONTENT --}}
                                    <div class="service-content pb-4">
                                        <a href="{{ route('front.budaya.show', $b->slug) }}">
                                            <h4 class="text-white mb-4 py-3">{{ $b->judul }}</h4>
                                        </a>

                                        <div class="px-4">
                                            <p class="mb-4">
                                                {{ $b->ringkasan ?? Str::limit(strip_tags($b->deskripsi), 120) }}
                                            </p>

                                            <a href="{{ route('front.budaya.show', $b->slug) }}"
                                                class="btn btn-primary rounded-pill text-white py-3 px-5">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                @endforeach

            </div>

            {{-- CTA --}}
            <div class="text-center mt-5">
                <a href="{{ route('front.budaya.index') }}" class="btn btn-secondary rounded-pill px-5 py-3">
                    Lihat Semua Budaya
                    <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        @else
            {{-- FALLBACK --}}
            <div class="text-center py-5">
                <h5 class="text-muted">Belum ada data budaya tersedia.</h5>

                <a href="{{ route('front.budaya.index') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3">
                    Kunjungi Halaman Budaya
                </a>
            </div>

        @endif

    </div>
</div>
