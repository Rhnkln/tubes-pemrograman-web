@extends('layouts.app')
@section('title', 'Detail Penemuan')

@section('content')
<div class="card card-lg detail-layout">

    <!-- ===================== -->
    <!-- KIRI : GAMBAR BARANG -->
    <!-- ===================== -->
    <div class="detail-left">
        <img
            src="{{ $item->foto_barang 
                    ? asset('storage/' . $item->foto_barang) 
                    : 'https://via.placeholder.com/400x300' }}"
            class="detail-image"
            alt="Foto Barang"
        >
    </div>

    <!-- ===================== -->
    <!-- KANAN : DETAIL BARANG -->
    <!-- ===================== -->
    <div class="detail-right">

        <!-- Nama Barang -->
        <h2 class="card-title">{{ $item->nama_barang }}</h2>

        <!-- Kategori -->
        <div class="card-field">
            <span class="field-label">Kategori</span>
            <span class="field-value">{{ $item->category->name ?? '-' }}</span>
        </div>

        <!-- Deskripsi -->
        <div class="card-field">
            <span class="field-label">Deskripsi</span>
            <span class="field-value">{{ $item->deskripsi }}</span>
        </div>

        <!-- Lokasi Ditemukan -->
        <div class="card-field">
            <span class="field-label">Lokasi Ditemukan</span>
            <span class="field-value">{{ $item->lokasi_ditemukan }}</span>
        </div>

        <!-- Tanggal Ditemukan -->
        <div class="card-field">
            <span class="field-label">Tanggal Ditemukan</span>
            <span class="field-value">
                {{ $item->tanggal_ditemukan->format('d M Y') }}
            </span>
        </div>

        <!-- Status Barang -->
        <div class="card-field">
            <span class="field-label">Status</span>
            <span class="status status-{{ $item->status }}">
                {{ ucfirst($item->status) }}
            </span>
        </div>

        <!-- Penemu -->
        <div class="card-field">
            <span class="field-label">Penemu</span>
            <span class="field-value">{{ $item->user->name ?? '-' }}</span>
        </div>

        <!-- ===================== -->
        <!-- Kontak Penemu (WhatsApp) -->
        <!-- ===================== -->
        @if(!empty($item->kontak_penemu))
            @php
                // Ambil hanya angka dari nomor
                $rawNumber = $item->kontak_penemu;
                $number = preg_replace('/[^0-9]/', '', $rawNumber);

                // Ubah format 08xx menjadi 62xx
                if(substr($number, 0, 1) === '0') {
                    $number = '62' . substr($number, 1);
                }
            @endphp

            <div class="card-field">
                <span class="field-label">Kontak Penemu</span>
                <div style="margin-top:0.5rem">
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

        <!-- ===================== -->
        <!-- Aksi Pemilik Laporan -->
        <!-- ===================== -->
        {{-- Ditampilkan hanya jika user login adalah pemilik laporan --}}
        @if($item->user_id === auth()->id())
            <div class="card-actions mt-3">

                <!-- Form Update Status -->
                <form action="{{ route('found-items.updateStatus', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-2">
                        <label for="status" class="form-label">Ubah Status:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>
                            <option value="diklaim" {{ $item->status == 'diklaim' ? 'selected' : '' }}>
                                Diklaim
                            </option>
                            <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update Status
                    </button>
                </form>

                <!-- Tombol Hapus Laporan -->
                <form 
                    action="{{ route('found-items.destroy', $item->id) }}" 
                    method="POST"
                    class="mt-2"
                    onsubmit="return confirm('Yakin ingin menghapus laporan ini?')"
                >
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        Hapus
                    </button>
                </form>

            </div>
        @endif

    </div>
</div>
@endsection
