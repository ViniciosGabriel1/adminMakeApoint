<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/scss/app.scss')

    <link rel="stylesheet" href="../../dist/css/adminlte.css" />
    <!-- Para favicon .ico -->
    <link rel="icon" href="{{ Vite::asset('resources/images/favzada.jpg') }}" type="image/x-icon">

    <!-- Ou para favicon .png -->
    {{-- <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png"> --}}

</head>
<!--end::Head-->
<!--begin::Body-->



<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div x-data="{ loading: true }" x-init="loading = false" x-show="loading" x-cloak
        class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>

    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        @include('parts.header')

        @include('parts.sidebar')

        <main class="app-main">

            @include('parts.content-header')

            <div class="app-content">
                <div class="container-fluid">
                  
                    @yield('content')
                    {{-- {{ $slot }} --}}

                </div>
            </div>
        </main>

        @include('parts.footer')
    </div>


    @vite('resources/js/app.js')
    <!--end::Script-->
</body>
<!--end::Body-->

</html>
