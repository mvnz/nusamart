@extends('layouts.app')

@section('title', 'Daftar Transaksi - NusaMart')

@push('styles')
<style>
.trx-page { padding: 30px 0 60px; }
.trx-title { font-size: 22px; font-weight: 800; color: #1e1f29; margin-bottom: 24px; }

/* Filter bar */
.trx-filter-bar {
    display: flex; gap: 10px; align-items: center; flex-wrap: wrap;
    background: #fff; border-radius: 12px; padding: 16px 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,.06); margin-bottom: 16px;
}
.trx-search-wrap {
    display: flex; align-items: center; flex: 1; min-width: 180px;
    border: 1.5px solid #e0e0e0; border-radius: 8px; overflow: hidden;
    transition: border .2s;
}
.trx-search-wrap:focus-within { border-color: #D10024; }
.trx-search-wrap .fa { padding: 0 10px; color: #aaa; font-size: 14px; }
.trx-search-wrap input {
    flex: 1; border: none; outline: none; padding: 9px 0; font-size: 13px;
    background: transparent; color: #333;
}
.trx-filter-select {
    padding: 9px 14px; border: 1.5px solid #e0e0e0; border-radius: 8px;
    font-size: 13px; outline: none; background: #fff; cursor: pointer;
    transition: border .2s; min-width: 130px;
}
.trx-filter-select:focus { border-color: #D10024; }
.trx-filter-btn {
    padding: 9px 18px; background: #D10024; color: #fff; border: none;
    border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background .2s;
}
.trx-filter-btn:hover { background: #a8001e; }

/* Status tabs */
.trx-status-tabs {
    display: flex; gap: 0; background: #fff; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,.06); margin-bottom: 20px;
    overflow-x: auto; padding: 0 8px;
}
.trx-tab {
    padding: 14px 18px; font-size: 13px; font-weight: 600; color: #888;
    text-decoration: none; white-space: nowrap; border-bottom: 3px solid transparent;
    transition: color .2s, border-color .2s; flex-shrink: 0;
}
.trx-tab:hover { color: #D10024; }
.trx-tab.active { color: #D10024; border-bottom-color: #D10024; }
.trx-tab-reset { color: #D10024; font-weight: 600; }

/* Order cards */
.trx-list { display: flex; flex-direction: column; gap: 12px; }

.trx-card {
    background: #fff; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,.06); overflow: hidden;
}

.trx-card-header {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 20px; border-bottom: 1px solid #f0f0f0;
    flex-wrap: wrap;
}
.trx-card-header .trx-type-icon {
    width: 28px; height: 28px; border-radius: 6px;
    background: #fff0f0; color: #D10024;
    display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;
}
.trx-card-header .trx-type-label { font-size: 13px; font-weight: 600; color: #1e1f29; }
.trx-card-header .trx-date { font-size: 12px; color: #aaa; margin-left: 2px; }
.trx-card-header .trx-status {
    padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; color: #fff;
}
.trx-card-header .trx-order-num { font-size: 12px; color: #bbb; margin-left: auto; }

.trx-card-seller {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 20px 6px; border-bottom: 1px solid #f5f5f5;
}
.trx-seller-icon {
    width: 20px; height: 20px; border-radius: 4px;
    background: linear-gradient(135deg,#D10024,#ff6b6b);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 9px;
}
.trx-seller-name { font-size: 13px; font-weight: 700; color: #1e1f29; }

.trx-card-items { padding: 10px 20px; border-bottom: 1px solid #f0f0f0; }
.trx-item-row {
    display: flex; align-items: center; gap: 12px;
    padding: 8px 0; border-bottom: 1px solid #fafafa;
}
.trx-item-row:last-child { border-bottom: none; padding-bottom: 0; }
.trx-item-img {
    width: 56px; height: 56px; border-radius: 6px; object-fit: cover;
    background: #f5f5f5; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
}
.trx-item-img img { width: 100%; height: 100%; object-fit: cover; border-radius: 6px; }
.trx-item-img .fa { font-size: 20px; color: #ccc; }
.trx-item-info { flex: 1; min-width: 0; }
.trx-item-name { font-size: 13px; font-weight: 600; color: #1e1f29; line-height: 1.4; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.trx-item-meta { font-size: 12px; color: #888; margin-top: 2px; }
.trx-item-subtotal { font-size: 14px; font-weight: 700; color: #1e1f29; text-align: right; flex-shrink: 0; }
.trx-item-subtotal .trx-subtotal-label { font-size: 11px; color: #aaa; font-weight: 400; display: block; }

.trx-more-items { font-size: 12px; color: #888; padding: 6px 0; }

.trx-card-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 20px; flex-wrap: wrap; gap: 10px;
}
.trx-footer-left { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.trx-total-wrap { margin-left: auto; text-align: right; }
.trx-total-label { font-size: 11px; color: #888; }
.trx-total-val { font-size: 15px; font-weight: 800; color: #D10024; }

.trx-btn-detail { font-size: 13px; color: #D10024; font-weight: 600; text-decoration: none; }
.trx-btn-detail:hover { text-decoration: underline; }
.trx-btn-secondary {
    padding: 7px 16px; border: 1.5px solid #e0e0e0; background: #fff;
    color: #555; border-radius: 6px; font-size: 13px; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: border-color .2s;
}
.trx-btn-secondary:hover { border-color: #D10024; color: #D10024; }
.trx-btn-primary {
    padding: 7px 16px; background: #D10024; color: #fff;
    border: none; border-radius: 6px; font-size: 13px; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: background .2s;
}
.trx-btn-primary:hover { background: #a8001e; color: #fff; }
.trx-btn-more {
    width: 32px; height: 32px; border: 1.5px solid #e0e0e0; background: #fff;
    border-radius: 6px; display: flex; align-items: center; justify-content: center;
    color: #888; cursor: pointer; font-size: 16px; font-weight: 700;
    transition: border-color .2s;
}
.trx-btn-more:hover { border-color: #ccc; color: #333; }

/* Empty */
.trx-empty { text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
.trx-empty .fa { font-size: 56px; color: #e0e0e0; display: block; margin-bottom: 14px; }
.trx-empty h3 { font-size: 18px; color: #555; margin-bottom: 8px; }
.trx-empty p { font-size: 13px; color: #999; margin-bottom: 20px; }

.alert-success { background:#d1fae5;border-left:4px solid #27ae60;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px; }
</style>
@endpush

@section('content')
<div class="container trx-page">
    <div class="trx-title">Daftar Transaksi</div>

    @if(session('success'))
        <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Filter bar --}}
    <form action="{{ route('orders.index') }}" method="GET">
        <div class="trx-filter-bar">
            <div class="trx-search-wrap">
                <i class="fa fa-search"></i>
                <input type="text" name="search" placeholder="Cari transaksimu di sini" value="{{ request('search') }}">
            </div>
            <select name="type" class="trx-filter-select">
                <option value="belanja">Belanja</option>
            </select>
            <button type="submit" class="trx-filter-btn"><i class="fa fa-search"></i> Cari</button>
        </div>

        {{-- Status tabs --}}
        @php
            $currentStatus = request('status', 'semua');
            $tabs = [
                'semua'       => 'Semua',
                'berlangsung' => 'Berlangsung',
                'selesai'     => 'Selesai',
                'dibatalkan'  => 'Dibatalkan',
            ];
        @endphp
        <div class="trx-status-tabs">
            @foreach($tabs as $key => $label)
            <a href="{{ route('orders.index', array_merge(request()->except(['status','page']), ['status' => $key])) }}"
               class="trx-tab {{ $currentStatus === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
            @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('orders.index') }}" class="trx-tab trx-tab-reset">Reset Filter</a>
            @endif
        </div>
    </form>

    @if($orders->isEmpty())
        <div class="trx-empty">
            <i class="fa fa-shopping-bag"></i>
            <h3>Tidak Ada Transaksi</h3>
            <p>Belum ada transaksi yang sesuai. Mulai belanja sekarang!</p>
            <a href="{{ route('products.index') }}" class="trx-btn-primary" style="display:inline-block;padding:12px 28px">
                <i class="fa fa-store"></i> Mulai Belanja
            </a>
        </div>
    @else
        <div class="trx-list">
            @foreach($orders as $order)
            @php
                $firstItem = $order->items->first();
                $sellerName = $firstItem?->product?->seller?->name ?? 'NusaMart';
                $moreCount = $order->items->count() - 1;
            @endphp
            <div class="trx-card">
                {{-- Header --}}
                <div class="trx-card-header">
                    <div class="trx-type-icon"><i class="fa fa-shopping-bag"></i></div>
                    <span class="trx-type-label">Belanja</span>
                    <span class="trx-date">{{ $order->created_at->translatedFormat('j M Y') }}</span>
                    <span class="trx-status" style="background:{{ $order->status_color }}">{{ $order->status_label }}</span>
                    <span class="trx-order-num">{{ $order->order_number }}</span>
                </div>

                {{-- Seller --}}
                <div class="trx-card-seller">
                    <div class="trx-seller-icon"><i class="fa fa-store"></i></div>
                    <span class="trx-seller-name">{{ $sellerName }}</span>
                </div>

                {{-- Items --}}
                <div class="trx-card-items">
                    @if($firstItem)
                    <div class="trx-item-row">
                        <div class="trx-item-img">
                            @if($firstItem->product?->image)
                                <img src="{{ asset('storage/' . $firstItem->product->image) }}" alt="{{ $firstItem->product_name }}">
                            @else
                                <i class="fa fa-shopping-bag"></i>
                            @endif
                        </div>
                        <div class="trx-item-info">
                            <div class="trx-item-name">{{ $firstItem->product_name }}</div>
                            <div class="trx-item-meta">{{ $firstItem->quantity }} barang x Rp {{ number_format($firstItem->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="trx-item-subtotal">
                            <span class="trx-subtotal-label">Total Belanja</span>
                            {{ $order->formatted_total }}
                        </div>
                    </div>
                    @if($moreCount > 0)
                        <div class="trx-more-items"><i class="fa fa-plus-circle" style="color:#D10024;margin-right:4px"></i>{{ $moreCount }} produk lainnya</div>
                    @endif
                    @endif
                </div>

                {{-- Footer --}}
                <div class="trx-card-footer">
                    <div class="trx-footer-left">
                        <a href="{{ route('orders.show', $order) }}" class="trx-btn-detail">Lihat Detail Transaksi</a>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px">
                        @if($order->status === 'delivered')
                        <a href="{{ route('orders.show', $order) }}" class="trx-btn-secondary">Ulas</a>
                        @endif
                        <a href="{{ route('products.index') }}" class="trx-btn-primary">Beli Lagi</a>
                        <div class="trx-btn-more" title="Lainnya">&hellip;</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top:24px;display:flex;justify-content:center;">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

