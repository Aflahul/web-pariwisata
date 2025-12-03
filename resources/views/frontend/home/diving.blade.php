{{-- PENYEDIA JASA DIVING --}}
@if ($diving->count())
    <div class="container-fluid contact overflow-hidden pb-5">
        <div class="container py-5">

            <div class="office pt-5">

                {{-- JUDUL --}}
                <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="sub-style">
                        <h5 class="sub-title text-primary px-3">PENYEDIA JASA WISATA</h5>
                    </div>
                    <h1 class="display-5 mb-4">Penyedia Jasa Wisata di Supiori</h1>
                    <p class="mb-0">
                        Temukan penyedia jasa dan alat diving profesional untuk kenyamanan wisata dan eksplorasi bawah laut yang aman dan menyenangkan.
                    </p>
                </div>

                <div class="row g-4 justify-content-center">

                    @foreach ($diving as $dv)
                        <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp"
                             data-wow-delay="{{ $loop->iteration * 0.2 }}s">

                            <div class="office-item p-4">

                                {{-- FOTO --}}
                                <div class="office-img mb-4">
                                    <img src="{{ image_path($dv->gambar[0] ?? null) }}"
                                         class="img-fluid w-100 rounded"
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

                                    {{-- Detail --}}
                                    <a class="btn btn-primary rounded-pill mt-3 px-4 py-2"
                                       href="{{ route('front.diving.show', $dv->slug) }}">
                                        Lihat Detail
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>
@endif
