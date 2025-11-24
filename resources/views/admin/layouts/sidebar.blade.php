<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
        </a>


        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('admin/img/user.jpg') }}" alt=""
                    style="width: 40px; height: 40px;">
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ auth()->user()?->name ?? 'Admin' }}</h6>
                <span>{{ auth()->user()?->role ?? '' }}</span>
            </div>
        </div>

        <div class="navbar-nav w-100 text-xs">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-item nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i
                    class="fa fa-tachometer-alt me-2"></i>Dashboard</a>

            @if (auth()->check() && auth()->user()->role === 'super_admin')
                <a href="{{ route('users.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"><i
                        class="fa fa-users me-2"></i>Manajemen User</a>
            @endif

            {{-- MENU UTAMA: Manajemen Web --}}
            <a href="#menuWeb" class="nav-item nav-link {{ request()->is('admin/web-management*') ? 'active' : '' }}"
                data-bs-toggle="collapse"
                aria-expanded="{{ request()->is('admin/web-management*') ? 'true' : 'false' }}">
                <i class="fa fa-cog me-2"></i> Manajemen Web
            </a>

            <div class="collapse {{ request()->is('admin/web-management*') ? 'show' : '' }}" id="menuWeb">

                {{-- Informasi Daerah --}}
                <a href="{{ route('admin.web.informasi-daerah.edit') }}"
                    class="nav-item nav-link ms-4 {{ request()->routeIs('admin.web.informasi-daerah.*') ? 'active' : '' }}">
                    <i class="fa fa-info-circle me-2"></i> Informasi Daerah
                </a>

                {{-- Destinasi Wisata --}}
                <a href="{{ route('admin.web.destinasi.index') }}"
                    class="nav-item nav-link ms-4 {{ request()->routeIs('admin.web.destinasi.*') ? 'active' : '' }}">
                    <i class="fa fa-map-marked-alt me-2"></i> Destinasi Wisata
                </a>

                {{-- Akomodasi --}}
                <a href="{{ route('admin.web.akomodasi.index') }}"
                    class="nav-item nav-link ms-4 {{ request()->routeIs('admin.web.akomodasi.*') ? 'active' : '' }}">
                    <i class="fa fa-hotel me-2"></i> Akomodasi
                </a>

                {{-- Penyedia Jasa Menyelam --}}
                <a href="{{ route('admin.web.diving.index') }}"
                    class="nav-item nav-link ms-4 {{ request()->routeIs('admin.web.diving.*') ? 'active' : '' }}">
                    <i class="fa fa-swimmer me-2"></i> Jasa Wisata
                </a>

                {{-- Galeri Daerah --}}
                <a href="{{ route('admin.web.galeri.index') }}"
                    class="nav-item nav-link ms-4 {{ request()->routeIs('admin.web.galeri.*') ? 'active' : '' }}">
                    <i class="fa fa-camera me-2"></i> Galeri Daerah
                </a>
                {{-- Kontak Resmi --}}
                <a href="{{ route('admin.web.kontak.edit') }}"
                    class="nav-item nav-link ms-4 {{ request()->routeIs('admin.web.kontak.*') ? 'active' : '' }}">
                    <i class="fa fa-phone me-2"></i> Kontak Resmi
                </a>

                {{-- Pengaturan Halaman Depan --}}
                <a href="{{ route('admin.web.frontpage') }}"
                    class="nav-item nav-link ms-4 {{ request()->routeIs('admin.web.frontpage') ? 'active' : '' }}">
                    <i class="fa fa-paint-brush me-2"></i> Halaman Depan
                </a>


            </div>

            <!-- Tambah menu lain di sini -->
        </div>
    </nav>
</div>
