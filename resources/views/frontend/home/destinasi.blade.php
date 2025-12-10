{{-- DESTINASI WISATA --}}
<div class="container-fluid service overflow-hidden pt-5 bg-light">
    <div class="container py-5">

        {{-- JUDUL --}}
        <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h5 class="sub-title text-primary px-3">Destinasi Wisata</h5>
            </div>
            <h1 class="display-5 mb-3">Temukan Keindahan Wisata Supiori</h1>
            <p class="mb-0">Jelajahi destinasi alam dan budaya terbaik di Kabupaten Supiori.</p>
        </div>

        @if ($unggulan->count())

            {{-- LIST DESTINASI --}}
            <div class="row g-4 justify-content-center">

                @foreach ($unggulan as $dest)
                    <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.2 }}s">

                        <div class="service-item">
                            <div class="service-inner">

                                {{-- FOTO --}}
                                <div class="service-img">
                                    <img src="{{ image_path($dest->gambar[0] ?? null) }}"
                                        class="img-fluid w-100 rounded" alt="{{ $dest->nama }}">
                                </div>

                                <div class="service-title">
                                    <div class="service-title-name">

                                        <div class="bg-primary text-center rounded p-3 mx-5 mb-4">
                                            <a href="{{ route('front.destinasi.show', $dest->slug) }}"
                                                class="h4 text-white mb-0">
                                                {{ $dest->nama }}
                                            </a>
                                        </div>

                                        <a href="{{ route('front.destinasi.show', $dest->slug) }}"
                                            class="btn bg-light text-secondary rounded-pill py-3 px-5 mb-4">
                                            Lihat Detail
                                        </a>

                                    </div>

                                    {{-- CONTENT --}}
                                    <div class="service-content pb-4">
                                        <a href="{{ route('front.destinasi.show', $dest->slug) }}">
                                            <h4 class="text-white mb-4 py-3">{{ $dest->nama }}</h4>
                                        </a>

                                        <div class="px-4">
                                            <p class="mb-4">
                                                {{ $dest->excerpt ?? Str::limit(strip_tags($dest->deskripsi), 120) }}
                                            </p>

                                            <a href="{{ route('front.destinasi.show', $dest->slug) }}"
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

            {{-- CTA LIHAT SEMUA --}}
            <div class="text-center mt-5">
                <a href="{{ route('front.destinasi.index') }}" class="btn btn-secondary rounded-pill px-5 py-3">
                    Lihat Semua Destinasi
                    <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        @else
            {{-- FALLBACK: DATA KOSONG --}}
            <div class="text-center py-5">
                <h5 class="text-muted">Belum ada destinasi wisata tersedia.</h5>

                <a href="{{ route('front.destinasi.index') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3">
                    Kunjungi Halaman Destinasi
                </a>
            </div>
        @endif

    </div>
</div>
