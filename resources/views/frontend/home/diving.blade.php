{{-- PENYEDIA JASA DIVING --}}
<div class="container-fluid contact overflow-hidden pb-5 bg-light">
    <div class="container py-5">

        <div class="office pt-5">

            {{-- JUDUL --}}
            <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h5 class="sub-title text-primary px-3">PENYEDIA JASA WISATA</h5>
                </div>
                <h1 class="display-5 mb-4">Penyedia Jasa Wisata di Supiori</h1>
                <p class="mb-0">
                    Temukan penyedia jasa dan alat diving profesional untuk kenyamanan wisata dan eksplorasi bawah laut
                    yang aman dan menyenangkan.
                </p>
            </div>

            @if ($diving->count())

                <div class="row g-4 justify-content-center">
                    @foreach ($diving as $dv)
                        <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp "
                            data-wow-delay="{{ $loop->iteration * 0.2 }}s">

                            <div class="office-item p-4 bg-white">

                                {{-- FOTO --}}
                                <div class="office-img mb-4">
                                    <img src="{{ image_path($dv->gambar[0] ?? null) }}" class="img-fluid w-100 rounded"
                                        alt="{{ $dv->nama }}">
                                </div>

                                {{-- CONTENT --}}
                                <div class="office-content d-flex flex-column">
                                    <h4 class="mb-2">{{ $dv->nama }}</h4>

                                    @if ($dv->kontak)
                                        <a href="tel:{{ $dv->kontak }}" class="text-secondary fs-5 mb-2">
                                            {{ $dv->kontak }}
                                        </a>
                                    @endif

                                    @if ($dv->email)
                                        <a href="mailto:{{ $dv->email }}" class="text-muted fs-5 mb-2">
                                            {{ $dv->email }}
                                        </a>
                                    @endif

                                    @if ($dv->alamat)
                                        <p class="mb-0">{{ $dv->alamat }}</p>
                                    @endif

                                    {{-- DETAIL --}}
                                    <a href="{{ route('front.diving.show', $dv->slug) }}"
                                        class="btn btn-primary rounded-pill mt-3 px-4 py-2">
                                        Lihat Detail
                                    </a>
                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- CTA LIHAT SEMUA --}}
                <div class="text-center mt-5">
                    <a href="{{ route('front.diving.index') }}" class="btn btn-secondary rounded-pill px-5 py-3">
                        Lihat Semua Penyedia
                        <i class="fa fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @else
                {{-- FALLBACK --}}
                <div class="text-center py-5">
                    <h5 class="text-muted">Belum ada penyedia jasa wisata tersedia.</h5>

                    <a href="{{ route('front.diving.index') }}" class="btn btn-outline-primary rounded-pill mt-3 px-4">
                        Kunjungi Halaman Penyedia
                    </a>
                </div>
            @endif

        </div>

    </div>
</div>
