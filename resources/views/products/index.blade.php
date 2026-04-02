@extends('layouts.app')

@section('title', 'Produk - NusaMart')

@push('styles')
<style>
.shop-page { padding: 30px 0 50px; }
.shop-header { margin-bottom: 24px; }
.shop-header h2 { font-size: 22px; font-weight: 700; color: #1e1f29; }
.shop-header p { color: #888; font-size: 13px; margin-top: 4px; }

.shop-filters { display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; align-items: center; }
.shop-filters form { display: flex; gap: 10px; flex: 1; flex-wrap: wrap; }
.shop-filters input, .shop-filters select {
    padding: 9px 14px; border: 1px solid #ddd; border-radius: 6px;
    font-family: inherit; font-size: 13px; outline: none;
}
.shop-filters input { flex: 1; min-width: 180px; }
.shop-filters button {
    padding: 9px 20px; background: #D10024; color: #fff;
    border: none; border-radius: 6px; cursor: pointer; font-family: inherit; font-size: 13px;
}
.shop-filters button:hover { background: #a8001e; }

.products-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;
}

.product-card {
    background: #fff; border-radius: 10px; overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,.07); transition: transform .2s, box-shadow .2s;
}
.product-card:hover { transform: translateY(-4px); box-shadow: 0 6px 20px rgba(0,0,0,.12); }

.product-card-img {
    height: 180px; background: #f0f0f0; display: flex; align-items: center;
    justify-content: center; overflow: hidden;
}
.product-card-img img { width: 100%; height: 100%; object-fit: cover; }
.product-card-img .no-img { font-size: 52px; color: #ccc; }

.product-card-body { padding: 14px; }
.product-card-category { font-size: 11px; color: #D10024; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
.product-card-name { font-size: 14px; font-weight: 600; color: #1e1f29; margin: 6px 0 4px; line-height: 1.4; }
.product-card-seller { font-size: 12px; color: #888; margin-bottom: 10px; }
.product-card-price { font-size: 16px; font-weight: 700; color: #D10024; margin-bottom: 6px; }
.product-card-stock { font-size: 12px; color: #888; margin-bottom: 12px; }
.product-card-stock.low { color: #f59e0b; }
.product-card-stock.out { color: #ef4444; }
.btn-detail {
    display: block; text-align: center; padding: 9px; background: #1e1f29; color: #fff;
    border-radius: 6px; font-size: 13px; font-weight: 500; transition: background .2s;
}
.btn-detail:hover { background: #D10024; }

.empty-state { text-align: center; padding: 60px 20px; color: #999; }
.empty-state .fa { font-size: 52px; margin-bottom: 16px; display: block; }
.empty-state h3 { font-size: 18px; color: #555; margin-bottom: 8px; }

.pagination-wrap { margin-top: 30px; display: flex; justify-content: center; }
</style>
@endpush

@section('content')
<div class="container shop-page">
    <div class="shop-header">
        <h2>Semua Produk</h2>
        <p>Temukan produk pilihan terbaik dari para penjual kami</p>
    </div>

    @if(session('success'))
        <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="shop-filters">
        <form action="{{ route('products.index') }}" method="GET">
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
            <select name="category">
                <option value="">Semua Kategori</option>
                @foreach(['Makanan', 'Minuman', 'Fashion', 'Kerajinan', 'Kesehatan', 'Lainnya'] as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit"><i class="fa fa-search"></i> Cari</button>
        </form>
    </div>

    @if($products->isEmpty())
        <div class="empty-state">
            <i class="fa fa-search"></i>
            <h3>Tidak ada produk ditemukan</h3>
            <p>Coba ubah kata kunci atau kategori pencarian.</p>
        </div>
    @else
        <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card">
                <div class="product-card-img">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fa fa-shopping-bag no-img"></i>
                    @endif
                </div>
                <div class="product-card-body">
                    @if($product->category)
                        <div class="product-card-category">{{ $product->category }}</div>
                    @endif
                    <div class="product-card-name">{{ $product->name }}</div>
                    <div class="product-card-seller"><i class="fa fa-store" style="margin-right:4px;"></i>{{ $product->seller->name }}</div>
                    <div class="product-card-price">{{ $product->formatted_price }}</div>
                    <div class="product-card-stock @if($product->stock == 0) out @elseif($product->stock <= 5) low @endif">
                        @if($product->stock == 0)
                            <i class="fa fa-times-circle"></i> Stok habis
                        @elseif($product->stock <= 5)
                            <i class="fa fa-exclamation-triangle"></i> Sisa {{ $product->stock }}
                        @else
                            <i class="fa fa-check-circle" style="color:#10b981;"></i> Stok: {{ $product->stock }}
                        @endif
                    </div>
                    <a href="{{ route('products.show', $product) }}" class="btn-detail">Lihat Detail</a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
