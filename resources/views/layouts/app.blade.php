<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Anggota Baru</title>
</head>

<body>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.sidebar')
        <!-- Sidebar End -->

        <!-- Main Wrapper Start -->
        <div class="body-wrapper">
            <!-- Header Start -->
            @include('layouts.header')
            <!-- Header End -->

            <!-- Main Content Start -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- Main Content End -->

            <!-- Footer Start -->
            @include('layouts.footer')
            <!-- Footer End -->
        </div>
        <!-- Main Wrapper End -->
    </div>
</body>

</html>
