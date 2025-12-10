<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">

    <a href="#" class="sidebar-toggler flex-shrink-0 me-3">
        <i class="fa fa-bars"></i>
    </a>

    <h5 class="text-primary mb-0 admin-title flex-grow-1">
        Dinas Kebudayaan dan Pariwisata Kabupaten Supiori
    </h5>

    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">

                <img class="rounded-circle me-lg-2" src="{{ asset('admin/img/admin-default-avatar.png') }}" alt="avatar"
                    style="width: 40px; height: 40px;">

                <span class="d-none d-lg-inline-flex">
                    {{ auth()->user()?->name ?? 'Admin' }}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="dropdown-item">Logout</button>
                </form>
            </div>
        </div>
    </div>

</nav>
