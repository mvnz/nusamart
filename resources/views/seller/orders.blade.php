@extends('layouts.seller')

@section('title', 'Pesanan Masuk - Seller Center NusaMart')

@section('breadcrumb')Transaksi / <strong>Pesanan</strong>
@endsection

@push('styles')
<style>
.so-hero { background:linear-gradient(135deg,#0f0519 0%,#1a0a2e 55%,#2d0a0a 100%); border-radius:18px; padding:28px 28px 24px; margin-bottom:20px; display:flex; align-items:center; gap:20px; flex-wrap:wrap; color:#fff; position:relative; overflow:hidden; }
.so-hero::before { content:''; position:absolute; top:-80px; right:-80px; width:260px; height:260px; background:radial-gradient(circle,rgba(209,0,36,.3) 0%,transparent 65%); pointer-events:none; }
.so-hero-left { display:flex; align-items:center; gap:16px; flex:1; min-width:200px; position:relative; z-index:1; }
.so-hero-icon { width:54px; height:54px; background:rgba(255,255,255,.12); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0; border:1px solid rgba(255,255,255,.2); }
.so-hero-title { font-size:22px; font-weight:800; margin:0 0 4px; letter-spacing:-.4px; }
.so-hero-sub { font-size:13px; margin:0; opacity:.7; }
.so-hero-stats { display:flex; gap:10px; flex-wrap:wrap; position:relative; z-index:1; }
.so-hero-stat { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.16); border-radius:12px; padding:12px 18px; text-align:center; min-width:76px; }
.so-hero-stat-num { font-size:24px; font-weight:800; line-height:1; }
.so-hero-stat-label { font-size:11px; opacity:.7; margin-top:4px; font-weight:600; letter-spacing:.3px; text-transform:uppercase; }
.so-hero-stat-num.pending-num { color:#fcd34d; }
.so-hero-stat-num.processing-num { color:#6ee7b7; }
.so-hero-stat-num.shipped-num { color:#93c5fd; }
.so-hero-stat-num.done-num { color:#a7f3d0; }
.alert-success { display:flex; align-items:center; gap:9px; padding:12px 16px; background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; border-radius:10px; font-size:13px; font-weight:600; margin-bottom:16px; }
@media(max-width:768px) { .so-hero { flex-direction:column; align-items:flex-start; } .so-hero-stats { width:100%; } }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
@endif

{{-- Hero Banner --}}
<div class="so-hero">
    <div class="so-hero-left">
        <div class="so-hero-icon"><i class="fa fa-shopping-bag"></i></div>
        <div>
            <h1 class="so-hero-title">Pesanan Masuk</h1>
            <p class="so-hero-sub">Kelola dan proses pesanan pembeli Anda</p>
        </div>
    </div>
    <div class="so-hero-stats">
        <div class="so-hero-stat">
            <div class="so-hero-stat-num">{{ $counts['all'] }}</div>
            <div class="so-hero-stat-label">Total</div>
        </div>
        <div class="so-hero-stat">
            <div class="so-hero-stat-num pending-num">{{ $counts['pending'] }}</div>
            <div class="so-hero-stat-label">Menunggu</div>
        </div>
        <div class="so-hero-stat">
            <div class="so-hero-stat-num processing-num">{{ $counts['processing'] }}</div>
            <div class="so-hero-stat-label">Diproses</div>
        </div>
        <div class="so-hero-stat">
            <div class="so-hero-stat-num shipped-num">{{ $counts['shipped'] }}</div>
            <div class="so-hero-stat-label">Dikirim</div>
        </div>
        <div class="so-hero-stat">
            <div class="so-hero-stat-num done-num">{{ $counts['delivered'] }}</div>
            <div class="so-hero-stat-label">Selesai</div>
        </div>
    </div>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('seller.orders') }}" class="so-filter">
    <div class="so-search">
        <i class="fa fa-search"></i>
        <input type="text" name="search" placeholder="Cari no. pesanan / pembeli..." value="{{ request('search') }}">
    </div>
    <input type="hidden" name="status" value="{{ request('status') }}">
    <button type="submit" class="so-btn"><i class="fa fa-search"></i> Cari</button>
    @if(request()->hasAny(['search','status']))
        <a href="{{ route('seller.orders') }}" style="font-size:13px;color:#D10024;font-weight:600;text-decoration:none;">Reset</a>
    @endif
</form>

{{-- Status tabs --}}
<div class="so-tabs">
    @php
        $tabs = ['Semua'=>'', 'Menunggu'=>'pending', 'Diproses'=>'processing', 'Dikirim'=>'shipped', 'Selesai'=>'delivered', 'Dibatalkan'=>'cancelled'];
        $countKeys = [''=> 'all','pending'=>'pending','processing'=>'processing','shipped'=>'shipped','delivered'=>'delivered','cancelled'=>'cancelled'];
    @endphp
    @foreach($tabs as $label => $val)
    <a href="{{ route('seller.orders') }}?status={{ $val }}{{ request('search') ? '&search='.request('search') : '' }}"
       class="so-tab {{ request('status', '') === $val ? 'active' : '' }}">
        {{ $label }}
        <span class="so-tab-count">{{ $counts[$countKeys[$val]] }}</span>
    </a>
    @endforeach
</div>

{{-- Table --}}
<div class="so-card">
    <div style="overflow-x:auto;">
        @if($orders->isEmpty())
            <div class="so-empty">
                <i class="fa fa-shopping-bag"></i>
                <p>Tidak ada pesanan ditemukan.</p>
            </div>
        @else
        <table class="so-table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pembeli</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><a class="so-order-link" href="{{ route('seller.orders.show', $order) }}">#{{ $order->order_number }}</a></td>
                    <td>
                        <div class="so-buyer">
                            <div class="so-buyer-av">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</div>
                            <div>
                                <div style="font-size:13px;font-weight:600;">{{ $order->user->name ?? '-' }}</div>
                                <div style="font-size:11px;color:#aaa;">{{ $order->shipping_city }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="so-product">
                            <div class="so-product-name">{{ Str::limit($order->items->first()->product_name ?? '-', 28) }}</div>
                            @if($order->items->count() > 1)
                                <div class="so-product-more">+{{ $order->items->count() - 1 }} produk lainnya</div>
                            @endif
                        </div>
                    </td>
                    <td><span class="so-amount">{{ $order->formatted_total }}</span></td>
                    <td><span class="sc-status-chip {{ $order->status }}">{{ $order->status_label }}</span></td>
                    <td><span class="so-date">{{ $order->created_at->format('d M Y') }}<br>{{ $order->created_at->format('H:i') }}</span></td>
                    <td>
                        <div class="so-actions">
                            @if($order->status === 'pending')
                                <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="so-action-btn process">
                                        <i class="fa fa-check"></i> Proses
                                    </button>
                                </form>
                            @elseif($order->status === 'processing')
                                <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="shipped">
                                    <button type="submit" class="so-action-btn ship">
                                        <i class="fa fa-truck"></i> Kirim
                                    </button>
                                </form>
                            @else
                                <span style="font-size:12px;color:#ccc;">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    @if($orders->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #f5f5f5;">
        {{ $orders->links() }}
    </div>
    @endif
</div>



@endsection
