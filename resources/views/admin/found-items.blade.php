@extends('layouts.app')
@section('title', 'Kelola Barang Temuan')

@section('content')
<div class="admin-found-wrapper">

    <!-- ================= FILTER & SEARCH ================= -->
    <form method="GET" class="admin-filter-form">

        <!-- Input pencarian nama barang -->
        <input
            type="text"
            name="search"
            placeholder="Cari nama barang..."
            value="{{ request('search') }}"
            class="form-input"
        >

        <!-- Dropdown filter status -->
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="menunggu" @selected(request('status') == 'menunggu')>
                Menunggu
            </option>
            <option value="diklaim" @selected(request('status') == 'diklaim')>
                Diklaim
            </option>
            <option value="selesai" @selected(request('status') == 'selesai')>
                Selesai
            </option>
        </select>

        <!-- Tombol filter -->
        <button type="submit" class="btn btn-secondary">
            Filter
        </button>

    </form>

    <!-- ================= TABEL DATA BARANG TEMUAN ================= -->
    <div class="table-wrapper">
        <table class="admin-table">

            <!-- Header tabel -->
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <!-- Isi tabel -->
            <tbody>
                @foreach($items as $item)
                <tr>

                    <!-- Nama barang -->
                    <td>{{ $item->nama_barang }}</td>

                    <!-- Kategori barang -->
                    <td>{{ $item->category->name ?? '-' }}</td>

                    <!-- User pelapor -->
                    <td>{{ $item->user->name ?? '-' }}</td>

                    <!-- Status barang -->
                    <td class="status-text">
                        {{ ucfirst($item->status) }}
                    </td>

                    <!-- Kolom aksi -->
                    <td class="action-cell">

                        <!-- Form update status -->
                        <form
                            action="{{ route('admin.found-items.update-status', $item) }}"
                            method="POST"
                            class="inline-form"
                        >
                            @csrf
                            @method('PUT')

                            <!-- Dropdown ubah status -->
                            <select name="status" class="status-select">
                                <option value="menunggu" @selected($item->status == 'menunggu')>
                                    Menunggu
                                </option>
                                <option value="diklaim" @selected($item->status == 'diklaim')>
                                    Diklaim
                                </option>
                                <option value="selesai" @selected($item->status == 'selesai')>
                                    Selesai
                                </option>
                            </select>

                            <!-- Tombol update -->
                            <button type="submit" class="btn btn-link btn-update">
                                Update
                            </button>
                        </form>

                        <!-- Form hapus data -->
                        <form
                            action="{{ route('admin.found-items.destroy', $item) }}"
                            method="POST"
                            class="inline-form"
                            onsubmit="return confirm('Yakin ingin menghapus?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-link btn-danger">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <!-- ================= PAGINATION ================= -->
    <div class="pagination-wrapper">
        {{ $items->links() }}
    </div>

</div>
@endsection
