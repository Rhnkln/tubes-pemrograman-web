@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<!-- ===================== -->
<!-- Dashboard Container -->
<!-- ===================== -->
<div class="dashboard-container">

    <main class="main-content">

        <!-- ===================== -->
        <!-- Search Laporan -->
        <!-- ===================== -->
        <form
            method="GET"
            action="{{ route('dashboard') }}"
            class="dashboard-search"
        >
            <input
                type="text"
                name="search"
                class="search-bar"
                placeholder="Cari laporan..."
            >
        </form>

        <!-- ===================== -->
        <!-- Statistik Laporan -->
        <!-- ===================== -->
        <div class="card-group">

            <!-- Statistik Kehilangan -->
            <div class="stat-card">
                <div class="stat-number text-blue">
                    {{ $lostItemsCount }}
                </div>
                <div class="stat-label">
                    Laporan Kehilangan
                </div>
            </div>

            <!-- Statistik Penemuan -->
            <div class="stat-card">
                <div class="stat-number text-green">
                    {{ $foundItemsCount }}
                </div>
                <div class="stat-label">
                    Laporan Penemuan
                </div>
            </div>

            <!-- Statistik Total -->
            <div class="stat-card">
                <div class="stat-number text-indigo">
                    {{ $reportsCount }}
                </div>
                <div class="stat-label">
                    Total Laporan
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- Daftar Laporan Terbaru -->
        <!-- ===================== -->
        <div class="list-group">

            <!-- ===================== -->
            <!-- Laporan Kehilangan -->
            <!-- ===================== -->
            <div class="list-box">
                <div class="list-header">
                    <h3>Laporan Kehilangan Terbaru</h3>
                    <a
                        href="{{ route('lost-items') }}"
                        class="list-more"
                    >
                        Lihat semua
                    </a>
                </div>

                @forelse($recentLostItems as $item)
                    <div class="list-item">
                        <span class="item-name">
                            {{ $item->nama_barang }}
                        </span>
                        <a
                            href="{{ route('lost-items.show', $item) }}"
                            class="item-action"
                        >
                            Detail
                        </a>
                    </div>
                @empty
                    <div class="list-empty">
                        Belum ada laporan
                    </div>
                @endforelse
            </div>

            <!-- ===================== -->
            <!-- Laporan Penemuan -->
            <!-- ===================== -->
            <div class="list-box">
                <div class="list-header">
                    <h3>Laporan Penemuan Terbaru</h3>
                    <a
                        href="{{ route('found-items') }}"
                        class="list-more"
                    >
                        Lihat semua
                    </a>
                </div>

                @forelse($recentFoundItems as $item)
                    <div class="list-item">
                        <span class="item-name">
                            {{ $item->nama_barang }}
                        </span>
                        <a
                            href="{{ route('found-items.show', $item) }}"
                            class="item-action"
                        >
                            Detail
                        </a>
                    </div>
                @empty
                    <div class="list-empty">
                        Belum ada laporan
                    </div>
                @endforelse
            </div>

        </div>
    </main>
</div>

@endsection
