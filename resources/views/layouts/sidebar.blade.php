<style>
  .menggulung .left-sidebar::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
        border-radius: 10px;
    }

    .sidebar-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sidebar-nav {
        flex: 1;
        padding: 50px 0;
    }

    .sidebar-item {
        position: relative;
        padding: 5px 15px;
        margin: 5px 0;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 4px;
        transition: all 0.3s;
    }


.sidebar-link:hover {
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
    }
    
    .sidebar-link .ti {
        margin-right: 10px;
        font-size: 18px;
    }


</style>

<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <!-- Brand -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <div class="pt-4 mx-auto">
                    <img src="{{ asset('img/logo.png') }}" class="logo" style="width: 50px;">
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
                    <a class="sidebar-link" href="{{ route('categories.index')}}" aria-expanded="false">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Add animate.css classes for opening the sidebar
        $('#sidebarCollapse').on('click', function () {
            if ($('.left-sidebar').hasClass('animate__fadeInLeft')) {
                $('.left-sidebar').removeClass('animate__fadeInLeft').addClass('animate__fadeOutLeft');
            } else {
                $('.left-sidebar').removeClass('animate__fadeOutLeft').addClass('animate__fadeInLeft');
            }
        });

        // Automatically add animation class for sidebar items
        $('.sidebar-item').each(function (index) {
            $(this).addClass('animate__animated animate__fadeInLeft');
            $(this).css('animation-delay', (index * 0.2) + 's');
        });
    });
</script>

