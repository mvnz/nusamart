@extends('layouts.seller')

@section('title', 'Beranda - Seller Center NusaMart')

@section('breadcrumb')<strong>Beranda</strong> Seller Center
@endsection

@section('content')

{{-- Welcome --}}
<div class="sc-welcome">
    <div>
        <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
        <p>{{ now()->translatedFormat('l, d F Y') }} &mdash; Seller Center NusaMart</p>
    </div>
    <i class="fa fa-store sc-welcome-icon"></i>
</div>

{{-- â•â• Stat cards â•â• --}}
<div style="margin-bottom:14px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:.8px;">Penting Hari Ini</div>
<div class="sc-stat-grid">
    <div class="sc-stat-card">
        <div class="sc-stat-icon" style="background:linear-gradient(135deg,#f97316,#fb923c);"><i class="fa fa-bell"></i></div>
        <div class="sc-stat-info">
            <div class="sc-stat-value">{{ $newOrdersCount }}</div>
            <div class="sc-stat-label">Pesanan Baru</div>
            <div class="sc-stat-sub">Menunggu konfirmasi</div>
        </div>
        <a href="{{ route('seller.orders') }}?status=pending" class="sc-stat-arrow"><i class="fa fa-arrow-right"></i></a>
    </div>
    <div class="sc-stat-card">
        <div class="sc-stat-icon" style="background:linear-gradient(135deg,#3b82f6,#60a5fa);"><i class="fa fa-truck"></i></div>
        <div class="sc-stat-info">
            <div class="sc-stat-value">{{ $processingCount }}</div>
            <div class="sc-stat-label">Siap Dikirim</div>
            <div class="sc-stat-sub">Sedang diproses</div>
        </div>
        <a href="{{ route('seller.orders') }}?status=processing" class="sc-stat-arrow"><i class="fa fa-arrow-right"></i></a>
    </div>
    <div class="sc-stat-card">
        <div class="sc-stat-icon" style="background:linear-gradient(135deg,#10b981,#34d399);"><i class="fa fa-cube"></i></div>
        <div class="sc-stat-info">
            <div class="sc-stat-value">{{ $activeProductsCount }}</div>
            <div class="sc-stat-label">Produk Aktif</div>
            <div class="sc-stat-sub">Dari {{ $totalProductsCount }} total produk</div>
        </div>
        <a href="{{ route('products.my-products') }}" class="sc-stat-arrow"><i class="fa fa-arrow-right"></i></a>
    </div>
    <div class="sc-stat-card">
        <div class="sc-stat-icon" style="background:linear-gradient(135deg,#D10024,#ff6b6b);"><i class="fa fa-money"></i></div>
        <div class="sc-stat-info">
            <div class="sc-stat-value" style="font-size:18px;">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
            <div class="sc-stat-label">Pendapatan Bulan Ini</div>
            <div class="sc-stat-sub">{{ now()->translatedFormat('F Y') }}</div>
        </div>
        <a href="{{ route('seller.orders') }}?status=delivered" class="sc-stat-arrow"><i class="fa fa-arrow-right"></i></a>
    </div>
</div>

{{-- â•â• Quick actions â•â• --}}
<div class="sc-quick-grid">
    <a href="{{ route('products.my-products') }}#tambah" class="sc-quick-btn">
        <div class="icon" style="background:linear-gradient(135deg,#10b981,#34d399);"><i class="fa fa-plus"></i></div>
        <span>Tambah Produk</span>
    </a>
    <a href="{{ route('seller.orders') }}" class="sc-quick-btn">
        <div class="icon" style="background:linear-gradient(135deg,#3b82f6,#60a5fa);"><i class="fa fa-shopping-bag"></i></div>
        <span>Daftar Pesanan</span>
    </a>
    <a href="{{ route('profile') }}" class="sc-quick-btn">
        <div class="icon" style="background:linear-gradient(135deg,#8b5cf6,#a78bfa);"><i class="fa fa-user"></i></div>
        <span>Profil Toko</span>
    </a>
    <a href="{{ route('home') }}" class="sc-quick-btn">
        <div class="icon" style="background:linear-gradient(135deg,#f97316,#fb923c);"><i class="fa fa-eye"></i></div>
        <span>Lihat Marketplace</span>
    </a>
</div>

