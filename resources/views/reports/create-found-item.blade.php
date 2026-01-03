@extends('layouts.app')
@section('title', 'Buat Laporan Penemuan')

@section('content')

<div class="form-card form-card-md">

    <!-- ===================== -->
    <!-- Judul Form -->
    <!-- ===================== -->
    <h2 class="form-title text-center">
        Buat Laporan Penemuan
    </h2>

    <!-- ===================== -->
    <!-- Form Laporan Penemuan -->
    <!-- ===================== -->
    <form
        method="POST"
        action="{{ route('found-items.store') }}"
        enctype="multipart/form-data"
        class="form-wrapper"
    >
        @csrf

        <!-- ===================== -->
        <!-- Nama Barang -->
        <!-- ===================== -->
        <div class="form-group">
            <label for="nama_barang" class="form-label">
                Nama Barang
            </label>

            <input
                type="text"
                name="nama_barang"
                id="nama_barang"
                class="form-input"
                required
                value="{{ old('nama_barang') }}"
            >

            @error('nama_barang')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- ===================== -->
        <!-- Kategori Barang -->
        <!-- ===================== -->
        <div class="form-group">
            <label for="category_id" class="form-label">
                Kategori
            </label>

            <select
                name="category_id"
                id="category_id"
                class="form-input"
                required
            >
                <option value="">Pilih Kategori</option>

                @foreach($categories as $cat)
                    <option
                        value="{{ $cat->id }}"
                        @selected(old('category_id') == $cat->id)
                    >
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            @error('category_id')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- ===================== -->
        <!-- Deskripsi Barang -->
        <!-- ===================== -->
        <div class="form-group">
            <label for="deskripsi" class="form-label">
                Deskripsi
            </label>

            <textarea
                name="deskripsi"
                id="deskripsi"
                class="form-textarea"
                required
            >{{ old('deskripsi') }}</textarea>

            @error('deskripsi')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- ===================== -->
        <!-- Lokasi Ditemukan -->
        <!-- ===================== -->
        <div class="form-group">
            <label for="lokasi_ditemukan" class="form-label">
                Lokasi Ditemukan
            </label>

            <input
                type="text"
                name="lokasi_ditemukan"
                id="lokasi_ditemukan"
                class="form-input"
                required
                value="{{ old('lokasi_ditemukan') }}"
            >

            @error('lokasi_ditemukan')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- ===================== -->
        <!-- Tanggal Ditemukan -->
        <!-- ===================== -->
        <div class="form-group">
            <label for="tanggal_ditemukan" class="form-label">
                Tanggal Ditemukan
            </label>

            <input
                type="date"
                name="tanggal_ditemukan"
                id="tanggal_ditemukan"
                class="form-input"
                required
                value="{{ old('tanggal_ditemukan') }}"
            >

            @error('tanggal_ditemukan')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- ===================== -->
        <!-- Kontak Penemu -->
        <!-- ===================== -->
        <div class="form-group">
            <label for="kontak_penemu" class="form-label">
                Kontak Penemu
            </label>

            <input
                type="text"
                name="kontak_penemu"
                id="kontak_penemu"
                class="form-input"
                required
                value="{{ old('kontak_penemu') }}"
            >

            @error('kontak_penemu')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- ===================== -->
        <!-- Upload Foto Barang -->
        <!-- ===================== -->
        <div class="form-group">
            <label for="foto_barang" class="form-label">
                Foto Barang
                <span class="text-muted">(opsional)</span>
            </label>

            <input
                type="file"
                name="foto_barang"
                id="foto_barang"
                class="form-input"
            >

            @error('foto_barang')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- ===================== -->
        <!-- Tombol Submit -->
        <!-- ===================== -->
        <button type="submit" class="btn btn-success btn-block">
            Kirim Laporan
        </button>

    </form>
</div>

@endsection
