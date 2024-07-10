<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; img-src 'self' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://stackpath.bootstrapcdn.com; script-src 'self' 'unsafe-inline' https://code.jquery.com https://stackpath.bootstrapcdn.com;">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <title>Header</title>

    <style>
        .app-header {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #333;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: #0056b3;
        }

        .navbar-nav .nav-icon-hover {
            position: relative;
            padding: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .nav-icon-hover:hover {
            transform: scale(1.1);
        }

        .nav-icon-hover::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: #0056b3;
            transition: width 0.3s ease, left 0.3s ease;
        }

        .nav-icon-hover:hover::after {
            width: 100%;
            left: 0;
        }

        .profile-icon {
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .profile-icon:hover {
            transform: scale(1.1);
        }

        .profile-image {
            border: 2px solid #333;
            transition: border-color 0.3s ease;
        }

        .profile-image:hover {
            border-color: #0056b3;
        }

        .btn-animated {
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-animated::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%) rotate(45deg);
            transition: width 0.5s ease, height 0.5s ease;
        }

        .btn-animated:hover::before {
            width: 0;
            height: 0;
        }

        .btn-animated:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .dropdown-menu-animate-up {
            animation: fadeInUp 0.3s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <header class="app-header animate__animated animate__fadeInDown">
        <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <!-- Uncomment this section if notifications are needed -->
                <!--
                <li class="nav-item">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                        <i class="ti ti-bell-ringing"></i>
                        <div class="notification bg-primary rounded-circle"></div>
                    </a>
                </li>
                -->
            </ul>
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                    <!-- Uncomment this line if you want to include the download button -->
                    <!--
                    <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary btn-animated">Download Free</a>
                    -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon-hover profile-icon" href="javascript:void(0)" id="drop2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../assets/images/profile/user-1.jpg" alt="User Profile" width="35"
                                height="35" class="rounded-circle profile-image">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                            <div class="message-body">
                                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="button" onclick="confirmLogout()"
                                        class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    {{-- <script>
    function confirmLogout() {
        if (confirm('Are you sure you want to log out?')) {
            document.getElementById('logout-form').submit();
        }
    }
    </script> --}}
</body>

</html>
