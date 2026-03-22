<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - NusaMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="register-wrapper">
        <div class="register-brand">
            <div class="logo">
                <div class="logo-icon">N</div>
                <div class="logo-text">Nusa<span>Mart</span></div>
            </div>
            <div class="brand-icon">
                <i class="fa fa-shopping-bag"></i>
            </div>
            <p>Bergabunglah dengan marketplace produk lokal UMKM Desa Manud Jaya. Jual atau beli produk unggulan desa.</p>
            <ul class="brand-features">
                <li><i class="fa fa-check-circle"></i> Produk asli UMKM Desa Manud Jaya</li>
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
                        <input type="password" id="password" name="password" placeholder="Min 8 karakter, huruf besar & kecil, spesial" required>
                        <div class="password-requirements">Minimal 8 karakter, kombinasi huruf besar & kecil, dan karakter spesial</div>
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
