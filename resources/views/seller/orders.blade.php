@extends('layouts.seller')

@section('title', 'Pesanan Masuk - Seller Center NusaMart')

@section('breadcrumb')Transaksi / <strong>Pesanan</strong>
@endsection

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
