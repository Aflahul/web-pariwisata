{{-- ABOUT SECTION --}}
@if ($info)
<div class="container-fluid py-5 bg-dark">
    <div class="container py-5">
        <div class="row g-5">

            {{-- IMAGE --}}
            <div class="col-xl-5 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="bg-light rounded overflow-hidden" style="max-height:420px;">
                    <img src="{{ image_path($info->image ?? null) }}"
                         class="img-fluid w-100"
                         alt="{{ $info->title ?? 'Informasi Daerah' }}"
                         style="object-fit:cover;">
                </div>
            </div>

            {{-- TEXT --}}
            <div class="col-xl-7 wow fadeInRight" data-wow-delay="0.3s">

                <h5 class="sub-title pe-3 text-light">
                    {{ $info->subtitle ?? 'Informasi Daerah' }}
                </h5>

                <h1 class="display-5 mb-4 text-light">
                    {{ $info->title ?? 'Tentang Supiori' }}
                </h1>

                @php
                    $content = $info->content ?? '';
                    $paragraphs = preg_split("/\r\n|\n|\r/", trim($content));
                    $paragraphs = array_slice($paragraphs, 0, 3);
                @endphp

                <div class="text-light content-format">
                    @foreach ($paragraphs as $p)
                        @if (trim($p) !== '')
                            <p>{{ Str::limit($p, 300) }}</p>
                        @endif
                    @endforeach
                </div>

                {{-- CTA BENAR --}}
                <a href="{{ route('front.info.index') }}"
                   class="btn btn-info rounded-pill px-4 py-2 mb-4 mt-2">
                    Selengkapnya
                </a>

                {{-- ICONS --}}
                <div class="row gy-4 mt-3">

                    <div class="col-12 col-sm-6 d-flex align-items-center">
                        <i class="fas fa-map-marked-alt fa-3x text-secondary"></i>
                        <h5 class="ms-4 text-light">Destinasi Alam Memukau</h5>
                    </div>

                    <div class="col-12 col-sm-6 d-flex align-items-center">
                        <i class="fas fa-water fa-3x text-secondary"></i>
                        <h5 class="ms-4 text-light">Snorkeling & Diving</h5>
                    </div>

                    <div class="col-12 col-sm-6 d-flex align-items-center">
                        <i class="fas fa-ship fa-3x text-secondary"></i>
                        <h5 class="ms-4 text-light">Budaya & Sejarah</h5>
                    </div>

                    <div class="col-12 col-sm-6 d-flex align-items-center">
                        <i class="fas fa-users fa-3x text-secondary"></i>
                        <h5 class="ms-4 text-light">Keramahan Lokal</h5>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endif
