{{-- PANDUAN WISATA / WHY CHOOSE US --}}
@if ($fp && ($fp->guide1_title || $fp->guide2_title || $fp->guide3_title))
    <div class="container-fluid features overflow-hidden py-5">
        <div class="container">

            {{-- JUDUL --}}
            <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h5 class="sub-title text-primary px-3">Kenapa Harus Wisata Supiori?</h5>
                </div>
                <h1 class="display-5 mb-4">Alasan Kenapa Supiori Wajib Masuk Bucket List Anda</h1>
            </div>

            <div class="row g-4 justify-content-center text-center">

                {{-- Guide 1 --}}
                @if ($fp->guide1_title)
                    <div class="col-md-6 col-lg-4 wow fadeInUp " data-wow-delay="0.1s ">
                        <div class="feature-item text-center p-4">
                            <div class="feature-icon p-3 mb-4">
                                <i class="fas fa-map-marked-alt fa-3x text-primary"></i>
                            </div>
                            <h5 class="mb-3">{{ $fp->guide1_title }}</h5>
                            <p class="mb-3">{{ $fp->guide1_text }}</p>
                        </div>
                    </div>
                @endif

                {{-- Guide 2 --}}
                @if ($fp->guide2_title)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="feature-item text-center p-4">
                            <div class="feature-icon p-3 mb-4">
                                <i class="fas fa-water fa-3x text-primary"></i>
                            </div>
                            <h5 class="mb-3">{{ $fp->guide2_title }}</h5>
                            <p class="mb-3">{{ $fp->guide2_text }}</p>
                        </div>
                    </div>
                @endif

                {{-- Guide 3 --}}
                @if ($fp->guide3_title)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="feature-item text-center p-4">
                            <div class="feature-icon p-3 mb-4">
                                <i class="fas fa-umbrella-beach fa-3x text-primary"></i>
                            </div>
                            <h5 class="mb-3">{{ $fp->guide3_title }}</h5>
                            <p class="mb-3">{{ $fp->guide3_text }}</p>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>

@endif
