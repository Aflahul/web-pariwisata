<div class="container-fluid nav-bar p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0 navbar-transparent">

        <a href="{{ route('front.home') }}" class="navbar-brand d-flex align-items-center gap-3 p-1">

            {{-- LOGO --}}
            @if (isset($fp) && $fp->logo)
                <img src="{{ image_path($fp->logo) }}" alt="Logo Kab" class="img-fluid" style="height: 50px; width:auto;">
                <img src="{{ image_path($fp->favicon) }}" alt="Logo Dinas" class="img-fluid"
                    style="height: 50px; width:auto;">
            @endif

            {{-- TEKS DI SAMPING LOGO --}}
            <div class="d-flex flex-column lh-sm">
                <span class="fw-bold text-light" style="font-size: 1.1rem;">
                    Dinas Kebudayaan dan Pariwisata
                </span>
                <span class="fw-bold text-light" style="font-size: 1.1rem;">
                    Kabupaten Supiori
                </span>
            </div>

        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">

                <a href="{{ route('front.home') }}" class="nav-item nav-link">Beranda</a>
                <a href="{{ route('front.destinasi.index') }}" class="nav-item nav-link">Destinasi</a>
                <a href="{{ route('front.akomodasi.index') }}" class="nav-item nav-link">Akomodasi</a>
                <a href="{{ route('front.diving.index') }}" class="nav-item nav-link">Jasa Wisata</a>
                <a href="{{ route('front.info.index') }}" class="nav-item nav-link">Tentang</a>

            </div>
        </div>
    </nav>
</div>
