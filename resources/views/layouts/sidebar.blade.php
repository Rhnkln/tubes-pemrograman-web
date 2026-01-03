<aside class="sidebar">

    <!-- ===================== -->
    <!-- Header Sidebar -->
    <!-- ===================== -->
    <div class="sidebar-header">
        <span class="sidebar-logo">
            TitikTemu
        </span>
    </div>

    <!-- ===================== -->
    <!-- Navigasi Sidebar -->
    <!-- ===================== -->
    <nav class="sidebar-nav">
        <ul class="sidebar-menu">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" class="menu-btn">
                    Dashboard
                </a>
            </li>

            <!-- Laporan Kehilangan -->
            <li>
                <a href="{{ route('lost-items') }}" class="menu-btn">
                    Laporan Kehilangan
                </a>
            </li>

            <!-- Laporan Penemuan -->
            <li>
                <a href="{{ route('found-items') }}" class="menu-btn">
                    Laporan Penemuan
                </a>
            </li>

            <!-- ===================== -->
            <!-- Menu Profil User -->
            <!-- Ditampilkan jika user login dan bukan admin -->
            <!-- ===================== -->
            @auth
                @if(auth()->user()->role->name !== 'admin')
                    <li>
                        <a href="{{ route('profile') }}" class="menu-btn">
                            Profil Saya
                        </a>
                    </li>
                @endif
            @endauth

            <!-- ===================== -->
            <!-- Admin Panel -->
            <!-- Ditampilkan khusus untuk admin -->
            <!-- ===================== -->
            @if(auth()->check() && auth()->user()->isAdmin())
                <li class="sidebar-admin">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="menu-btn admin-btn"
                    >
                        Admin Panel
                    </a>
                </li>
            @endif

            <!-- ===================== -->
            <!-- Logout -->
            <!-- ===================== -->
            @auth
                <li class="sidebar-logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="menu-btn logout-btn">
                            Logout
                        </button>
                    </form>
                </li>
            @endauth

        </ul>
    </nav>
</aside>
