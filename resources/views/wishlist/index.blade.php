@extends('layouts.app')

@section('title', 'Wishlist Saya - NusaMart')

@push('styles')
<style>
.wishlist-page { padding: 30px 0 60px; }

/* Header row */
.wl-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
}
.wl-title { font-size: 22px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 10px; }
.wl-title i { color: #D10024; }
.wl-count {
    font-size: 12px; font-weight: 700; background: #D10024; color: #fff;
    padding: 3px 10px; border-radius: 20px;
}
.wl-breadcrumb { font-size: 13px; color: #888; margin-bottom: 20px; }
.wl-breadcrumb a { color: #D10024; text-decoration: none; }
.wl-breadcrumb span { margin: 0 6px; }

/* Alerts */
.alert-success { background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px; }
.alert-error { background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px; }

/* Grid */
.wishlist-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
@media(max-width:1100px){ .wishlist-grid { grid-template-columns: repeat(3, 1fr); } }
@media(max-width:768px) { .wishlist-grid { grid-template-columns: repeat(2, 1fr); } }
@media(max-width:480px) { .wishlist-grid { grid-template-columns: 1fr; } }

/* Card */
.wl-card {
    background: #fff; border-radius: 14px; overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    display: flex; flex-direction: column;
    transition: transform .2s, box-shadow .2s;
}
.wl-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }

.wl-card-img {
    aspect-ratio: 1; overflow: hidden; background: #f5f5f5;
    position: relative; display: block;
}
.wl-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
.wl-card:hover .wl-card-img img { transform: scale(1.04); }
.wl-card-img .no-img {
    display: flex; align-items: center; justify-content: center;
    height: 100%; font-size: 48px; color: #d1d5db;
}

/* Remove button overlay */
.wl-remove-overlay {
    position: absolute; top: 8px; right: 8px;
}
.wl-remove-overlay button {
    width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,.9);
    border: none; cursor: pointer; color: #D10024; font-size: 13px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 1px 4px rgba(0,0,0,.15); transition: background .15s;
}
.wl-remove-overlay button:hover { background: #fff; }

.wl-card-body { padding: 14px; display: flex; flex-direction: column; gap: 6px; flex: 1; }
.wl-card-seller { font-size: 11px; color: #aaa; display:flex; align-items:center; gap:4px; }
.wl-card-seller i { color: #D10024; font-size: 10px; }
.wl-card-name {
    font-size: 13px; font-weight: 600; color: #1e1f29;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    line-height: 1.4;
}
.wl-card-price { font-size: 16px; font-weight: 800; color: #D10024; margin-top: 2px; }

.wl-stock-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 6px; width: fit-content;
}
.wl-stock-badge.available { background: #d1fae5; color: #065f46; }
.wl-stock-badge.low       { background: #fef3c7; color: #92400e; }
.wl-stock-badge.out       { background: #fee2e2; color: #991b1b; }

.wl-card-actions { display: flex; flex-direction: column; gap: 7px; margin-top: auto; padding-top: 10px; border-top: 1px solid #f3f4f6; }

.btn-wl-buy {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 9px; background: #D10024; color: #fff; border: none;
    border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;
    text-decoration: none; transition: background .2s; width: 100%;
}
.btn-wl-buy:hover { background: #a8001e; color: #fff; }
.btn-wl-buy:disabled { background: #e5e7eb; cursor: not-allowed; }

.btn-wl-cart {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 9px; background: #fff; color: #D10024; border: 1.5px solid #D10024;
    border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;
    transition: background .2s; width: 100%;
}
.btn-wl-cart:hover { background: #fff0f0; }
.btn-wl-cart:disabled { border-color: #e5e7eb; color: #9ca3af; cursor: not-allowed; }

/* Empty state */
.empty-state { text-align: center; padding: 80px 20px; background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
.empty-state i { font-size: 64px; color: #e5e7eb; margin-bottom: 16px; display: block; }
.empty-state h3 { font-size: 18px; font-weight: 700; color: #374151; margin-bottom: 8px; }
.empty-state p { color: #9ca3af; font-size: 14px; margin-bottom: 24px; }
.btn-browse {
    display: inline-block; padding: 12px 28px; background: #D10024; color: #fff;
    border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 14px; transition: background .2s;
}
.btn-browse:hover { background: #a8001e; color: #fff; }
</style>
@endpush

@section('content')
<div class="container wishlist-page">

    <div class="wl-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span>&rsaquo;</span>
        <span style="color:#333;">Wishlist Saya</span>
    </div>

    <div class="wl-header">
        <h1 class="wl-title">
            <i class="fa fa-heart"></i>
            Wishlist Saya
            <span class="wl-count">{{ $wishlists->total() }}</span>
        </h1>
        <a href="{{ route('products.index') }}" style="font-size:13px;color:#D10024;text-decoration:none;font-weight:600;">
            <i class="fa fa-plus-circle"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    @if($wishlists->isEmpty())
        <div class="empty-state">
            <i class="fa fa-heart-o"></i>
            <h3>Wishlist masih kosong</h3>
            <p>Simpan produk favoritmu di sini agar mudah ditemukan nanti.</p>
            <a href="{{ route('products.index') }}" class="btn-browse">
                <i class="fa fa-search"></i> Jelajahi Produk
            </a>
        </div>
    @else
        <div class="wishlist-grid">
            @foreach($wishlists as $item)
            @if($item->product)
            @php
                $prod = $item->product;
                $outOfStock = $prod->stock === 0;
            @endphp
            <div class="wl-card">

                {{-- Gambar --}}
                <a href="{{ route('products.show', $prod) }}" class="wl-card-img">
                    @if($prod->image)
                        <img src="{{ asset('storage/' . $prod->image) }}" alt="{{ $prod->name }}">
                    @else
                        <div class="no-img"><i class="fa fa-shopping-bag"></i></div>
                    @endif

                    {{-- Hapus overlay --}}
                    <div class="wl-remove-overlay">
                        <form method="POST" action="{{ route('wishlist.destroy', $prod) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus dari wishlist" onclick="event.stopPropagation()">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>
                    </div>
                </a>

                <div class="wl-card-body">
                    <div class="wl-card-seller">
                        <i class="fa fa-store"></i> {{ $prod->seller->name ?? '-' }}
                    </div>
                    <div class="wl-card-name">{{ $prod->name }}</div>
                    <div class="wl-card-price">{{ $prod->formatted_price }}</div>

                    {{-- Stok --}}
                    @if($outOfStock)
                        <span class="wl-stock-badge out"><i class="fa fa-times-circle"></i> Stok Habis</span>
                    @elseif($prod->stock <= 5)
                        <span class="wl-stock-badge low"><i class="fa fa-exclamation-triangle"></i> Sisa {{ $prod->stock }}</span>
                    @else
                        <span class="wl-stock-badge available"><i class="fa fa-check-circle"></i> Tersedia</span>
                    @endif

                    {{-- Aksi --}}
                    <div class="wl-card-actions">
                        {{-- Beli Langsung --}}
                        @if(!$outOfStock)
                        <form method="POST" action="{{ route('cart.buy-now', $prod) }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-wl-buy">
                                <i class="fa fa-bolt"></i> Beli Langsung
                            </button>
                        </form>
                        @else
                            <button class="btn-wl-buy" disabled>
                                <i class="fa fa-bolt"></i> Beli Langsung
                            </button>
                        @endif

                        {{-- Tambah ke Keranjang --}}
                        @if(!$outOfStock)
                        <form method="POST" action="{{ route('cart.add', $prod) }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-wl-cart">
                                <i class="fa fa-shopping-cart"></i> Ke Keranjang
                            </button>
                        </form>
                        @else
                            <button class="btn-wl-cart" disabled>
                                <i class="fa fa-shopping-cart"></i> Ke Keranjang
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div style="margin-top:28px;">
            {{ $wishlists->links() }}
        </div>
    @endif
</div>
@endsection
