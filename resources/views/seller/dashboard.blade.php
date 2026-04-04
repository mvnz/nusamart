@extends('layouts.seller')

@section('title', 'Beranda - Seller Center NusaMart')

@section('breadcrumb')<strong>Beranda</strong> Seller Center
@endsection

@section('content')

{{-- Welcome --}}
<div class="sc-welcome">
    <div>
        <h2>Selamat datang, {{ auth()->user()->name }}! 👋</h2>
        <p>Pantau perkembangan toko dan kelola pesanan dari sini.</p>
    </div>
    <div class="sc-welcome-date">
        <div style="font-size:20px;font-weight:800;">{{ now()->format('d') }}</div>
        <div>{{ now()->translatedFormat('F Y') }}</div>
    </div>
</div>

{{-- ══ Stat cards ══ --}}
<div style="margin-bottom:10px;font-size:13px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;">Penting Hari Ini</div>
<div class="sc-stat-grid">
    <div class="sc-stat-card orange">
        <div class="sc-stat-label orange"><i class="fa fa-bell"></i> Pesanan Baru</div>
        <div class="sc-stat-value">{{ $newOrdersCount }}</div>
        <div class="sc-stat-sub">Menunggu konfirmasi</div>
        <a href="{{ route('seller.orders') }}?status=pending" class="sc-stat-link"><i class="fa fa-arrow-right"></i> Lihat Semua</a>
    </div>
    <div class="sc-stat-card blue">
        <div class="sc-stat-label blue"><i class="fa fa-truck"></i> Siap Dikirim</div>
        <div class="sc-stat-value">{{ $processingCount }}</div>
        <div class="sc-stat-sub">Sedang diproses</div>
        <a href="{{ route('seller.orders') }}?status=processing" class="sc-stat-link"><i class="fa fa-arrow-right"></i> Lihat Semua</a>
    </div>
    <div class="sc-stat-card green">
        <div class="sc-stat-label green"><i class="fa fa-cube"></i> Produk Aktif</div>
        <div class="sc-stat-value">{{ $activeProductsCount }}</div>
        <div class="sc-stat-sub">Dari {{ $totalProductsCount }} total produk</div>
        <a href="{{ route('products.my-products') }}" class="sc-stat-link"><i class="fa fa-arrow-right"></i> Kelola Produk</a>
    </div>
    <div class="sc-stat-card red">
        <div class="sc-stat-label red"><i class="fa fa-money"></i> Pendapatan Bulan Ini</div>
        <div class="sc-stat-value" style="font-size:18px;">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
        <div class="sc-stat-sub">{{ now()->translatedFormat('F Y') }}</div>
        <a href="{{ route('seller.orders') }}?status=delivered" class="sc-stat-link"><i class="fa fa-arrow-right"></i> Riwayat</a>
    </div>
</div>

{{-- ══ Quick actions ══ --}}
<div class="sc-quick-grid">
    <a href="{{ route('products.my-products') }}#tambah" class="sc-quick-btn">
        <div class="icon" style="background:#10b981;"><i class="fa fa-plus"></i></div>
        <span>Tambah Produk</span>
    </a>
    <a href="{{ route('seller.orders') }}" class="sc-quick-btn">
        <div class="icon" style="background:#3b82f6;"><i class="fa fa-shopping-bag"></i></div>
        <span>Daftar Pesanan</span>
    </a>
    <a href="{{ route('profile') }}" class="sc-quick-btn">
        <div class="icon" style="background:#8b5cf6;"><i class="fa fa-user"></i></div>
        <span>Profil Toko</span>
    </a>
    <a href="{{ route('home') }}" class="sc-quick-btn">
        <div class="icon" style="background:#f97316;"><i class="fa fa-eye"></i></div>
        <span>Lihat Marketplace</span>
    </a>
</div>

{{-- ══ Revenue + Products ══ --}}
<div class="sc-two-col">
    {{-- Revenue summary --}}
    <div>
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
    </div>

    {{-- Top products --}}
    <div class="sc-card">
        <div style="padding:16px 20px 12px;border-bottom:1px solid #f5f5f5;">
            <div class="sc-section-header" style="margin-bottom:0;">
                <div class="sc-section-title"><i class="fa fa-cube"></i> Produk Terbaru</div>
                <a href="{{ route('products.my-products') }}" class="sc-section-link">Lihat Semua</a>
            </div>
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
</div>

{{-- ══ Recent orders table ══ --}}
<div class="sc-card">
    <div style="padding:16px 20px 12px;border-bottom:1px solid #f5f5f5;">
        <div class="sc-section-header" style="margin-bottom:0;">
            <div class="sc-section-title"><i class="fa fa-shopping-bag"></i> Pesanan Terbaru</div>
            <a href="{{ route('seller.orders') }}" class="sc-section-link">Lihat Semua</a>
        </div>
    </div>
    <div style="overflow-x:auto;">
        @if($recentOrders->isEmpty())
            <div class="sc-empty" style="padding:40px">
                <i class="fa fa-shopping-bag"></i>
                <p>Belum ada pesanan masuk.</p>
            </div>
        @else
        <table class="sc-table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pembeli</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td><span class="sc-order-num">#{{ $order->order_number }}</span></td>
                    <td>
                        <div class="sc-order-buyer">
                            <div class="sc-order-buyer-av">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</div>
                            <span>{{ $order->user->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="sc-order-product" title="{{ $order->items->pluck('product_name')->join(', ') }}">
                            {{ Str::limit($order->items->first()->product_name ?? '-', 30) }}
                            @if($order->items->count() > 1)
                                <span style="color:#888;font-size:11px;"> +{{ $order->items->count() - 1 }} lainnya</span>
                            @endif
                        </div>
                    </td>
                    <td><span class="sc-order-amount">{{ $order->formatted_total }}</span></td>
                    <td>
                        <span class="sc-status-chip {{ $order->status }}">{{ $order->status_label }}</span>
                    </td>
                    <td><span class="sc-order-date">{{ $order->created_at->format('d M Y') }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection
