<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TITIK TEMU - Registrasi</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
<body>

<div class="auth-container-register">
    <div class="register-wrapper">
        <h2 class="register-title">REGISTRASI</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <div class="form-group">
                <label for="name">Nama</label>
                <span class="description">Masukkan nama lengkap Anda</span>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <span class="description">Masukkan email aktif Anda</span>
                <div class="input-icon-wrapper">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                    >
                    <img src="{{ asset('icons/4105936-email-envelope-mail-message-snail-mail_113938.svg') }}" alt="Email Icon" class="icon">
                </div>
                @error('email')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <span class="description">Masukkan password minimal 8 karakter</span>
                <div class="input-icon-wrapper">
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    <img src="{{ asset('icons/matatutup.svg') }}" alt="Toggle Password" class="icon toggle-password" data-target="password">
                </div>
                @error('password')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <span class="description">Masukkan kembali password Anda</span>
                <div class="input-icon-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required>
                    <img src="{{ asset('icons/matatutup.svg') }}" alt="Toggle Password" class="icon toggle-password" data-target="password_confirmation">
                </div>
            </div>

            <!-- NIM (Opsional) -->
            <div class="form-group">
                <label for="nim">NIM <span class="optional">(opsional)</span></label>
                <span class="description">Jika Anda mahasiswa, masukkan NIM Anda</span>
                <input type="text" id="nim" name="nim" value="{{ old('nim') }}">
                @error('nim')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <!-- No HP (Opsional) -->
            <div class="form-group">
                <label for="phone">No. HP <span class="optional">(opsional)</span></label>
                <span class="description">Masukkan nomor HP yang bisa dihubungi</span>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-primary">Daftar</button>
        </form>
    </div>

    <!-- Switch to Login -->
    <div class="right-card animate-right-register">
        <button class="btn-switch-auth" onclick="window.location='{{ route('login') }}'">
            <div class="right-card-header">
                <h1>LOGIN</h1>
            </div>
        </button>
    </div>
</div>

<!-- ===================== -->
<!-- Script Password Toggle -->
<!-- ===================== -->
<script>
document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.dataset.target;
        const input = document.getElementById(targetId);

        if (input) {
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;

            // Ganti icon sesuai status
            btn.src = type === 'password'
                ? "{{ asset('icons/matatutup.svg') }}"    // password hidden
                : "{{ asset('icons/eye_120221.svg') }}"; // password visible
        }
    });
});
</script>

</body>
</html>
