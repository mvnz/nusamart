<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - NusaMart</title>
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

        .register-wrapper {
            display: flex;
            max-width: 1000px;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .register-brand {
            background: #1e1f29;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 360px;
            min-width: 360px;
            text-align: center;
        }

        .register-brand .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .register-brand .logo-icon {
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

        .register-brand .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
        }

        .register-brand .logo-text span {
            color: #D10024;
        }

        .register-brand p {
            color: #8d8d8d;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .register-brand .brand-features {
            list-style: none;
            text-align: left;
            width: 100%;
        }

        .register-brand .brand-features li {
            color: #aaa;
            font-size: 13px;
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .register-brand .brand-features li i {
            color: #D10024;
            font-size: 14px;
            width: 20px;
            text-align: center;
        }

        .register-form-section {
            background: #fff;
            padding: 40px;
            flex: 1;
            overflow-y: auto;
            max-height: 95vh;
        }

        .header-register {
            margin-bottom: 25px;
        }

        .header-register h1 {
            color: #1e1f29;
            font-size: 26px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .header-register p {
            color: #8d8d8d;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
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

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 11px 15px;
            border: 2px solid #e8e8e8;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
            background: #f9f9f9;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus,
        select:focus {
            outline: none;
            border-color: #D10024;
            box-shadow: 0 0 0 3px rgba(209, 0, 36, 0.08);
            background: #fff;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 8px;
        }

        .role-option {
            position: relative;
        }

        .role-option input[type="radio"] {
            display: none;
        }

        .role-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border: 2px solid #e8e8e8;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 13px;
            color: #666;
            background: #f9f9f9;
        }

        .role-option input[type="radio"]:checked + .role-label {
            border-color: #D10024;
            background-color: #fff5f5;
            color: #D10024;
        }

        .role-option input[type="radio"]:hover + .role-label {
            border-color: #D10024;
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

        .password-requirements {
            font-size: 11px;
            color: #999;
            margin-top: 5px;
        }

        .btn-register {
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
            margin-top: 10px;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-register:hover {
            background: #a30020;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(209, 0, 36, 0.25);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #8d8d8d;
        }

        .login-link a {
            color: #D10024;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #a30020;
        }

        @media (max-width: 768px) {
            .register-wrapper {
                flex-direction: column;
            }

            .register-brand {
                width: 100%;
                min-width: unset;
                padding: 30px 25px;
            }

            .register-brand .brand-features {
                display: none;
            }

            .register-form-section {
                padding: 30px 25px;
                max-height: unset;
            }

            .header-register h1 {
                font-size: 22px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-brand">
            <div class="logo">
                <div class="logo-icon">N</div>
                <div class="logo-text">Nusa<span>Mart</span></div>
            </div>
            <p>Bergabunglah dengan marketplace produk nusantara terpercaya. Jual atau beli produk lokal terbaik.</p>
            <ul class="brand-features">
                <li><i class="fa fa-check-circle"></i> Produk asli nusantara</li>
                <li><i class="fa fa-check-circle"></i> Pembayaran aman & terpercaya</li>
                <li><i class="fa fa-check-circle"></i> Pengiriman ke seluruh Indonesia</li>
                <li><i class="fa fa-check-circle"></i> Gratis biaya pendaftaran</li>
                <li><i class="fa fa-check-circle"></i> Dukungan pelanggan 24/7</li>
            </ul>
        </div>

        <div class="register-form-section">
            <div class="header-register">
                <h1>Daftar Sekarang</h1>
                <p>Cari produk sesukamu, di NusaMart</p>
            </div>

            @if ($errors->any())
                <div class="error-box">
                    <strong><i class="fa fa-exclamation-circle"></i> Terjadi Kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="form-group">
                    <label for="nama_lengkap"><i class="fa fa-id-card-o"></i> Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                    @error('nama_lengkap')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="username"><i class="fa fa-at"></i> Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="username" required>
                        @error('username')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone"><i class="fa fa-phone"></i> Nomor HP/WhatsApp</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="081234567890" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        @error('phone')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fa fa-envelope-o"></i> Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat"><i class="fa fa-home"></i> Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" placeholder="Jl. Contoh No. 123" required>
                    @error('alamat')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kota"><i class="fa fa-building-o"></i> Kota</label>
                        <input type="text" id="kota" name="kota" value="{{ old('kota') }}" placeholder="Jakarta" required>
                        @error('kota')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="propinsi"><i class="fa fa-map-marker"></i> Propinsi</label>
                        <input type="text" id="propinsi" name="propinsi" value="{{ old('propinsi') }}" placeholder="DKI Jakarta" required>
                        @error('propinsi')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password"><i class="fa fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                        <div class="password-requirements">Minimal 8 karakter</div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation"><i class="fa fa-lock"></i> Ulangi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-user-plus"></i> Daftar sebagai</label>
                    <div class="role-selector">
                        <div class="role-option">
                            <input type="radio" id="pembeli" name="role" value="pembeli" {{ old('role') == 'pembeli' ? 'checked' : '' }} required>
                            <label for="pembeli" class="role-label"><i class="fa fa-shopping-bag"></i> Pembeli</label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="penjual" name="role" value="penjual" {{ old('role') == 'penjual' ? 'checked' : '' }}>
                            <label for="penjual" class="role-label"><i class="fa fa-building-o"></i> Penjual</label>
                        </div>
                    </div>
                    @error('role')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-register"><i class="fa fa-user-plus"></i> Daftar Akun</button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
</html>
