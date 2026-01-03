@extends('layouts.app')
@section('title', 'Detail Kehilangan')

@section('content')

<div class="card card-lg detail-layout">

    {{-- =========================
        BAGIAN KIRI : FOTO BARANG
    ========================== --}}
    <div class="detail-left">
        <img
            src="{{ $item->foto_barang
                ? asset('storage/' . $item->foto_barang)
                : 'https://via.placeholder.com/400x300' }}"
            class="detail-image"
            alt="Foto Barang Kehilangan"
        >
    </div>

    {{-- =========================
        BAGIAN KANAN : DETAIL DATA
    ========================== --}}
    <div class="detail-right">

        {{-- Nama Barang --}}
        <h2 class="card-title">{{ $item->nama_barang }}</h2>

        {{-- Kategori --}}
        <div class="card-field">
            <span class="field-label">Kategori</span>
            <span class="field-value">
                {{ $item->category->name ?? '-' }}
            </span>
        </div>

        {{-- Deskripsi --}}
        <div class="card-field">
            <span class="field-label">Deskripsi</span>
            <span class="field-value">{{ $item->deskripsi }}</span>
        </div>

        {{-- Lokasi Terakhir --}}
        <div class="card-field">
            <span class="field-label">Lokasi Terakhir</span>
            <span class="field-value">{{ $item->lokasi_terakhir }}</span>
        </div>

        {{-- Tanggal Hilang --}}
        <div class="card-field">
            <span class="field-label">Tanggal Hilang</span>
            <span class="field-value">
                {{ $item->tanggal_hilang->format('d M Y') }}
            </span>
        </div>

        {{-- Status Barang --}}
        <div class="card-field">
            <span class="field-label">Status</span>
            <span class="status status-{{ $item->status }}">
                {{ ucfirst($item->status) }}
            </span>
        </div>

        {{-- Nama Pelapor --}}
        <div class="card-field">
            <span class="field-label">Pelapor</span>
            <span class="field-value">
                {{ $item->user->name ?? '-' }}
            </span>
        </div>

        {{-- =========================
            KONTAK PELAPOR (WHATSAPP)
        ========================== --}}
        @if($item->user && !empty($item->user->phone))
            @php
                // Ambil hanya angka
                $number = preg_replace('/[^0-9]/', '', $item->user->phone);

                // Ubah 08xxx -> 628xxx
                if (str_starts_with($number, '0')) {
                    $number = '62' . substr($number, 1);
                }
            @endphp

            <div class="card-field">
                <span class="field-label">Kontak Pelapor</span>
                <div class="mt-2">
                    <a
                        href="https://wa.me/{{ $number }}"
                        target="_blank"
                        class="btn btn-success btn-sm"
                    >
                        WhatsApp
                    </a>
                </div>
            </div>
        @endif

        {{-- =========================
            AKSI (KHUSUS PEMILIK)
        ========================== --}}
        @if($item->user_id === auth()->id())
            <div class="card-actions mt-4">

                {{-- FORM UPDATE STATUS --}}
                <form
                    action="{{ route('lost-items.updateStatus', $item->id) }}"
                    method="POST"
                    class="mb-3"
                >
                    @csrf
                    @method('PATCH')

                    <label for="status" class="form-label">
                        Ubah Status
                    </label>

                    <select name="status" id="status" class="form-select">
                        <option value="hilang" {{ $item->status === 'hilang' ? 'selected' : '' }}>
                            Hilang
                        </option>
                        <option value="ditemukan" {{ $item->status === 'ditemukan' ? 'selected' : '' }}>
                            Ditemukan
                        </option>
                        <option value="selesai" {{ $item->status === 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                    </select>

                    <button type="submit" class="btn btn-primary mt-2">
                        Update Status
                    </button>
                </form>

                {{-- FORM HAPUS LAPORAN --}}
                <form
                    action="{{ route('lost-items.destroy', $item) }}"
                    method="POST"
                    class="mt-2"
                    onsubmit="return confirm('Yakin ingin menghapus laporan ini?')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Hapus
                    </button>
                </form>

            </div>
        @endif

    </div>
</div>

@endsection
