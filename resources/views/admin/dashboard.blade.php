@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard">

    <!-- ================= STATISTIK DASHBOARD ================= -->
    <div class="admin-stats">

        <!-- Total User -->
        <div class="stat-card">
            <span class="stat-number stat-blue">
                {{ $totalUsers }}
            </span>
            <span class="stat-label">
                Total User
            </span>
        </div>

        <!-- Total Barang Hilang -->
        <div class="stat-card">
            <span class="stat-number stat-yellow">
                {{ $totalLostItems }}
            </span>
            <span class="stat-label">
                Barang Hilang
            </span>
        </div>

        <!-- Total Barang Temuan -->
        <div class="stat-card">
            <span class="stat-number stat-green">
                {{ $totalFoundItems }}
            </span>
            <span class="stat-label">
                Barang Temuan
            </span>
        </div>

        <!-- Total Seluruh Laporan -->
        <div class="stat-card">
            <span class="stat-number stat-indigo">
                {{ $totalReports }}
            </span>
            <span class="stat-label">
                Total Laporan
            </span>
        </div>

    </div>

    <!-- ================= LAPORAN PENDING ================= -->
    <div class="pending-card">

        <!-- Judul & jumlah laporan pending -->
        <h3 class="pending-title">
            Laporan Pending:
            <span class="pending-count">
                {{ $pendingReports }}
            </span>
        </h3>

        <!-- Link menuju halaman laporan pending -->
        <a
            href="{{ route('admin.reports', ['status' => 'pending']) }}"
            class="pending-link"
        >
            Lihat Laporan Pending
        </a>

    </div>

</div>
@endsection
