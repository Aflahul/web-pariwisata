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


        <div class="navbar-nav w-100">
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

            {{-- SUBMENU LEVEL 2 --}}
            <div class="collapse {{ request()->is('admin/web-management*') ? 'show' : '' }}" id="menuWeb">

                {{-- Data Halaman --}}
                <a href="{{ route('admin.web.index') }}"
                    class="nav-item nav-link ms-4 {{ request()->routeIs('admin.web.index') ? 'active' : '' }}">
                    <i class="fa fa-file-alt me-2"></i> Data Halaman
                </a>

                {{-- Banner / Slider --}}
                <a href="#"
                    class="nav-item nav-link ms-4 {{ request()->is('admin/web-management/banner*') ? 'active' : '' }}">
                    <i class="fa fa-images me-2"></i> Banner / Slider
                </a>

                {{-- Galeri Foto --}}
                <a href="#"
                    class="nav-item nav-link ms-4 {{ request()->is('admin/web-management/galeri*') ? 'active' : '' }}">
                    <i class="fa fa-camera me-2"></i> Galeri Foto
                </a>

                {{-- Destinasi Wisata --}}
                <a href="#"
                    class="nav-item nav-link ms-4 {{ request()->is('admin/web-management/destinasi*') ? 'active' : '' }}">
                    <i class="fa fa-map-marker-alt me-2"></i> Destinasi Wisata
                </a>

                {{-- Kontak Resmi --}}
                <a href="#"
                    class="nav-item nav-link ms-4 {{ request()->is('admin/web-management/kontak*') ? 'active' : '' }}">
                    <i class="fa fa-phone me-2"></i> Kontak Resmi
                </a>

            </div>


            <!-- Tambah menu lain di sini -->
        </div>
    </nav>
</div>
