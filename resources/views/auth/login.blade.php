<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ===================== -->
    <!-- Meta & Title -->
    <!-- ===================== -->
    <meta charset="UTF-8">
    <title>TITIK TEMU</title>

    <!-- ===================== -->
    <!-- Main CSS -->
    <!-- ===================== -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- ===================== -->
    <!-- Container Login -->
    <!-- ===================== -->
    <div class="auth-container">

        <!-- ===================== -->
        <!-- LEFT SIDE : SWITCH TO REGISTER -->
        <!-- ===================== -->
        <div class="left-card animate-left-login">
            <button
                class="btn-switch-auth"
                onclick="window.location='{{ route('register') }}'"
            >
                <div class="left-card-header">
                    <h1>REGISTRASI</h1>
                </div>
            </button>
        </div>

        <!-- ===================== -->
        <!-- RIGHT SIDE : FORM LOGIN -->
        <!-- ===================== -->
        <div class="login-wrapper">

            <!-- Judul -->
            <h2 class="login-title">
                LOGIN
            </h2>

            <!-- Pesan sukses (misalnya setelah registrasi berhasil) -->
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ===================== -->
            <!-- Form Login -->
            <!-- ===================== -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

               <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-icon-wrapper">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            required
                            autofocus
                        >
                        <span class="input-icon">
                            <img src="{{ asset('icons/4105936-email-envelope-mail-message-snail-mail_113938.svg') }}" alt="Email Icon">
                        </span>
                    </div>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon-wrapper">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Masukkan password"
                            required
                        >
                        <span class="input-icon toggle-password" data-target="password">
                            <img src="{{ asset('icons/matatutup.svg') }}" alt="Toggle Password" id="password-icon">
                        </span>
                    </div>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-box">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingatkan saya</label>
                </div>

                <!-- Tombol Login -->
                <button type="submit" class="btn-primary-login">
                    Login
                </button>
            </form>
        </div>

        <!-- ===================== -->
        <!-- JavaScript -->
        <!-- ===================== -->
        <script src="{{ asset('js/app.js') }}" defer></script>

    </div>

    <script>
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = btn.querySelector('img');

            if (input.type === 'password') {
                input.type = 'text';
                icon.src = "{{ asset('icons/eye_120221.svg') }}"; // icon mata tertutup
            } else {
                input.type = 'password';
                icon.src = "{{ asset('icons/matatutup.svg') }}"; // icon mata terbuka
            }
        });
    });
    </script>

</body>
</html>
