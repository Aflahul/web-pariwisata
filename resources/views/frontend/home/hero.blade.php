{{-- HERO SECTION --}}
<div class="carousel-header">
    <div id="carouselHome" class="carousel slide" data-bs-ride="carousel">

        {{-- Indicator --}}
        @if ($sliderItems->count() > 1)
            <ol class="carousel-indicators">
                @foreach ($sliderItems as $item)
                    <li data-bs-target="#carouselHome" data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}">
                    </li>
                @endforeach
            </ol>
        @endif

        {{-- Carousel items --}}
        <div class="carousel-inner" role="listbox">

            {{-- Jika user mengatur hero image custom --}}
            @if ($fp && $fp->hero_image)
                <div class="carousel-item active">
                    <img src="{{ image_path($fp->hero_image) }}" class="img-fluid" alt="Hero">

                    <div class="carousel-caption">
                        <div class="text-center p-4" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-3 mb-md-4">
                                {{ $fp->hero_title }}
                            </h4>
                            <h1 class="display-1 text-capitalize text-white mb-3 mb-md-4">
                                {{ $fp->hero_subtitle }}
                            </h1>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Slider destinasi unggulan --}}
            @foreach ($sliderItems as $item)
                <div class="carousel-item {{ !$fp->hero_image && $loop->first ? 'active' : '' }}">

                    {{-- gambar cover destinasi --}}
                    <img src="{{ image_path($item->gambar[0] ?? null) }}" class="img-fluid w-100"
                        alt="{{ $item->nama }}">

                    <div class="carousel-caption">
                        <div class="text-center p-4" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-3 mb-md-4">
                                Destinasi Unggulan
                            </h4>

                            <h1 class="display-1 text-capitalize text-white mb-3 mb-md-4">
                                {{ $item->nama }}
                            </h1>

                            @if ($item->excerpt)
                                <p class="text-white mb-4 mb-md-5 fs-5">
                                    {!! nl2br(e( $item->excerpt) ) !!}
                                </p>
                            @endif

                            <a class="btn btn-primary border-secondary rounded-pill text-white py-3 px-5"
                                href="{{ route('front.destinasi.show', $item->slug) }}">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Controls --}}
        @if ($sliderItems->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-secondary"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-secondary"></span>
            </button>
        @endif

    </div>
</div>
