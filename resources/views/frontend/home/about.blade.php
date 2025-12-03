{{-- ABOUT SECTION --}}
@if ($info)
    <div class="container-fluid py-5 bg-light">
        <div class="container py-5">
            <div class="row g-5">

                {{-- IMAGE --}}
                <div class="col-xl-5 wow fadeInLeft" data-wow-delay="0.1s">
                    <div class="bg-light rounded overflow-hidden">

                        <img src="{{ image_path($info->image ?? null) }}" class="img-fluid w-100"
                            alt="{{ $info->title ?? 'Informasi Daerah' }}">

                    </div>
                </div>

                {{-- TEXT --}}
                <div class="col-xl-7 wow fadeInRight" data-wow-delay="0.3s">

                    <h5 class="sub-title pe-3">{{ $info->subtitle }}</h5>

                    <h1 class="display-5 mb-4">
                        {{ $info->title }}
                    </h1>

                    {{-- CONTENT WITH PARAGRAPH HANDLING --}}
                    @php
                        $paragraphs = preg_split("/\r\n|\n|\r/", trim($info->content));
                    @endphp

                    <div class="text-dark content-format">
                        @foreach ($paragraphs as $p)
                            @if (trim($p) !== '')
                                <p>{{ $p }}</p>
                            @else
                                <br>
                            @endif
                        @endforeach
                    </div>

                    <div class="row gy-4 mt-3">

                        <div class="col-12 col-sm-6 d-flex align-items-center">
                            <i class="fas fa-map-marked-alt fa-3x text-secondary"></i>
                            <h5 class="ms-4">Destinasi Alam yang Memukau</h5>
                        </div>

                        <div class="col-12 col-sm-6 d-flex align-items-center">
                            <i class="fas fa-water fa-3x text-secondary"></i>
                            <h5 class="ms-4">Spot Snorkeling & Diving Terbaik</h5>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
