@extends('layouts.app')
@section('title', 'Kelola Kategori')

@section('content')
<div class="category-wrapper">

    <!-- ================= JUDUL HALAMAN ================= -->
    <h2 class="category-title">
        Kategori Barang
    </h2>

    <!-- ================= FORM TAMBAH KATEGORI ================= -->
    <form
        method="POST"
        action="{{ route('admin.categories.store') }}"
        class="category-form"
    >
        @csrf

        <!-- Input Nama Kategori -->
        <input
            type="text"
            name="name"
            placeholder="Nama Kategori"
            class="form-input"
            required
        >

        <!-- Input Slug Kategori -->
        <input
            type="text"
            name="slug"
            placeholder="Slug"
            class="form-input"
            required
        >

        <!-- Input Icon (Opsional) -->
        <input
            type="text"
            name="icon"
            placeholder="Icon (opsional)"
            class="form-input"
        >

        <!-- Tombol Submit -->
        <button
            type="submit"
            class="btn btn-primary"
        >
            Tambah
        </button>
    </form>

    <!-- ================= TABEL DAFTAR KATEGORI ================= -->
    <div class="table-wrapper">
        <table class="category-table">

            <!-- Header Tabel -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Icon</th>
                    <th>Barang Hilang</th>
                    <th>Barang Temuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <!-- Body Tabel -->
            <tbody>
                @foreach($categories as $cat)
                <tr>

                    <!-- Nama Kategori -->
                    <td>{{ $cat->name }}</td>

                    <!-- Slug Kategori -->
                    <td>{{ $cat->slug }}</td>

                    <!-- Icon Kategori -->
                    <td>{{ $cat->icon }}</td>

                    <!-- Jumlah Barang Hilang -->
                    <td class="text-center">
                        {{ $cat->lost_items_count }}
                    </td>

                    <!-- Jumlah Barang Temuan -->
                    <td class="text-center">
                        {{ $cat->found_items_count }}
                    </td>

                    <!-- Aksi -->
                    <td>
                        <form
                            action="{{ route('admin.categories.destroy', $cat) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <!-- Tombol Hapus -->
                            <button
                                type="submit"
                                class="btn btn-danger btn-link"
                            >
                                Hapus
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection
