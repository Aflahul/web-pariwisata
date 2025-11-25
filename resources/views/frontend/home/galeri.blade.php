{{-- GALERI TERBARU --}}
@if ($galeri->count())
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

            {{-- GRID --}}
            <div class="row g-4 text-center">

                @foreach ($galeri as $item)
                    <div class="col-lg-6 col-xl-3 mb-5 mb-xl-0 wow fadeInUp"
                         data-wow-delay="{{ $loop->iteration * 0.15 }}s">

                        <div class="country-item">

                            {{-- FOTO --}}
                            <div class="rounded overflow-hidden">
                                <img src="{{ image_path($item['src']) }}"
                                     class="img-fluid w-100 rounded"
                                     alt="{{ $item['title'] ?? 'foto' }}">
                            </div>

                            {{-- NAMA DESTINASI ATAU JUDUL --}}
                            @if ($item['title'])
                                <div class="country-name">
                                    <a class="text-white fs-4">{{ $item['title'] }}</a>
                                </div>
                            @endif

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- TOMBOL MORE --}}
            <div class="text-center mt-4">
                <a class="btn btn-primary border-secondary rounded-pill py-3 px-5 wow fadeInUp"
                   data-wow-delay="0.1s"
                   href="{{ route('front.galeri.index') }}">
                    Lihat Semua Galeri
                </a>
            </div>

        </div>
    </div>
@endif
