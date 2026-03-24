<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - NusaMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ filemtime(public_path('css/auth.css')) }}">

</head>
<body>
    <div class="reset-wrapper">
        <div class="reset-brand">
            <div class="logo">
                <div class="logo-icon">N</div>
                <div class="logo-text">Nusa<span>Mart</span></div>
            </div>
            <div class="brand-icon">
                <i class="fa fa-key"></i>
            </div>
            <p>Buat password baru untuk akun Anda. Pastikan password kuat dan mudah diingat.</p>
        </div>

        <div class="reset-form-section">
            <div class="header-reset">
                <h1>Reset Password</h1>
                <p>Silakan masukkan password baru untuk akun Anda.</p>
            </div>

            @if ($errors->any())
                <div class="error-box">
                    <strong><i class="fa fa-exclamation-circle"></i> Gagal:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email"><i class="fa fa-envelope-o"></i> Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fa fa-lock"></i> Password Baru</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password baru" required autofocus>
                    <div class="password-requirements">Minimal 8 karakter, kombinasi huruf besar & kecil, dan karakter spesial</div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation"><i class="fa fa-check-circle"></i> Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required>
                </div>

                <button type="submit" class="btn-submit"><i class="fa fa-save"></i> Reset Password</button>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}"><i class="fa fa-arrow-left"></i> Kembali ke halaman login</a>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>
</html>