{{-- â•â• Revenue + Donut â•â• --}}
<div class="sc-two-col">
    {{-- Revenue card --}}
    <div class="sc-revenue-card">
        <div class="sc-revenue-label">Total Pendapatan Keseluruhan</div>
        <div class="sc-revenue-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="sc-revenue-sub">Dari pesanan yang sudah selesai</div>
        <div class="sc-revenue-stats">
            <div class="sc-revenue-stat-item">
                <div class="sc-revenue-stat-label">Pesanan Selesai</div>
                <div class="sc-revenue-stat-value">{{ $deliveredCount }}</div>
            </div>
            <div class="sc-revenue-stat-item">
                <div class="sc-revenue-stat-label">Sedang Dikirim</div>
                <div class="sc-revenue-stat-value">{{ $shippedCount }}</div>
            </div>
            <div class="sc-revenue-stat-item">
                <div class="sc-revenue-stat-label">Total Produk</div>
                <div class="sc-revenue-stat-value">{{ $totalProductsCount }}</div>
            </div>
        </div>
    </div>

    {{-- Order distribution --}}
    <div class="sc-card">
        <div class="sc-card-header">
            <div class="sc-section-title"><i class="fa fa-list-ul"></i> Status Pesanan</div>
        </div>
        <div class="sc-dist-grid">
            <a href="{{ route('seller.orders') }}?status=delivered" class="sc-dist-box" style="--dc:#10b981;--db:#d1fae5;">
                <i class="fa fa-check-circle sc-dist-box-icon"></i>
                <div class="sc-dist-box-val">{{ $deliveredCount }}</div>
                <div class="sc-dist-box-lbl">Selesai</div>
            </a>
            <a href="{{ route('seller.orders') }}?status=shipped" class="sc-dist-box" style="--dc:#8b5cf6;--db:#ede9fe;">
                <i class="fa fa-truck sc-dist-box-icon"></i>
                <div class="sc-dist-box-val">{{ $shippedCount }}</div>
                <div class="sc-dist-box-lbl">Dikirim</div>
            </a>
            <a href="{{ route('seller.orders') }}?status=processing" class="sc-dist-box" style="--dc:#3b82f6;--db:#dbeafe;">
                <i class="fa fa-cog sc-dist-box-icon"></i>
                <div class="sc-dist-box-val">{{ $processingCount }}</div>
                <div class="sc-dist-box-lbl">Diproses</div>
            </a>
            <a href="{{ route('seller.orders') }}?status=pending" class="sc-dist-box" style="--dc:#f97316;--db:#ffedd5;">
                <i class="fa fa-clock-o sc-dist-box-icon"></i>
                <div class="sc-dist-box-val">{{ $newOrdersCount }}</div>
                <div class="sc-dist-box-lbl">Menunggu</div>
            </a>
        </div>
    </div>
</div>

{{-- â•â• Products + Orders â•â• --}}
<div class="sc-two-col">
    {{-- Top products --}}
    <div class="sc-card">
        <div class="sc-card-header">
            <div class="sc-section-title"><i class="fa fa-cube"></i> Produk Terbaru</div>
            <a href="{{ route('products.my-products') }}" class="sc-section-link">Lihat Semua <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        <div class="sc-card-body">
            @forelse($latestProducts as $product)
            <div class="sc-prod-row">
                <div class="sc-prod-img">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="">
                    @else
                        <i class="fa fa-shopping-bag" style="color:#ccc;font-size:18px;"></i>
                    @endif
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="sc-prod-name">{{ $product->name }}</div>
                    <div class="sc-prod-price">{{ $product->formatted_price }}</div>
                </div>
                <div style="text-align:right;">
                    <div class="sc-prod-stock">Stok {{ $product->stock }}</div>
                    @if($product->is_active)
                        <span style="font-size:10px;background:#d1fae5;color:#065f46;padding:2px 7px;border-radius:8px;font-weight:700;">Aktif</span>
                    @else
                        <span style="font-size:10px;background:#fee2e2;color:#991b1b;padding:2px 7px;border-radius:8px;font-weight:700;">Nonaktif</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="sc-empty">
                <i class="fa fa-cube"></i>
                <p>Belum ada produk.<br><a href="{{ route('products.my-products') }}#tambah" style="color:#D10024;font-weight:600;">Tambahkan produk pertamamu!</a></p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Recent orders --}}
    <div class="sc-card">
        <div class="sc-card-header">
            <div class="sc-section-title"><i class="fa fa-shopping-bag"></i> Pesanan Terbaru</div>
            <a href="{{ route('seller.orders') }}" class="sc-section-link">Lihat Semua <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        <div class="sc-card-body" style="padding:0">
            @forelse($recentOrders as $order)
            <div class="sc-order-row">
                <div class="sc-order-buyer-av">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:700;color:#1e1f29;">#{{ $order->order_number }}</div>
                    <div style="font-size:11px;color:#aaa;">{{ $order->user->name ?? '-' }} &middot; {{ $order->created_at->format('d M Y') }}</div>
                </div>
                <div style="text-align:right;flex-shrink:0;">
                    <div style="font-size:13px;font-weight:700;color:#1e1f29;margin-bottom:3px;">{{ $order->formatted_total }}</div>
                    <span class="sc-status-chip {{ $order->status }}">{{ $order->status_label }}</span>
                </div>
            </div>
            @empty
            <div class="sc-empty" style="padding:30px;">
                <i class="fa fa-shopping-bag"></i>
                <p>Belum ada pesanan masuk.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
