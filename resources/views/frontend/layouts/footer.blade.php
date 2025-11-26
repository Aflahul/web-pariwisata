<footer class="container-fluid footer py-5">
    <div class="container py-5">
        <div class="row g-5">

            {{-- LOGO --}}
            <div class="col-md-6 col-lg-3 text-center flex text-lg-start">
                @if (isset($fp) && $fp->logo)
                    <img src="{{ image_path($fp->logo) }}" alt="Logo Kab" style="height: 80px; width:auto;">
                    <img src="{{ image_path($fp->favicon) }}" alt="Logo Dinas" style="height: 90px; width:auto;">
                @endif
            </div>

            {{-- KONTAK (pindah ke tengah) --}}
            <div class="col-md-6 col-lg-5">
                <h4 class="text-secondary mb-4">Kontak</h4>

                @php $kontak = \App\Models\KontakResmi::first(); @endphp

                @if ($kontak)
                    @if ($kontak->alamat)
                        <p class="text-white mb-2">
                            <i class="fa fa-map-marker-alt me-2"></i>
                            {{ $kontak->alamat }}
                        </p>
                    @endif

                    @if ($kontak->email)
                        <p class="text-white mb-2">
                            <i class="fa fa-envelope me-2"></i>
                            {{ $kontak->email }}
                        </p>
                    @endif

                    @if ($kontak->telepon)
                        <p class="text-white mb-0">
                            <i class="fa fa-phone me-2"></i>
                            {{ $kontak->telepon }}
                        </p>
                    @endif
                @endif
            </div>

            {{-- SOSIAL MEDIA --}}
            <div class="col-md-6 col-lg-4">
                <h4 class="text-secondary mb-4">Sosial Media</h4>

                @if ($kontak)
                    @if ($kontak->facebook)
                        <a href="{{ $kontak->facebook }}" class="btn mx-1 text-white">
                            <i class="fab fa-facebook"></i>
                        </a>
                    @endif

                    @if ($kontak->instagram)
                        <a href="{{ $kontak->instagram }}" class="btn mx-1 text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif

                    @if ($kontak->youtube)
                        <a href="{{ $kontak->youtube }}" class="btn mx-1 text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif

                    @if ($kontak->tiktok)
                        <a href="{{ $kontak->tiktok }}" class="btn mx-1 text-white">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    @endif
                @endif
            </div>

        </div>
    </div>
</footer>
{{-- STRIP MERAH BAWAH (Enhanced Version) --}}
<div class="container-fluid py-3 bg-secondary">

    <div
        class="container d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">

        {{-- COPYRIGHT --}}
        <span class="text-white fw-semibold" style="letter-spacing: 0.5px;">
            © {{ date('Y') }} Dinas Kebudayaan dan Pariwisata Kabupaten Supiori. All Rights Reserved.
        </span>

        {{-- CREDIT --}}
        {{-- <span class="text-white fw-semibold mt-2 mt-md-0" style="letter-spacing: 0.5px;">
            Designed & Developed by
            <span class="fw-bold" style="color: #ffebee;">Aflahul Mukmin</span>
        </span> --}}

    </div>
</div>

</div>
