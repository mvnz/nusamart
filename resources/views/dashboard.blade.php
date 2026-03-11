<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NusaMart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            color: #333;
            font-size: 24px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-role {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .logout-btn {
            padding: 10px 20px;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 40px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .welcome-card h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .welcome-card p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }

        .card h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .card p {
            color: #777;
            font-size: 14px;
            line-height: 1.6;
        }

        .card-icon {
            font-size: 30px;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .user-info {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>📊 Dashboard NusaMart</h1>
            <div class="user-info">
                <div>
                    <p style="color: #333; font-weight: 600;">{{ auth()->user()->name }}</p>
                    <span class="user-role">{{ auth()->user()->role == 'penjual' ? '🏪 Penjual' : '👤 Pembeli' }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <div class="welcome-card">
            <h2>Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
            <p>
                @if (auth()->user()->role == 'penjual')
                    Anda terdaftar sebagai penjual. Kelola produk dan pesanan Anda di sini.
                @else
                    Anda terdaftar sebagai pembeli. Temukan produk pilihan dari berbagai penjual.
                @endif
            </p>
        </div>

        <div class="content-grid">
            <div class="card">
                <div class="card-icon">📦</div>
                <h3>Profil</h3>
                <p>Email: {{ auth()->user()->email }}<br>Username: {{ auth()->user()->username }}<br>Phone: {{ auth()->user()->phone }}</p>
            </div>

            @if (auth()->user()->role == 'penjual')
                <div class="card">
                    <div class="card-icon">📈</div>
                    <h3>Penjualan</h3>
                    <p>Kelola dan pantau penjualan produk Anda dengan mudah.</p>
                </div>

                <div class="card">
                    <div class="card-icon">📋</div>
                    <h3>Pesanan</h3>
                    <p>Lihat dan proses pesanan dari para pembeli.</p>
                </div>
            @else
                <div class="card">
                    <div class="card-icon">🛒</div>
                    <h3>Belanja</h3>
                    <p>Jelajahi ribuan produk dari berbagai kategori.</p>
                </div>

                <div class="card">
                    <div class="card-icon">❤️</div>
                    <h3>Favorit</h3>
                    <p>Simpan produk favorit Anda untuk dibeli nanti.</p>
                </div>
            @endif

            <div class="card">
                <div class="card-icon">⚙️</div>
                <h3>Pengaturan</h3>
                <p>Atur preferensi dan keamanan akun Anda.</p>
            </div>
        </div>
    </div>
</body>
</html>
