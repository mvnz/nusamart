<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - NusaMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>
<body>
    <div class="forgot-wrapper">
        <div class="forgot-brand">
            <div class="logo">
                <div class="logo-icon">N</div>
                <div class="logo-text">Nusa<span>Mart</span></div>
            </div>
            <div class="brand-icon">
                <i class="fa fa-unlock-alt"></i>
            </div>
            <p>Jangan khawatir, kami akan membantu Anda mengatur ulang password.</p>
            <ul class="steps">
                <li><span class="step-num">1</span> Masukkan email terdaftar</li>
                <li><span class="step-num">2</span> Cek inbox email Anda</li>
                <li><span class="step-num">3</span> Klik link reset password</li>
                <li><span class="step-num">4</span> Buat password baru</li>
            </ul>
        </div>

        <div class="forgot-form-section">
            <div class="header-forgot">
                <h1>Lupa Password?</h1>
                <p>Masukkan alamat email yang terdaftar di akun Anda. Kami akan mengirimkan link untuk mengatur ulang password.</p>
            </div>

            @if(session('success'))
                <div class="success-box">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

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

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email"><i class="fa fa-envelope-o"></i> Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email terdaftar" required autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit"><i class="fa fa-paper-plane"></i> Kirim Link Reset</button>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}"><i class="fa fa-arrow-left"></i> Kembali ke halaman login</a>
            </div>
        </div>
    </div>
</body>
</html>
