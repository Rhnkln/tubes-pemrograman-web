@extends('layouts.app')
@section('title', 'Laporan Penemuan')

@section('content')

<!-- ===================== -->
<!-- Header Halaman -->
<!-- ===================== -->
<div class="page-header">
    <h2 class="page-title">Laporan Penemuan</h2>

    <!-- Tombol Buat Laporan -->
    <a href="{{ route('found-items.create') }}" class="btn btn-success">
        Buat Laporan
    </a>
</div>

<!-- ===================== -->
<!-- Form Filter Pencarian -->
<!-- ===================== -->
<form method="GET" class="filter-form">

    <!-- Pencarian Nama Barang -->
    <input
        type="text"
        name="search"
        placeholder="Cari barang..."
        value="{{ request('search') }}"
        class="form-input"
    >

    <!-- Filter Kategori -->
    <select name="category" class="form-input">
        <option value="">Semua Kategori</option>

        @foreach($categories as $cat)
            <option
                value="{{ $cat->id }}"
                @selected(request('category') == $cat->id)
            >
                {{ $cat->name }}
            </option>
        @endforeach
    </select>

    <!-- Filter Lokasi Ditemukan -->
    <input
        type="text"
        name="location"
        placeholder="Lokasi ditemukan"
        value="{{ request('location') }}"
        class="form-input"
    >

    <!-- Filter Tanggal Dari -->
    <input
        type="date"
        name="date_from"
        value="{{ request('date_from') }}"
        class="form-input"
    >

    <!-- Filter Tanggal Sampai -->
    <input
        type="date"
        name="date_to"
        value="{{ request('date_to') }}"
        class="form-input"
    >

    <!-- Aksi Filter -->
    <div class="filter-actions">

        <!-- Tombol Terapkan Filter -->
        <button type="submit" class="btn btn-light">
            Filter
        </button>

        <!-- Tombol Reset Filter -->
        <a href="{{ route('found-items') }}" class="btn btn-outline">
            Reset
        </a>
    </div>

</form>

<!-- ===================== -->
<!-- Daftar Barang Ditemukan -->
<!-- ===================== -->
<div class="card-grid">

    @forelse($foundItems as $item)
        <div class="item-card">

            <!-- Foto Barang -->
            <img
                src="{{ $item->foto_barang
                        ? asset('storage/' . $item->foto_barang)
                        : 'https://via.placeholder.com/300x200' }}"
                class="item-image"
                alt="Foto Barang"
            >

            <!-- Nama Barang -->
            <div class="item-title">
                {{ $item->nama_barang }}
            </div>

            <!-- Kategori -->
            <div class="item-category">
                {{ $item->category->name ?? '-' }}
            </div>

            <!-- Lokasi Ditemukan -->
            <div class="item-meta">
                {{ $item->lokasi_ditemukan }}
            </div>

            <!-- Tanggal Ditemukan -->
            <div class="item-meta">
                {{ $item->tanggal_ditemukan->format('d M Y') }}
            </div>

            <!-- Link Detail -->
            <a
                href="{{ route('found-items.show', $item) }}"
                class="item-link"
            >
                Detail
            </a>

        </div>
    @empty
        <!-- Jika Data Kosong -->
        <div class="empty-state">
            Tidak ada laporan ditemukan.
        </div>
    @endforelse

</div>

<!-- ===================== -->
<!-- Pagination -->
<!-- ===================== -->
<div class="pagination-wrapper">
    {{ $foundItems->links() }}
</div>

@endsection
