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

@if($selectedCategory)
@php
$catBannerColors = ['#e74c3c','#3498db','#9b59b6','#27ae60','#e67e22','#16a085','#f39c12','#e91e8c','#1abc9c','#2c3e50'];
$catIdx = ($selectedCategory->id - 1) % count($catBannerColors);
$bannerColor = $catBannerColors[$catIdx];
@endphp
<style>
.cat-hero {
    background: linear-gradient(135deg, {{ $bannerColor }}, {{ $bannerColor }}cc);
    padding: 40px 0 32px;
    margin-bottom: 0;
    position: relative;
    overflow: hidden;
}
.cat-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}
.cat-hero::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 160px; height: 160px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
}
.cat-hero-inner {
    display: flex;
    align-items: center;
    gap: 24px;
    position: relative;
    z-index: 1;
}
.cat-hero-icon {
    width: 72px; height: 72px;
    background: rgba(255,255,255,0.18);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 32px; color: #fff;
    flex-shrink: 0;
    backdrop-filter: blur(4px);
    border: 2px solid rgba(255,255,255,0.25);
}
.cat-hero-info { flex: 1; }
.cat-hero-breadcrumb {
    font-size: 12px;
    color: rgba(255,255,255,0.7);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.cat-hero-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }
.cat-hero-breadcrumb a:hover { color: #fff; }
.cat-hero-title {
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 6px;
    line-height: 1.2;
}
.cat-hero-meta {
    font-size: 13px;
    color: rgba(255,255,255,0.8);
    display: flex;
    align-items: center;
    gap: 16px;
}
.cat-hero-meta span { display: flex; align-items: center; gap: 5px; }
</style>
<div class="cat-hero">
    <div class="container">
        <div class="cat-hero-inner">
            <div class="cat-hero-icon"><i class="fa fa-tag"></i></div>
            <div class="cat-hero-info">
                <div class="cat-hero-breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <i class="fa fa-chevron-right" style="font-size:9px"></i>
                    <a href="{{ route('products.index') }}">Semua Produk</a>
                    <i class="fa fa-chevron-right" style="font-size:9px"></i>
                    <span style="color:#fff">{{ $selectedCategory->name }}</span>
                </div>
                <div class="cat-hero-title">{{ $selectedCategory->name }}</div>
                <div class="cat-hero-meta">
                    <span><i class="fa fa-cube"></i> {{ $products->total() }} produk ditemukan</span>
                    @if(request('search'))
                    <span><i class="fa fa-search"></i> "{{ request('search') }}"</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container shop-page">
    @if(!$selectedCategory)
    <div class="shop-header">
        <h2>Semua Produk</h2>
        <p>Temukan produk pilihan terbaik dari para penjual kami</p>
    </div>
    @else
    <div style="height:24px"></div>
    @endif

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
            @if(request('category_id'))<input type="hidden" name="category_id" value="{{ request('category_id') }}">@endif
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
            <button type="submit"><i class="fa fa-search"></i> Cari</button>
            <select name="per_page" onchange="this.form.submit()">
                <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12 per halaman</option>
                <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 per halaman</option>
                <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48 per halaman</option>
            </select>
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
