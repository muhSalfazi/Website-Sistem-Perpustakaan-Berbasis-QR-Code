<!-- resources/views/layouts/header.blade.php -->
@include('layouts.head')
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                            class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a type="button" onclick="confirmLogout()"
                                    class="btn btn-outline-primary  btn-logout mx-3 mt-2 d-block">
                                    <i class="bi bi-box-arrow-in-left"> <span>Sign Out</span></i>

                                </a>
                            </form>

                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

