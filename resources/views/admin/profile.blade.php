@extends('layouts.app')
@section('title', 'Profil Admin')

@section('content')
<div class="profile-wrapper">

    <!-- ===================== -->
    <!-- Judul Halaman -->
    <!-- ===================== -->
    <h2 class="profile-title">
        Profil Admin
    </h2>

    <!-- ===================== -->
    <!-- Informasi Admin -->
    <!-- ===================== -->
    <p>
        <strong>Nama:</strong>
        {{ $user->name }}
    </p>

    <p>
        <strong>Email:</strong>
        {{ $user->email }}
    </p>

    <p>
        <strong>Role:</strong>
        Admin
    </p>

</div>
@endsection
