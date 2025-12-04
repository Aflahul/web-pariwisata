{{-- GALERI TERBARU --}}
<div class="container-fluid country overflow-hidden py-5">

    <div class="container">

        {{-- JUDUL --}}
        <div class="section-title text-center wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 70px;">
            <div class="sub-style">
                <h5 class="sub-title text-primary px-3">GALERI WISATA</h5>
            </div>
            <h1 class="display-5 mb-4">Potret Keindahan Kabupaten Supiori</h1>
            <p class="mb-0">Foto-foto terbaru dari destinasi wisata dan momen terbaik yang berhasil kami abadikan.</p>
        </div>

        @if ($galeri->count())

            {{-- GRID --}}
            <div class="row g-4 justify-content-center">

                @foreach ($galeri as $item)
                    <div class="col-lg-6 col-xl-3 mb-5 mb-xl-0 wow fadeInUp"
                        data-wow-delay="{{ $loop->iteration * 0.15 }}s">

                        <div class="country-item">

                            {{-- FOTO --}}
                            <div class="rounded overflow-hidden">
                                <img src="{{ image_path($item['src']) }}" class="img-fluid w-100 rounded"
                                    alt="{{ $item['title'] ?? 'foto' }}">
                            </div>

                            {{-- JUDUL --}}
                            @if ($item['title'])
                                <div class="country-name">
                                    <span class="text-white fs-4">{{ $item['title'] }}</span>
                                </div>
                            @endif

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- CTA: LIHAT SEMUA --}}
            <div class="text-center mt-5">
                <a href="{{ route('front.galeri.index') }}"
                    class="btn btn-primary border-secondary rounded-pill py-3 px-5 wow fadeInUp" data-wow-delay="0.1s">
                    Lihat Semua Galeri
                </a>
            </div>
        @else
            {{-- FALLBACK --}}
            <div class="text-center py-5">
                <h5 class="text-muted">Belum ada galeri tersedia.</h5>

                <a href="{{ route('front.galeri.index') }}" class="btn btn-outline-primary rounded-pill mt-3 px-4 py-2">
                    Kunjungi Halaman Galeri
                </a>
            </div>

        @endif

    </div>

</div>
