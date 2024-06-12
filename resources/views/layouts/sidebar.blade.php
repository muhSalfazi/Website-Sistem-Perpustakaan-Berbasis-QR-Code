<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <!-- Brand -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <div class="pt-4 mx-auto">
                <a href="#">
                    <img src="{{ asset('img/logo.png') }}" class="logo" style="width: 50px;">
                </a>
            </div>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Transaksi</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('peminjaman') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-arrows-exchange"></i>
                        </span>
                        <span class="hide-menu">Peminjaman</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('pengembalian') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-check"></i>
                        </span>
                        <span class="hide-menu">Pengembalian</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('denda') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-report-money"></i>
                        </span>
                        <span class="hide-menu">Penagihan Denda</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('history.transaksi') }}" aria-expanded="false">
                        <span>
                            <i class="bi bi-clock-history"></i>
                        </span>
                        <span class="hide-menu">History Transaksi</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Master</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('member') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">Anggota</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('books.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-book"></i>
                        </span>
                        <span class="hide-menu">Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('categories.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-category-2"></i>
                        </span>
                        <span class="hide-menu">Kategori</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('Rak.showdata') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-columns"></i>
                        </span>
                        <span class="hide-menu">Rak</span>
                    </a>
                </li>
                <!-- If user is superadmin -->
                {{-- <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Manajemen Akun</span>
                </li> --}}
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="/admin/users" aria-expanded="false">
                        <span>
                            <i class="ti ti-user-cog"></i>
                        </span>
                        <span class="hide-menu">Admin</span>
                    </a>
                </li> --}}
                <!-- End if -->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
