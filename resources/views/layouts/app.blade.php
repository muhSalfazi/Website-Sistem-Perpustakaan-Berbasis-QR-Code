<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('layouts.sidebar')

        <div class="body-wrapper">
            @include('layouts.header')

            <div class="container-fluid">
                @yield('content')
            </div>

            @include('layouts.footer')
        </div>
    </div>
</body>

</html>
