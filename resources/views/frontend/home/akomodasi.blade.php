{{-- AKOMODASI REKOMENDASI --}}
@if ($akomodasi->count())
    <div class="container-fluid training overflow-hidden py-5">
        <div class="container">

            {{-- JUDUL --}}
            <div class="section-title text-center z-50 wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 70px;">
                <div class="sub-style">
                    <h5 class="sub-title text-primary px-3">AKOMODASI</h5>
                </div>
                <h1 class="display-5 mb-4">Akomodasi Rekomendasi di Supiori</h1>
                <p class="mb-0">Pilihan tempat menginap terbaik dengan kenyamanan dan akses mudah ke lokasi wisata.</p>
            </div>

            <div class="row g-4 justify-content-center">

                @foreach ($akomodasi as $akom)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.2 }}s">
                        <div class="training-item">

                            <div class="training-inner">
                                <img src="{{ image_path($akom->images[0] ?? null) }}" alt="{{ $akom->nama }}"
                                    class="img-fluid w-100 rounded">

                                <div class="training-title-name">
                                    <a class="h4 text-white mb-0">{{ $akom->nama }}</a>
                                    <a class="h4 text-white mb-0">{{ $akom->tipe ?: 'Akomodasi' }}</a>
                                </div>
                            </div>

                            <div class="training-content bg-secondary rounded-bottom p-4">
                                <a>
                                    <h4 class="text-white">{{ $akom->nama }}</h4>
                                </a>

                                @if ($akom->price_range)
                                    <p class="text-white-50 mb-2">Harga: {{ $akom->price_range }}</p>
                                @endif

                                <a class="btn btn-secondary rounded-pill text-white p-0"
                                    href="{{ route('front.akomodasi.show', $akom->slug) }}">
                                    Lihat Detail <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
@endif
