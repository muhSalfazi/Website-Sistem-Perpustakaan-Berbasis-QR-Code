<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Your Default Title')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logoTitle.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/assets/css/styles.min.css') }}" />
    @stack('head')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

</head>
<style>
    .btn-logout:hover {
        background-color: #c82333;
        color: #fff;
    }

    /* Gaya Umum Sidebar */
    /* Gaya Umum Sidebar */
    .left-sidebar {
        color: black;
        /* Adjust text color for better contrast */
        width: 270px;
        height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: none;
        -ms-overflow-style: none;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        transition: transform 0.3s ease;
        background-color: white;
        /* Set background color to white */
    }

    .left-sidebar::-webkit-scrollbar {
        display: none;
    }

    .menggulung .left-sidebar {
        scrollbar-width: thin;
    }

    .menggulung .left-sidebar::-webkit-scrollbar {
        display: block;
        width: 8px;
        background-color: #f9f9f9;
    }

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
        color: black;
        /* Adjust text color for better contrast */
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .sidebar-link:hover {
        background: rgba(0, 0, 0, 0.1);
        /* Adjust hover background color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
    }

    .sidebar-link .ti {
        margin-right: 10px;
        font-size: 18px;
    }

    /* Sidebar Hidden State */
    .sidebar-hidden {
        transform: translateX(-100%);
    }

    /* Toggle Button */
    .toggle-btn {
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1000;
        cursor: pointer;
        background-color: #f9f9f9;
        border-radius: 50%;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .toggle-btn:hover {
        background-color: #e0e0e0;
    }

    .toggle-btn .ti {
        font-size: 24px;
    }

    /* Close Button */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        background-color: #f9f9f9;
        border-radius: 50%;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .close-btn:hover {
        background-color: #e0e0e0;
    }

    .close-btn .ti {
        font-size: 24px;
    }

    /* Media Query for Small Screens */
    @media (max-width: 768px) {
        .left-sidebar {
            transform: translateX(-100%);
        }

        .left-sidebar.sidebar-visible {
            transform: translateX(0);
        }

        .toggle-btn {
            display: flex;
        }
    }

    @media (min-width: 769px) {
        .left-sidebar {
            transform: translateX(0);
        }

        .toggle-btn {
            display: none;
        }
    }
</style>
