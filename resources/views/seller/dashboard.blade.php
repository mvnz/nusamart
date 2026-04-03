@extends('layouts.seller')

@section('title', 'Beranda - Seller Center NusaMart')

@section('breadcrumb', '<strong>Beranda</strong> Seller Center')

@push('styles')
<style>
/* ─── Stat cards ─── */
.sc-stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
@media(max-width:1100px) { .sc-stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media(max-width:560px)  { .sc-stat-grid { grid-template-columns: 1fr; } }

.sc-stat-card {
    background: #fff; border-radius: 12px; padding: 20px 20px 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05); display: flex; flex-direction: column; gap: 8px;
    border-top: 3px solid transparent; transition: box-shadow .2s;
}
.sc-stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.1); }
.sc-stat-card.orange { border-top-color: #f97316; }
.sc-stat-card.blue   { border-top-color: #3b82f6; }
.sc-stat-card.green  { border-top-color: #10b981; }
.sc-stat-card.red    { border-top-color: #D10024; }

.sc-stat-label { font-size: 12px; font-weight: 600; color: #888; display: flex; align-items: center; gap: 6px; }
.sc-stat-label i { font-size: 14px; }
.sc-stat-label.orange i { color: #f97316; }
.sc-stat-label.blue   i { color: #3b82f6; }
.sc-stat-label.green  i { color: #10b981; }
.sc-stat-label.red    i { color: #D10024; }

.sc-stat-value { font-size: 28px; font-weight: 800; color: #1e1f29; line-height: 1.1; }
.sc-stat-sub { font-size: 11px; color: #aaa; margin-top: 2px; }
.sc-stat-link { font-size: 12px; font-weight: 600; color: #3b82f6; text-decoration: none; margin-top: 4px; display: inline-flex; align-items: center; gap: 4px; }
.sc-stat-link:hover { color: #1d4ed8; }

/* ─── Quick actions ─── */
.sc-quick-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 28px; }
@media(max-width:768px) { .sc-quick-grid { grid-template-columns: repeat(2, 1fr); } }
.sc-quick-btn {
    background: #fff; border-radius: 10px; padding: 16px 14px;
    text-align: center; text-decoration: none; color: #1e1f29;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); transition: box-shadow .2s, transform .15s;
    display: flex; flex-direction: column; align-items: center; gap: 8px;
}
.sc-quick-btn:hover { box-shadow: 0 4px 14px rgba(0,0,0,.1); transform: translateY(-2px); color: #1e1f29; }
.sc-quick-btn .icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; font-size: 18px; color: #fff;
}
.sc-quick-btn span { font-size: 12px; font-weight: 600; }

/* ─── Section header ─── */
.sc-section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.sc-section-title { font-size: 15px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 8px; }
.sc-section-title i { color: #D10024; }
.sc-section-link { font-size: 12px; color: #D10024; text-decoration: none; font-weight: 600; }
.sc-section-link:hover { color: #a8001e; }

/* ─── Cards ─── */
.sc-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.05); overflow: hidden; margin-bottom: 20px; }
.sc-card-body { padding: 20px; }

/* ─── Orders table ─── */
.sc-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.sc-table th {
    background: #f8f9fb; font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .5px; color: #888; padding: 12px 14px; text-align: left; border-bottom: 1px solid #f0f0f0;
}
.sc-table td { padding: 13px 14px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }
.sc-table tr:last-child td { border-bottom: none; }
.sc-table tr:hover td { background: #fafafa; }

.sc-order-num { font-weight: 700; color: #1e1f29; }
.sc-order-buyer { display: flex; align-items: center; gap: 8px; }
.sc-order-buyer-av {
    width: 28px; height: 28px; background: linear-gradient(135deg,#667eea,#764ba2);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 11px; flex-shrink: 0;
}
.sc-order-product { font-size: 12px; color: #555; max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sc-order-amount { font-weight: 700; color: #1e1f29; }
.sc-order-date { font-size: 12px; color: #aaa; }
.sc-status-chip {
    display: inline-block; padding: 3px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 700; white-space: nowrap;
}
.sc-status-chip.pending    { background: #fef3c7; color: #92400e; }
.sc-status-chip.processing { background: #dbeafe; color: #1e40af; }
.sc-status-chip.shipped    { background: #ede9fe; color: #5b21b6; }
.sc-status-chip.delivered  { background: #d1fae5; color: #065f46; }
.sc-status-chip.cancelled  { background: #fee2e2; color: #991b1b; }

/* ─── Revenue card ─── */
.sc-revenue-card { background: linear-gradient(135deg,#1a1f2e,#2d3748); border-radius: 12px; padding: 28px; color: #fff; margin-bottom: 20px; position: relative; overflow: hidden; }
.sc-revenue-card::after { content: ''; position: absolute; top: -40px; right: -40px; width: 160px; height: 160px; background: rgba(209,0,36,.15); border-radius: 50%; }
.sc-revenue-label { font-size: 12px; font-weight: 600; color: rgba(255,255,255,.6); margin-bottom: 8px; text-transform: uppercase; letter-spacing: .5px; }
.sc-revenue-value { font-size: 30px; font-weight: 800; margin-bottom: 4px; }
.sc-revenue-sub { font-size: 12px; color: rgba(255,255,255,.5); }
.sc-revenue-stats { display: flex; gap: 24px; margin-top: 20px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,.1); flex-wrap: wrap; }
.sc-revenue-stat-item { }
.sc-revenue-stat-label { font-size: 11px; color: rgba(255,255,255,.5); margin-bottom: 3px; }
.sc-revenue-stat-value { font-size: 15px; font-weight: 700; }

/* ─── Two col ─── */
.sc-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
@media(max-width:900px) { .sc-two-col { grid-template-columns: 1fr; } }

/* ─── Product list in card ─── */
.sc-prod-row { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f5f5f5; }
.sc-prod-row:last-child { border-bottom: none; }
.sc-prod-img { width: 40px; height: 40px; border-radius: 8px; object-fit: cover; background: #f0f1f5; flex-shrink: 0; display:flex; align-items:center; justify-content:center; overflow:hidden; }
.sc-prod-img img { width: 100%; height: 100%; object-fit:cover; }
.sc-prod-name { font-size: 13px; font-weight: 600; color: #1e1f29; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sc-prod-price { font-size: 12px; color: #D10024; font-weight: 700; }
.sc-prod-stock { font-size: 11px; color: #888; }

/* ─── Empty state ─── */
.sc-empty { text-align: center; padding: 40px 20px; color: #aaa; }
.sc-empty i { font-size: 40px; margin-bottom: 10px; display: block; }
.sc-empty p { font-size: 13px; }

/* ─── Welcome banner ─── */
.sc-welcome { background: linear-gradient(135deg,#D10024 0%,#ff5c73 100%); border-radius: 12px; padding: 22px 28px; color: #fff; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
.sc-welcome h2 { font-size: 18px; font-weight: 800; margin-bottom: 4px; }
.sc-welcome p { font-size: 13px; opacity: .85; }
.sc-welcome-date { font-size: 12px; opacity: .7; text-align: right; }
</style>
@endpush

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
