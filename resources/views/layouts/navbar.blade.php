<nav class="top-navbar">

    <!-- ===================== -->
    <!-- Judul Halaman -->
    <!-- ===================== -->
    <div class="navbar-left">
        <span class="navbar-title">
            {{-- Mengambil title dari masing-masing halaman --}}
            @yield('title', 'TitikTemu')
        </span>
    </div>

    <!-- ===================== -->
    <!-- Profil User -->
    <!-- ===================== -->
    <div class="navbar-profile">

        <!-- Avatar User (auto-generate dari UI Avatars) -->
        <img
            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? '') }}&background=2563eb&color=fff"
            alt="Profile"
            class="navbar-avatar"
        >

        <!-- Nama User -->
        <span class="navbar-username">
            {{ auth()->user()->name ?? '' }}
        </span>

    </div>

</nav>
