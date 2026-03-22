<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - NusaMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>
<body>
    <div class="verify-wrapper">
        <div class="verify-header">
            <div class="logo">
                <div class="logo-icon">N</div>
                <div class="logo-text">Nusa<span>Mart</span></div>
            </div>
        </div>

        <div class="verify-body">
            <div class="verify-icon">
                <i class="fa fa-envelope-o"></i>
            </div>

            <h2>Verifikasi Email Anda</h2>
            <p>Kami telah mengirim link verifikasi ke email:</p>
            <p class="email-highlight">{{ Auth::user()->email }}</p>
            <p>Silakan cek inbox email Anda dan klik link verifikasi untuk melanjutkan.</p>

            @if (session('message'))
                <div class="success-message">
                    <i class="fa fa-check-circle"></i> {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-resend">
                    <i class="fa fa-refresh"></i> Kirim Ulang Email Verifikasi
                </button>
            </form>

            <div class="tips-list">
                <h4><i class="fa fa-lightbulb-o"></i> Tips</h4>
                <ul>
                    <li>Cek folder Spam atau Junk jika email tidak ditemukan</li>
                    <li>Pastikan email <strong>{{ Auth::user()->email }}</strong> sudah benar</li>
                    <li>Tunggu beberapa menit sebelum mengirim ulang</li>
                </ul>
            </div>
        </div>

        <div class="verify-footer">
            <div class="divider">
                <p>Salah email? Anda bisa logout dan daftar ulang.</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fa fa-sign-out"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
