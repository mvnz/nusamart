<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .email-header { background: #1e1f29; padding: 30px; text-align: center; }
        .email-header h1 { color: #fff; font-size: 24px; margin: 0; }
        .email-header h1 span { color: #D10024; }
        .email-body { padding: 30px; }
        .email-body h2 { color: #1e1f29; font-size: 20px; margin-bottom: 15px; }
        .email-body p { color: #555; font-size: 14px; line-height: 1.7; margin-bottom: 15px; }
        .btn-reset { display: inline-block; background: #D10024; color: #fff !important; padding: 14px 30px; text-decoration: none; border-radius: 5px; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-wrapper { text-align: center; margin: 25px 0; }
        .email-footer { background: #f9f9f9; padding: 20px 30px; text-align: center; border-top: 1px solid #eee; }
        .email-footer p { color: #999; font-size: 12px; margin: 0; line-height: 1.6; }
        .url-fallback { word-break: break-all; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>Nusa<span>Mart</span></h1>
        </div>
        <div class="email-body">
            <h2>Halo, {{ $user->name }}!</h2>
            <p>Kami menerima permintaan untuk mengatur ulang password akun NusaMart Anda. Klik tombol di bawah ini untuk membuat password baru:</p>
            <div class="btn-wrapper">
                <a href="{{ $resetUrl }}" class="btn-reset">Reset Password</a>
            </div>
            <p>Link ini berlaku selama <strong>60 menit</strong>. Jika Anda tidak merasa meminta reset password, abaikan email ini.</p>
            <p class="url-fallback">Jika tombol di atas tidak berfungsi, salin dan tempel URL berikut di browser Anda:<br>{{ $resetUrl }}</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} NusaMart. Seluruh hak cipta dilindungi.<br>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
