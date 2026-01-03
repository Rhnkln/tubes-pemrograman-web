@extends('layouts.app')
@section('title', 'Kelola Laporan')

@section('content')
<div class="admin-report-wrapper">

    <!-- ===================== -->
    <!-- Filter Laporan -->
    <!-- ===================== -->
    <form method="GET" class="admin-filter-form">

        <!-- Filter Status -->
        <select name="status" class="form-select">
            <option value="">Semua Status</option>

            {{-- STATUS KEHILANGAN --}}
            <option value="hilang" @selected(request('status') == 'hilang')>
                Hilang
            </option>
            <option value="ditemukan" @selected(request('status') == 'ditemukan')>
                Ditemukan
            </option>

            {{-- STATUS PENEMUAN --}}
            <option value="menunggu" @selected(request('status') == 'menunggu')>
                Menunggu
            </option>
            <option value="diklaim" @selected(request('status') == 'diklaim')>
                Diklaim
            </option>

            {{-- STATUS UMUM --}}
            <option value="selesai" @selected(request('status') == 'selesai')>
                Selesai
            </option>
        </select>

        <!-- Filter Tipe Laporan -->
        <select name="type" class="form-select">
            <option value="">Semua Tipe</option>
            <option value="kehilangan" @selected(request('type') == 'kehilangan')>
                Kehilangan
            </option>
            <option value="penemuan" @selected(request('type') == 'penemuan')>
                Penemuan
            </option>
        </select>

        <!-- Tombol Filter -->
        <button type="submit" class="btn btn-secondary">
            Filter
        </button>
    </form>

    <!-- ===================== -->
    <!-- Tabel Laporan -->
    <!-- ===================== -->
    <div class="table-wrapper">
        <table class="admin-table">

            <!-- Header Tabel -->
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <!-- Body Tabel -->
            <tbody>
                @foreach($reports as $report)
                    <tr>

                        <!-- Judul Laporan -->
                        <td>{{ $report->judul }}</td>

                        <!-- Tipe Laporan -->
                        <td class="capitalize">
                            {{ $report->tipe }}
                        </td>

                        <!-- Status Laporan -->
                        <td class="capitalize status-text">
                            {{ $report->status }}
                        </td>

                        <!-- Tanggal Laporan -->
                        <td>
                            {{ \Carbon\Carbon::parse($report->tanggal_laporan)->format('d M Y') }}
                        </td>

                        <!-- User Pelapor -->
                        <td>
                            {{ $report->user->name ?? '-' }}
                        </td>

                        <!-- Aksi -->
                        <td class="action-cell">

                            {{-- Tombol Detail --}}
                            @if($report->lostItem)
                                <a
                                    href="{{ route('lost-items.show', $report->lostItem) }}"
                                    class="btn btn-link btn-view"
                                >
                                    Detail
                                </a>
                            @elseif($report->foundItem)
                                <a
                                    href="{{ route('found-items.show', $report->foundItem) }}"
                                    class="btn btn-link btn-view"
                                >
                                    Detail
                                </a>
                            @endif

                            {{-- Tombol Hapus --}}
                            @php
                                $itemId = $report->lostItem ? $report->lostItem->id : $report->foundItem->id;
                                $route = $report->lostItem 
                                    ? route('admin.lost-items.destroy', $itemId) 
                                    : route('admin.found-items.destroy', $itemId);
                            @endphp

                            <form action="{{ $route }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <!-- ===================== -->
    <!-- Pagination -->
    <!-- ===================== -->
    <div class="pagination-wrapper">
        {{ $reports->links() }}
    </div>

</div>
@endsection
