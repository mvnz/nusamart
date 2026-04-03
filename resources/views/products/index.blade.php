@extends('layouts.app')

@section('title', 'Produk - NusaMart')

@push('styles')
<style>
/* ===== SHOP PAGE ===== */
.shop-page { padding: 24px 0 50px; }
.shop-header { margin-bottom: 20px; }
.shop-header h2 { font-size: 22px; font-weight: 700; color: #1e1f29; }
.shop-header p { color: #888; font-size: 13px; margin-top: 4px; }

/* ===== FILTER BAR ===== */
.shop-filter-bar {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    border: 1px solid #f0f0f0;
    padding: 14px 16px;
    margin-bottom: 24px;
}
.shop-filter-bar form {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}
.shop-filter-bar input[type="text"] {
    flex: 1;
    min-width: 0;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-family: inherit;
    font-size: 13px;
    outline: none;
    transition: border-color .2s;
}
.shop-filter-bar input[type="text"]:focus { border-color: #D10024; }
.shop-filter-bar select {
    padding: 10px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-family: inherit;
    font-size: 13px;
    cursor: pointer;
    background: #fafafa;
    outline: none;
    color: #555;
}
.shop-filter-bar button[type="submit"] {
    padding: 10px 20px;
    background: #D10024;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-family: inherit;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    transition: background .2s;
}
.shop-filter-bar button[type="submit"]:hover { background: #a8001e; }

/* ===== PRODUCT GRID ===== */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
}

/* ===== PRODUCT CARD ===== */
.product-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
    border: 1px solid #f0f0f0;
    transition: transform .2s, box-shadow .2s;
    display: flex;
    flex-direction: column;
}
.product-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.11); }

.product-card-img {
    height: 170px;
    background: #f7f7f7;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}
.product-card-img img { width: 100%; height: 100%; object-fit: cover; }
.product-card-img .no-img { font-size: 48px; color: #ddd; }

.product-card-body { padding: 12px 14px 14px; flex: 1; display: flex; flex-direction: column; }
.product-card-category {
    font-size: 10px; color: #D10024; font-weight: 700;
    text-transform: uppercase; letter-spacing: .6px;
    background: rgba(209,0,36,.07); display: inline-block;
    padding: 2px 7px; border-radius: 20px; margin-bottom: 6px;
}
.product-card-name {
    font-size: 13px; font-weight: 600; color: #1e1f29;
    margin-bottom: 4px; line-height: 1.45;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.product-card-seller { font-size: 11px; color: #aaa; margin-bottom: 8px; display: flex; align-items: center; gap: 4px; }
.product-card-price { font-size: 15px; font-weight: 800; color: #D10024; margin-bottom: 4px; }
.product-card-stock { font-size: 11px; color: #aaa; margin-bottom: 10px; flex: 1; }
.product-card-stock.low { color: #f59e0b; }
.product-card-stock.out { color: #ef4444; }
.btn-detail {
    display: block; text-align: center; padding: 8px;
    background: linear-gradient(135deg,#1e1f29,#2d2e3a);
    color: #fff; border-radius: 7px; font-size: 12px; font-weight: 600;
    transition: background .2s; letter-spacing: .3px;
}
.btn-detail:hover { background: linear-gradient(135deg,#D10024,#a8001e); color: #fff; }

/* ===== EMPTY STATE ===== */
.empty-state {
    text-align: center; padding: 60px 20px; color: #bbb;
    background: #fff; border-radius: 16px; border: 1px solid #f0f0f0;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
}
.empty-state .empty-icon {
    width: 72px; height: 72px; border-radius: 50%;
    background: #f5f5f5; display: flex; align-items: center;
    justify-content: center; margin: 0 auto 16px;
}
.empty-state .empty-icon .fa { font-size: 30px; color: #ccc; }
.empty-state h3 { font-size: 17px; color: #555; margin-bottom: 6px; font-weight: 700; }
.empty-state p { font-size: 13px; color: #aaa; }
.empty-state .btn-reset {
    display: inline-flex; align-items: center; gap: 6px; margin-top: 16px;
    padding: 9px 20px; background: #D10024; color: #fff;
    border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none;
    transition: background .2s;
}
.empty-state .btn-reset:hover { background: #a8001e; }

.pagination-wrap { margin-top: 30px; display: flex; justify-content: center; }

/* ===== MOBILE ===== */
@media(max-width:768px){
    .products-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .product-card-img { height: 140px; }
    .product-card-body { padding: 10px 10px 12px; }
    .product-card-price { font-size: 14px; }
    .shop-filter-bar form { gap: 8px; }
    .shop-filter-bar input[type="text"] { min-width: 0; }
    .shop-filter-bar select { width: 100%; }
    .shop-filter-bar button[type="submit"] { width: 100%; justify-content: center; }
}
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
@media(max-width:768px){
    .cat-hero { padding: 24px 0 20px; }
    .cat-hero-icon { width: 52px; height: 52px; font-size: 22px; border-radius: 14px; }
    .cat-hero-title { font-size: 20px; }
    .cat-hero-meta { font-size: 12px; gap: 10px; flex-wrap: wrap; }
}
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


    <div class="shop-filter-bar">
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
            <div class="empty-icon"><i class="fa fa-search"></i></div>
            <h3>Tidak ada produk ditemukan</h3>
            <p>Coba ubah kata kunci atau kategori pencarian.</p>
            <a href="{{ route('products.index') }}" class="btn-reset"><i class="fa fa-refresh"></i> Reset Pencarian</a>
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
