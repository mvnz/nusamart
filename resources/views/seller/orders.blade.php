@extends('layouts.seller')

@section('title', 'Pesanan Masuk - Seller Center NusaMart')

@section('breadcrumb', 'Transaksi / <strong>Pesanan</strong>')

@push('styles')
<style>
/* Filter bar */
.so-filter { display:flex; gap:10px; align-items:center; flex-wrap:wrap; background:#fff; border-radius:12px; padding:16px 20px; box-shadow:0 2px 8px rgba(0,0,0,.05); margin-bottom:16px; }
.so-search { display:flex; align-items:center; flex:1; min-width:180px; border:1.5px solid #e5e7eb; border-radius:8px; overflow:hidden; transition:border .2s; }
.so-search:focus-within { border-color:#D10024; }
.so-search i { padding:0 10px; color:#aaa; font-size:14px; }
.so-search input { flex:1; border:none; outline:none; padding:9px 0; font-size:13px; }
.so-select { padding:9px 14px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; outline:none; cursor:pointer; background:#fff; min-width:120px; transition:border .2s; }
.so-select:focus { border-color:#D10024; }
.so-btn { padding:9px 18px; background:#D10024; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; transition:background .2s; font-family:inherit; }
.so-btn:hover { background:#a8001e; }

/* Status tabs */
.so-tabs { display:flex; gap:0; background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.05); margin-bottom:20px; overflow-x:auto; padding:0 8px; }
.so-tab { padding:13px 16px; font-size:13px; font-weight:600; color:#888; text-decoration:none; white-space:nowrap; border-bottom:3px solid transparent; transition:color .2s, border-color .2s; flex-shrink:0; display:flex; align-items:center; gap:6px; }
.so-tab:hover { color:#D10024; }
.so-tab.active { color:#D10024; border-bottom-color:#D10024; }
.so-tab-count { font-size:11px; background:#f0f1f5; color:#888; padding:1px 7px; border-radius:10px; font-weight:700; }
.so-tab.active .so-tab-count { background:#fff0f0; color:#D10024; }

/* Table card */
.so-card { background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.05); overflow:hidden; }
.so-table { width:100%; border-collapse:collapse; font-size:13px; }
.so-table th { background:#f8f9fb; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#888; padding:12px 16px; text-align:left; border-bottom:1px solid #f0f0f0; }
.so-table td { padding:14px 16px; border-bottom:1px solid #f9f9f9; vertical-align:middle; }
.so-table tr:last-child td { border-bottom:none; }
.so-table tr:hover td { background:#fafafa; }

.so-order-num { font-weight:700; color:#1e1f29; font-size:13px; }
.so-buyer { display:flex; align-items:center; gap:8px; }
.so-buyer-av { width:30px; height:30px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:11px; flex-shrink:0; }
.so-product { max-width:200px; }
.so-product-name { font-size:13px; color:#333; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.so-product-more { font-size:11px; color:#aaa; }
.so-amount { font-weight:700; color:#1e1f29; }
.so-date { font-size:12px; color:#aaa; }

.sc-status-chip { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; }
.sc-status-chip.pending    { background:#fef3c7; color:#92400e; }
.sc-status-chip.processing { background:#dbeafe; color:#1e40af; }
.sc-status-chip.shipped    { background:#ede9fe; color:#5b21b6; }
.sc-status-chip.delivered  { background:#d1fae5; color:#065f46; }
.sc-status-chip.cancelled  { background:#fee2e2; color:#991b1b; }

.so-actions { display:flex; gap:6px; align-items:center; }
.so-action-btn { padding:5px 12px; font-size:11px; font-weight:700; border-radius:6px; cursor:pointer; border:none; font-family:inherit; transition:background .15s; }
.so-action-btn.process { background:#dbeafe; color:#1e40af; }
.so-action-btn.process:hover { background:#bfdbfe; }
.so-action-btn.ship { background:#ede9fe; color:#5b21b6; }
.so-action-btn.ship:hover { background:#ddd6fe; }

.so-order-link { font-weight:700; color:#D10024; font-size:13px; cursor:pointer; text-decoration:none; background:none; border:none; padding:0; font-family:inherit; transition:color .15s; }
.so-order-link:hover { color:#a8001e; text-decoration:underline; }



.alert-success { background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px; }
.so-empty { text-align:center; padding:60px 20px; }
.so-empty i { font-size:48px; color:#e5e7eb; margin-bottom:16px; display:block; }
.so-empty p { font-size:13px; color:#aaa; }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
@endif

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
