<!DOCTYPE html>
<html lang="id">
<head>

    <!-- ===================== -->
    <!-- Meta & Title -->
    <!-- ===================== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TitikTemu') }}</title>

    <!-- ===================== -->
    <!-- Main CSS -->
    <!-- ===================== -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- ===================== -->
    <!-- Main JavaScript -->
    <!-- ===================== -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Tambahan head dari halaman lain -->
    @yield('head')

</head>
<body>

    <!-- ===================== -->
    <!-- App Layout Wrapper -->
    <!-- ===================== -->
    <div id="app-layout">

        <!-- ===================== -->
        <!-- Sidebar -->
        <!-- Tidak ditampilkan di halaman login & register -->
        <!-- ===================== -->
        @if (!in_array(Route::currentRouteName(), ['login', 'register']))
            @include('layouts.sidebar')
        @endif

        <!-- ===================== -->
        <!-- Main Content Wrapper -->
        <!-- ===================== -->
        <main
            class="main-wrapper
                @if (!in_array(Route::currentRouteName(), ['login', 'register']))
                    with-sidebar
                @endif
            "
        >

            <!-- ===================== -->
            <!-- Top Navbar -->
            <!-- Tidak ditampilkan di halaman login & register -->
            <!-- ===================== -->
            @if (!in_array(Route::currentRouteName(), ['login', 'register']))
                @include('layouts.navbar')
            @endif

            <!-- ===================== -->
            <!-- Page Content -->
            <!-- ===================== -->
            <section class="page-content">
                @yield('content')
            </section>

        </main>

    </div>

    <!-- ===================== -->
    <!-- Tambahan Script per Halaman -->
    <!-- ===================== -->
    @yield('scripts')

</body>
</html>
