@extends('layouts.app')
@section('title', 'Daftar Barang Hilang')

@section('content')
@foreach($items as $item)
<div class="card card-lg detail-layout">

    <!-- ===================== -->
    <!-- KIRI: Gambar Barang -->
    <!-- ===================== -->
    <div class="detail-left">
        <img
            src="{{ $item->foto_barang ? asset('storage/' . $item->foto_barang) : 'https://via.placeholder.com/400x300' }}"
            class="detail-image"
            alt="Foto Barang"
        >
    </div>

    <!-- ===================== -->
    <!-- KANAN: Informasi Barang -->
    <!-- ===================== -->
    <div class="detail-right">

        <!-- Nama Barang -->
        <h2 class="card-title">
            {{ $item->nama_barang }}
        </h2>

        <!-- Kategori -->
        <div class="card-field">
            <span class="field-label">Kategori</span>
            <span class="field-value">
                {{ $item->category->name ?? '-' }}
            </span>
        </div>

        <!-- Deskripsi -->
        <div class="card-field">
            <span class="field-label">Deskripsi</span>
            <span class="field-value">
                {{ $item->deskripsi }}
            </span>
        </div>

        <!-- Lokasi Terakhir -->
        <div class="card-field">
            <span class="field-label">Lokasi Terakhir</span>
            <span class="field-value">
                {{ $item->lokasi_terakhir }}
            </span>
        </div>

        <!-- Status -->
        <div class="card-field">
            <span class="field-label">Status</span>
            <span class="status status-{{ $item->status }}">
                {{ ucfirst($item->status) }}
            </span>
        </div>

        <!-- Lihat Detail -->
        <div class="card-actions mt-2">
            <a href="{{ route('admin.showLostItem', $item->id) }}" class="btn btn-primary btn-sm">
                Lihat Detail
            </a>
        </div>

    </div>
</div>
@endforeach

<!-- Pagination -->
<div class="mt-4">
    {{ $items->links() }}
</div>
@endsection
