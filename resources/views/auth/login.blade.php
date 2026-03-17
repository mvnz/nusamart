<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NusaMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: #15161d;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            display: flex;
            max-width: 900px;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .login-brand {
            background: #1e1f29;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 380px;
            text-align: center;
        }

        .login-brand .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .login-brand .logo-icon {
            width: 50px;
            height: 50px;
            background: #D10024;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            color: #fff;
        }

        .login-brand .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
        }

        .login-brand .logo-text span {
            color: #D10024;
        }

        .login-brand p {
            color: #8d8d8d;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .login-brand .brand-features {
            list-style: none;
            text-align: left;
            width: 100%;
        }

        .login-brand .brand-features li {
            color: #aaa;
            font-size: 13px;
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-brand .brand-features li i {
            color: #D10024;
            font-size: 14px;
            width: 20px;
            text-align: center;
        }

        .login-form-section {
            background: #fff;
            padding: 50px 40px;
            flex: 1;
        }

        .header-login {
            margin-bottom: 30px;
        }

        .header-login h1 {
            color: #1e1f29;
            font-size: 26px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .header-login p {
            color: #8d8d8d;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #1e1f29;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        label i {
            color: #D10024;
            margin-right: 4px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e8e8e8;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
            background: #f9f9f9;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #D10024;
            box-shadow: 0 0 0 3px rgba(209, 0, 36, 0.08);
            background: #fff;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .remember-forgot a {
            color: #D10024;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .remember-forgot a:hover {
            color: #a30020;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 6px;
            cursor: pointer;
            accent-color: #D10024;
        }

        .remember-me label {
            margin: 0;
            text-transform: none;
            letter-spacing: normal;
            cursor: pointer;
            font-weight: 400;
            font-size: 13px;
            color: #666;
        }

        .error-box {
            background-color: #fff5f5;
            border: 1px solid #D10024;
            border-left: 4px solid #D10024;
            color: #721c24;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .error-box ul {
            margin-left: 20px;
            margin-top: 6px;
        }

        .error-message {
            color: #D10024;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .success-box {
            background-color: #f0fff4;
            border: 1px solid #27ae60;
            border-left: 4px solid #27ae60;
            color: #155724;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #D10024;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-login:hover {
            background: #a30020;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(209, 0, 36, 0.25);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .signup-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #8d8d8d;
        }

        .signup-link a {
            color: #D10024;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #a30020;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-brand {
                width: 100%;
                padding: 30px 25px;
            }

            .login-brand .brand-features {
                display: none;
            }

            .login-form-section {
                padding: 30px 25px;
            }

            .header-login h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-brand">
            <div class="logo">
                <div class="logo-icon">N</div>
                <div class="logo-text">Nusa<span>Mart</span></div>
            </div>
            <p>Marketplace produk nusantara terpercaya. Temukan produk lokal terbaik dari seluruh Indonesia.</p>
            <ul class="brand-features">
                <li><i class="fa fa-check-circle"></i> Produk asli nusantara</li>
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
                    <a href="#">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login"><i class="fa fa-sign-in"></i> Masuk</button>
            </form>

            <div class="signup-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>
</body>
</html>
