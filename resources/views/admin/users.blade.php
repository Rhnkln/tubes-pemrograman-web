@extends('layouts.app')
@section('title', 'Kelola User')

@section('content')
<div class="admin-card">

    <!-- ===================== -->
    <!-- Form Pencarian User -->
    <!-- ===================== -->
    <form method="GET" class="admin-filter-form">
        <input
            type="text"
            name="search"
            placeholder="Cari nama/email/NIM"
            value="{{ request('search') }}"
            class="form-input"
        >
        <button type="submit" class="btn btn-secondary">
            Cari
        </button>
    </form>

    <!-- ===================== -->
    <!-- Tabel Data User -->
    <!-- ===================== -->
    <div class="table-wrapper">
        <table class="admin-table">

            <!-- Header Tabel -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIM</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <!-- Body Tabel -->
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <!-- Nama User -->
                        <td>{{ $user->name }}</td>

                        <!-- Email User -->
                        <td>{{ $user->email }}</td>

                        <!-- NIM User -->
                        <td>{{ $user->nim }}</td>

                        <!-- Role User -->
                        <td>{{ $user->role->name ?? '-' }}</td>

                        <!-- Aksi -->
                        <td>
                            {{-- User tidak bisa menghapus dirinya sendiri --}}
                            @if(auth()->id() !== $user->id)
                                <form
                                    action="{{ route('admin.users.destroy', $user) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="action-delete">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
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
        {{ $users->links() }}
    </div>

</div>
@endsection
