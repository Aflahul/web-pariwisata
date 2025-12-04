{{-- AKOMODASI REKOMENDASI --}}
@if ($akomodasi->count())
    <div class="container-fluid training overflow-hidden py-5">
        <div class="container">

            {{-- JUDUL --}}
            <div class="section-title text-center wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 70px;">
                <div class="sub-style">
                    <h5 class="sub-title text-primary px-3">Akomodasi</h5>
                </div>
                <h1 class="display-5 mb-3">Akomodasi Rekomendasi di Supiori</h1>
                <p class="mb-0">Tempat menginap terbaik dengan kenyamanan dan akses mudah ke lokasi wisata.</p>
            </div>

            <div class="row g-4 justify-content-center">

                @foreach ($akomodasi as $akom)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.2 }}s">

                        <div class="training-item">

                            {{-- FOTO --}}
                            <div class="training-inner">
                                <img src="{{ image_path($akom->images[0] ?? null) }}" alt="{{ $akom->nama }}"
                                    class="img-fluid w-100 rounded">

                                <div class="training-title-name">
                                    <h4 class="text-white mb-0">{{ $akom->nama }}</h4>
                                    <span class="text-white-50 small">
                                        {{ $akom->tipe ?: 'Akomodasi' }}
                                    </span>
                                </div>
                            </div>

                            {{-- CARD CONTENT --}}
                            <div class="training-content bg-secondary rounded-bottom p-4">

                                <h5 class="text-white">{{ $akom->nama }}</h5>

                                @if ($akom->price_range)
                                    <p class="text-white-50 mb-2">
                                        <i class="fa fa-tag me-1"></i> {{ $akom->price_range }}
                                    </p>
                                @endif

                                <a href="{{ route('front.akomodasi.show', $akom->slug) }}"
                                    class="btn btn-light rounded-pill px-4 py-2 mt-2">
                                    Lihat Detail <i class="fa fa-arrow-right ms-1"></i>
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- CTA LIHAT SEMUA --}}
            <div class="text-center mt-5">
                <a href="{{ route('front.akomodasi.index') }}" class="btn btn-secondary rounded-pill px-5 py-3">
                    Lihat Semua Akomodasi
                    <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>

        </div>
    </div>
@else
    {{-- fallback jika tidak ada data --}}
    <div class="container py-5 text-center">
        <h5 class="text-muted">Belum ada akomodasi yang tersedia.</h5>
    </div>
@endif
