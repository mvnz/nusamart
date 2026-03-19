<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - NusaMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .verify-wrapper {
            max-width: 550px;
            width: 100%;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .verify-header {
            background: #1e1f29;
            padding: 40px 30px 30px;
        }

        .verify-header .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .verify-header .logo-icon {
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

        .verify-header .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
        }

        .verify-header .logo-text span {
            color: #D10024;
        }

        .verify-body {
            padding: 40px 35px;
        }

        .verify-icon {
            width: 80px;
            height: 80px;
            background: #fff5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }

        .verify-icon i {
            font-size: 36px;
            color: #D10024;
        }

        .verify-body h2 {
            color: #1e1f29;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .verify-body p {
            color: #666;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 8px;
        }

        .verify-body .email-highlight {
            color: #D10024;
            font-weight: 600;
        }

        .success-message {
            background: #e8f5e9;
            border: 1px solid #4caf50;
            border-left: 4px solid #4caf50;
            color: #2e7d32;
            padding: 12px 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 13px;
        }

        .success-message i {
            margin-right: 6px;
        }

        .btn-resend {
            display: inline-block;
            padding: 14px 35px;
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
            margin-top: 20px;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-resend:hover {
            background: #a30020;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(209, 0, 36, 0.25);
        }

        .btn-resend:active {
            transform: translateY(0);
        }

        .verify-footer {
            padding: 0 35px 35px;
        }

        .verify-footer .divider {
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 10px;
        }

        .verify-footer p {
            color: #999;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .btn-logout {
            background: none;
            border: none;
            color: #D10024;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .btn-logout:hover {
            color: #a30020;
        }

        .tips-list {
            text-align: left;
            background: #f9f9f9;
            border-radius: 5px;
            padding: 15px 20px;
            margin: 20px 0 0;
        }

        .tips-list h4 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e1f29;
            margin-bottom: 10px;
        }

        .tips-list li {
            color: #666;
            font-size: 12px;
            margin-bottom: 6px;
            list-style: none;
            padding-left: 20px;
            position: relative;
        }

        .tips-list li:before {
            content: "\f105";
            font-family: FontAwesome;
            position: absolute;
            left: 0;
            color: #D10024;
        }
    </style>
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
