@extends('layouts.app')

@section('title', 'Daftar Pembelian - NusaMart')

@push('styles')
<style>
.orders-page { padding: 30px 0 60px; }
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.page-title { font-size: 22px; font-weight: 700; color: #1e1f29; }
.page-title span { color: #D10024; }

.orders-list { display: flex; flex-direction: column; gap: 16px; }

.order-card {
    background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07);
    overflow: hidden; transition: box-shadow .2s;
}
.order-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.12); }

.order-card-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 20px; border-bottom: 1px solid #f0f0f0; background: #fafafa;
}
.order-number { font-size: 13px; font-weight: 700; color: #1e1f29; }
.order-date { font-size: 12px; color: #888; }
.order-status-badge {
    padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
    color: #fff;
}

.order-card-body { padding: 16px 20px; }
.order-items-preview { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
.order-item-thumb {
    display: flex; align-items: center; gap: 8px; background: #f9f9f9;
    border-radius: 6px; padding: 6px 10px; font-size: 12px; color: #555;
}
.order-item-thumb .fa { color: #ccc; }
.order-more { font-size: 12px; color: #888; align-self: center; }

.order-card-footer {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 20px; border-top: 1px solid #f0f0f0; background: #fafafa;
}
.order-total { font-size: 15px; font-weight: 700; color: #D10024; }
.order-total-label { font-size: 12px; color: #888; margin-bottom: 2px; }

.btn-detail-order {
    padding: 8px 20px; background: #D10024; color: #fff; border-radius: 6px;
    font-size: 13px; font-weight: 600; text-decoration: none; transition: background .2s;
}
.btn-detail-order:hover { background: #a8001e; }

.empty-orders { text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); }
.empty-orders .fa { font-size: 60px; color: #e0e0e0; display: block; margin-bottom: 16px; }
.empty-orders h3 { font-size: 18px; color: #555; margin-bottom: 8px; }
.empty-orders p { font-size: 13px; color: #999; margin-bottom: 24px; }
.btn-shop { display: inline-block; padding: 12px 28px; background: #D10024; color: #fff; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; }
.btn-shop:hover { background: #a8001e; }

.alert-success { background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px; }

.tracking-info { font-size: 12px; color: #555; }
.tracking-info .fa { margin-right: 4px; }
</style>
@endpush

@section('content')
<div class="container orders-page">
    <div class="page-header">
        <h1 class="page-title">Daftar <span>Pembelian</span></h1>
        <a href="{{ route('products.index') }}" style="font-size:13px;color:#D10024;font-weight:600;">
            <i class="fa fa-plus"></i> Belanja Lagi
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <div class="empty-orders">
            <i class="fa fa-shopping-bag"></i>
            <h3>Belum Ada Pembelian</h3>
            <p>Anda belum pernah melakukan pembelian. Mulai belanja sekarang!</p>
            <a href="{{ route('products.index') }}" class="btn-shop">
                <i class="fa fa-store"></i> Mulai Belanja
            </a>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-card-header">
                    <div>
                        <div class="order-number">{{ $order->order_number }}</div>
                        <div class="order-date"><i class="fa fa-calendar" style="margin-right:4px;"></i>{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <span class="order-status-badge" style="background: {{ $order->status_color }};">
                        {{ $order->status_label }}
                    </span>
                </div>

                <div class="order-card-body">
                    <div class="order-items-preview">
                        @foreach($order->items->take(3) as $item)
                            <div class="order-item-thumb">
                                <i class="fa fa-shopping-bag"></i>
                                {{ $item->product_name }} (x{{ $item->quantity }})
                            </div>
                        @endforeach
                        @if($order->items->count() > 3)
                            <span class="order-more">+{{ $order->items->count() - 3 }} produk lainnya</span>
                        @endif
                    </div>

                    @if($order->tracking_number)
                        <div class="tracking-info">
                            <i class="fa fa-truck"></i> No. Resi: <strong>{{ $order->tracking_number }}</strong>
                        </div>
                    @endif
                </div>

                <div class="order-card-footer">
                    <div>
                        <div class="order-total-label">Total Pembayaran</div>
                        <div class="order-total">{{ $order->formatted_total }}</div>
                    </div>
                    <a href="{{ route('orders.show', $order) }}" class="btn-detail-order">
                        Lihat Detail <i class="fa fa-arrow-right"></i>
                    </a>
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
