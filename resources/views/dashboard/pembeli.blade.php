{{-- ============ PEMBELI DASHBOARD ============ --}}
@php
    $user = auth()->user();
    $orders = $user->orders()->latest()->take(5)->get();
    $totalOrders = $user->orders()->count();
    $pendingOrders = $user->orders()->where('status', 'pending')->count();
    $completedOrders = $user->orders()->where('status', 'delivered')->count();
    $cartCount = $user->carts()->sum('quantity');
@endphp

<style>
.pembeli-dash { padding: 30px 0 60px; }
.welcome-bar {
    background: linear-gradient(135deg, #D10024, #ff4a6a);
    color: #fff; border-radius: 14px; padding: 28px 32px;
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 28px; flex-wrap: wrap; gap: 16px;
}
.welcome-bar h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
.welcome-bar p { font-size: 13px; opacity: .85; }
.welcome-bar .btn-shop-now {
    padding: 12px 24px; background: #fff; color: #D10024;
    border-radius: 8px; font-size: 14px; font-weight: 700;
    text-decoration: none; white-space: nowrap;
}
.welcome-bar .btn-shop-now:hover { background: #f5f5f5; }

.dash-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
@media(max-width:768px){ .dash-stats { grid-template-columns: repeat(2, 1fr); } }

.stat-card {
    background: #fff; border-radius: 12px; padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07); display: flex; flex-direction: column; gap: 8px;
}
.stat-card .stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; font-size: 20px;
}
.stat-card .stat-num { font-size: 28px; font-weight: 800; color: #1e1f29; }
.stat-card .stat-label { font-size: 12px; color: #888; font-weight: 500; }

.dash-grid { display: grid; grid-template-columns: 1fr 280px; gap: 20px; }
@media(max-width:900px){ .dash-grid { grid-template-columns: 1fr; } }

.dash-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.07); }
.dash-card-header {
    padding: 18px 20px; border-bottom: 1px solid #eee;
    display: flex; justify-content: space-between; align-items: center;
}
.dash-card-header h3 { font-size: 15px; font-weight: 700; color: #1e1f29; }
.dash-card-header a { font-size: 12px; color: #D10024; font-weight: 600; }

.order-row {
    padding: 14px 20px; display: flex; justify-content: space-between;
    align-items: center; border-bottom: 1px solid #f5f5f5;
}
.order-row:last-child { border-bottom: none; }
.order-row-num { font-size: 13px; font-weight: 600; color: #1e1f29; margin-bottom: 3px; }
.order-row-date { font-size: 11px; color: #aaa; }
.order-row-total { font-size: 13px; font-weight: 700; color: #D10024; }
.order-badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; color: #fff; }
.order-row-right { text-align: right; }

.empty-row { padding: 30px 20px; text-align: center; color: #999; font-size: 13px; }
.empty-row .fa { font-size: 32px; color: #e0e0e0; display: block; margin-bottom: 10px; }

.quick-links { padding: 20px; display: flex; flex-direction: column; gap: 10px; }
.quick-link {
    display: flex; align-items: center; gap: 12px; padding: 12px 14px;
    border-radius: 8px; background: #f9f9f9; text-decoration: none; color: #333;
    font-size: 13px; font-weight: 600; transition: background .15s;
}
.quick-link:hover { background: #fff0f0; color: #D10024; }
.quick-link .fa { font-size: 16px; width: 20px; text-align: center; color: #D10024; }
.quick-link .ql-count {
    margin-left: auto; background: #D10024; color: #fff;
    font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 20px;
}
</style>

<div class="pembeli-dash">
    <div class="welcome-bar">
        <div>
            <h2>Halo, {{ $user->name }}! 👋</h2>
            <p>Selamat datang di NusaMart. Temukan produk terbaik pilihan Anda.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn-shop-now">
            <i class="fa fa-shopping-bag"></i> Belanja Sekarang
        </a>
    </div>

    <div class="dash-stats">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff0f0;color:#D10024;"><i class="fa fa-shopping-bag"></i></div>
            <div class="stat-num">{{ $totalOrders }}</div>
            <div class="stat-label">Total Pembelian</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;color:#f59e0b;"><i class="fa fa-clock-o"></i></div>
            <div class="stat-num">{{ $pendingOrders }}</div>
            <div class="stat-label">Menunggu Konfirmasi</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#d1fae5;color:#10b981;"><i class="fa fa-check-circle"></i></div>
            <div class="stat-num">{{ $completedOrders }}</div>
            <div class="stat-label">Pesanan Selesai</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ede9fe;color:#7c3aed;"><i class="fa fa-shopping-cart"></i></div>
            <div class="stat-num">{{ $cartCount }}</div>
            <div class="stat-label">Item di Keranjang</div>
        </div>
    </div>

    <div class="dash-grid">
        {{-- Pesanan Terbaru --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <h3><i class="fa fa-list-alt" style="color:#D10024;margin-right:6px;"></i> Pesanan Terbaru</h3>
                <a href="{{ route('orders.index') }}">Lihat Semua →</a>
            </div>
            @forelse($orders as $order)
            <div class="order-row">
                <div>
                    <div class="order-row-num">{{ $order->order_number }}</div>
                    <div class="order-row-date">{{ $order->created_at->format('d M Y') }}</div>
                </div>
                <div class="order-row-right">
                    <div class="order-row-total">{{ $order->formatted_total }}</div>
                    <span class="order-badge" style="background:{{ $order->status_color }};">{{ $order->status_label }}</span>
                </div>
            </div>
            @empty
            <div class="empty-row">
                <i class="fa fa-shopping-bag"></i>
                Belum ada pesanan.<br>
                <a href="{{ route('products.index') }}" style="color:#D10024;font-weight:600;">Mulai belanja</a>
            </div>
            @endforelse
        </div>

        {{-- Quick Links --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <h3><i class="fa fa-th-large" style="color:#D10024;margin-right:6px;"></i> Menu Cepat</h3>
            </div>
            <div class="quick-links">
                <a href="{{ route('products.index') }}" class="quick-link">
                    <i class="fa fa-store"></i> Jelajahi Produk
                </a>
                <a href="{{ route('cart.index') }}" class="quick-link">
                    <i class="fa fa-shopping-cart"></i> Keranjang Saya
                    @if($cartCount > 0)
                        <span class="ql-count">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('orders.index') }}" class="quick-link">
                    <i class="fa fa-list-alt"></i> Daftar Pesanan
                    @if($totalOrders > 0)
                        <span class="ql-count">{{ $totalOrders }}</span>
                    @endif
                </a>
                <a href="{{ route('profile') }}" class="quick-link">
                    <i class="fa fa-user-circle"></i> Profil Saya
                </a>
            </div>
        </div>
    </div>
</div>
