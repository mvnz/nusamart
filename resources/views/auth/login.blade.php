<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NusaMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ filemtime(public_path('css/auth.css')) }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-brand">
            <div class="logo">
                <div class="logo-icon">N</div>
                <div class="logo-text">Nusa<span>Mart</span></div>
            </div>
            <div class="brand-icon">
                <i class="fa fa-shopping-bag"></i>
            </div>
            <p>Marketplace produk lokal UMKM Desa Manud Jaya. Temukan produk unggulan desa langsung dari para pelaku usaha.</p>
            <ul class="brand-features">
                <li><i class="fa fa-check-circle"></i> Produk asli UMKM Desa Manud Jaya</li>
                <li><i class="fa fa-check-circle"></i> Pembayaran aman & terpercaya</li>
                <li><i class="fa fa-check-circle"></i> Pengiriman ke seluruh Indonesia</li>
                <li><i class="fa fa-check-circle"></i> Dukungan pelanggan 24/7</li>
            </ul>
        </div>

        <div class="login-form-section">
            <div class="header-login">
                <h1>Masuk</h1>
                <p>Selamat datang kembali di NusaMart</p>
            </div>

            @if(session('success'))
                <div class="success-box">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-box">
                    <strong><i class="fa fa-exclamation-circle"></i> Login Gagal:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email"><i class="fa fa-envelope-o"></i> Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password"><i class="fa fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <a href="{{ route('password.request') }}">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login"><i class="fa fa-sign-in"></i> Masuk</button>
            </form>

            <div class="signup-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>
</html>
