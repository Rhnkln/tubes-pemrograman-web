@extends('layouts.app')
@section('title', 'Profil')

@section('content')

<!-- ===================== -->
<!-- Wrapper Profil -->
<!-- ===================== -->
<div class="profile-wrapper">

    <!-- Judul Halaman -->
    <h2 class="profile-title">Profil Pengguna</h2>

    <!-- ===================== -->
    <!-- Form Update Profil -->
    <!-- ===================== -->
    <form
        method="POST"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
    >
        @csrf

        <!-- ===================== -->
        <!-- Foto Profil -->
        <!-- ===================== -->
        <div class="profile-img-wrapper">
            <img
                src="{{ $user->foto_profil
                        ? asset('storage/'.$user->foto_profil)
                        : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                class="profile-img-lg"
            >

            <!-- Error validasi foto -->
            @error('foto_profil')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <!-- ===================== -->
        <!-- Nama -->
        <!-- ===================== -->
        <div class="form-group">
            <label>Nama</label>
            <input
                type="text"
                name="name"
                class="input"
                value="{{ old('name', $user->name) }}"
            >
            @error('name')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <!-- ===================== -->
        <!-- Email -->
        <!-- ===================== -->
        <div class="form-group">
            <label>Email</label>
            <input
                type="email"
                name="email"
                class="input"
                value="{{ old('email', $user->email) }}"
            >
        </div>

        <!-- ===================== -->
        <!-- Nomor HP -->
        <!-- ===================== -->
        <div class="form-group">
            <label>No. HP</label>
            <input
                type="text"
                name="phone"
                class="input"
                value="{{ old('phone', $user->phone) }}"
            >
        </div>

        <!-- ===================== -->
        <!-- Alamat -->
        <!-- ===================== -->
        <div class="form-group">
            <label>Alamat</label>
            <textarea
                name="alamat"
                class="input"
            >{{ old('alamat', $user->alamat) }}</textarea>
        </div>

        <!-- ===================== -->
        <!-- Submit Button -->
        <!-- ===================== -->
        <button class="btn" style="width:100%">
            Simpan Perubahan
        </button>

    </form>
</div>

@endsection
