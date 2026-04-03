@extends('layouts.app')

@section('title', 'Semua Kategori - NusaMart')

@push('styles')
<style>
.catdir-page { padding: 32px 0 60px; }

/* Alphabet index bar */
.catdir-alpha-bar {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 10px 16px;
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 28px;
    align-items: center;
}
.catdir-alpha-bar-label {
    font-size: 12px;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-right: 8px;
}
.catdir-alpha-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px; height: 30px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    color: #555;
    text-decoration: none;
    transition: all .2s;
}
.catdir-alpha-link:hover { background: #fff0f2; color: #D10024; }
.catdir-alpha-link.has-cats { color: #1a1b28; }
.catdir-alpha-link.has-cats:hover { background: #D10024; color: #fff; }
.catdir-alpha-link.active { background: #D10024; color: #fff; }

/* Header */
.catdir-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}
.catdir-page-title {
    font-size: 22px;
    font-weight: 800;
    color: #1a1b28;
    display: flex;
    align-items: center;
    gap: 10px;
}
.catdir-page-title::before {
    content: '';
    display: inline-block;
    width: 4px; height: 24px;
    background: #D10024;
    border-radius: 4px;
}
.catdir-count {
    font-size: 13px;
    color: #888;
    font-weight: 500;
}

/* Group section */
.catdir-group { margin-bottom: 28px; scroll-margin-top: 80px; }
.catdir-group-letter {
    font-size: 20px;
    font-weight: 800;
    color: #D10024;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 8px;
    margin-bottom: 16px;
}
.catdir-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
}
.catdir-card {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 10px;
    text-decoration: none;
    color: #222;
    font-size: 13px;
    font-weight: 600;
    transition: all .2s;
}
.catdir-card:hover {
    border-color: #D10024;
    background: #fff5f5;
    color: #D10024;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(209,0,36,.1);
}
.catdir-card-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: #fff;
    flex-shrink: 0;
}
.catdir-card-meta {
    font-size: 11px;
    color: #aaa;
    font-weight: 400;
    margin-top: 2px;
}
.catdir-empty {
    text-align: center;
    padding: 60px 20px;
    color: #bbb;
}
.catdir-empty i { font-size: 48px; display: block; margin-bottom: 14px; }
.catdir-empty h3 { font-size: 16px; color: #888; }

@media (max-width: 768px) {
    .catdir-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endpush

@section('content')
@php
$catColors = ['#e74c3c','#3498db','#9b59b6','#27ae60','#e67e22','#16a085','#f39c12','#e91e8c','#1abc9c','#2c3e50'];
$allLetters = range('A', 'Z');
$hasLetters = $grouped->keys()->toArray();
$totalCats = $grouped->flatten()->count();
$colorIdx = 0;
@endphp

<div class="catdir-page">
    <div class="container">

        {{-- Header --}}
        <div class="catdir-page-header">
            <div class="catdir-page-title">Semua Kategori</div>
            <div class="catdir-count">{{ $totalCats }} kategori tersedia</div>
        </div>

        {{-- Alphabet index --}}
        <div class="catdir-alpha-bar">
            <span class="catdir-alpha-bar-label">Direktori menurut:</span>
            @foreach($allLetters as $letter)
            @if(in_array($letter, $hasLetters))
                <a href="#letter-{{ $letter }}" class="catdir-alpha-link has-cats">{{ $letter }}</a>
            @else
                <span class="catdir-alpha-link" style="opacity:.3;cursor:default">{{ $letter }}</span>
            @endif
            @endforeach
        </div>

        @if($grouped->isEmpty())
        <div class="catdir-empty">
            <i class="fa fa-tags"></i>
            <h3>Belum ada kategori</h3>
            <p>Admin belum menambahkan kategori.</p>
        </div>
        @else
        @foreach($grouped->sortKeys() as $letter => $cats)
        <div class="catdir-group" id="letter-{{ $letter }}">
            <div class="catdir-group-letter">{{ $letter }}</div>
            <div class="catdir-grid">
                @foreach($cats as $cat)
                @php $color = $catColors[$colorIdx++ % count($catColors)]; @endphp
                <a href="{{ route('products.index', ['category_id' => $cat->id]) }}" class="catdir-card">
                    <div class="catdir-card-icon" style="background: {{ $color }};">
                        <i class="fa fa-tag"></i>
                    </div>
                    <div>
                        <div>{{ $cat->name }}</div>
                        <div class="catdir-card-meta">{{ $cat->products_count }} produk</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif

    </div>
</div>
@endsection
