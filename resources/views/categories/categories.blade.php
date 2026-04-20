@extends('layouts.app')

@section('title', 'Semua Kategori - NusaMart')

@push('styles')
<style>
/* ===== HERO ===== */
.catpage-hero {
    background: linear-gradient(135deg, #1a0533 0%, #D10024 60%, #ff6b35 100%);
    padding: 48px 0 56px;
    position: relative;
    overflow: hidden;
}
.catpage-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.catpage-hero-inner { position: relative; text-align: center; }
.catpage-hero-title { font-size: 32px; font-weight: 900; color: #fff; margin-bottom: 8px; letter-spacing: -.5px; }
.catpage-hero-sub { font-size: 15px; color: rgba(255,255,255,.75); margin-bottom: 28px; }
.catpage-stats-row { display: flex; justify-content: center; gap: 32px; margin-bottom: 28px; }
.catpage-stat { text-align: center; color: #fff; }
.catpage-stat-num { font-size: 26px; font-weight: 900; display: block; line-height: 1; }
.catpage-stat-label { font-size: 12px; opacity: .75; text-transform: uppercase; letter-spacing: .5px; }
.catpage-search-wrap { max-width: 480px; margin: 0 auto; position: relative; }
.catpage-search-wrap input { width: 100%; padding: 14px 50px 14px 18px; border-radius: 50px; border: none; outline: none; font-size: 14px; box-shadow: 0 4px 20px rgba(0,0,0,.18); color: #333; font-family: inherit; box-sizing: border-box; }
.catpage-search-wrap .catpage-search-icon { position: absolute; right: 18px; top: 50%; transform: translateY(-50%); color: #D10024; font-size: 16px; pointer-events: none; }
/* BODY */
.catpage-body { padding: 32px 0 60px; background: #f7f7fa; }
.catpage-alpha-nav { background: #fff; border-radius: 14px; padding: 10px 16px; display: flex; align-items: center; flex-wrap: wrap; gap: 4px; margin-bottom: 28px; box-shadow: 0 2px 10px rgba(0,0,0,.06); position: sticky; top: 70px; z-index: 100; }
.catpage-alpha-label { font-size: 11px; font-weight: 700; color: #bbb; text-transform: uppercase; letter-spacing: .5px; margin-right: 8px; white-space: nowrap; }
.catpage-alpha-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; font-size: 13px; font-weight: 700; color: #ccc; cursor: default; border: none; background: none; transition: all .2s; font-family: inherit; }
.catpage-alpha-btn.active-letter { color: #1a1b28; cursor: pointer; background: #f5f5f8; }
.catpage-alpha-btn.active-letter:hover, .catpage-alpha-btn.highlighted { background: #D10024; color: #fff; }
/* Group */
.catpage-group { margin-bottom: 36px; scroll-margin-top: 130px; }
.catpage-group-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
.catpage-group-letter { width: 40px; height: 40px; background: linear-gradient(135deg, #D10024, #ff4757); color: #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 900; flex-shrink: 0; box-shadow: 0 4px 12px rgba(209,0,36,.25); }
.catpage-group-count { font-size: 12px; color: #aaa; font-weight: 500; }
/* Cards */
.catpage-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(175px, 1fr)); gap: 14px; }
.catpage-card { background: #fff; border-radius: 16px; padding: 20px 16px 18px; display: flex; flex-direction: column; align-items: center; text-decoration: none; color: #222; border: 1.5px solid #f0f0f0; transition: all .25s; position: relative; overflow: hidden; text-align: center; }
.catpage-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.1); border-color: transparent; }
.catpage-card-icon { width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 22px; color: #fff; margin-bottom: 12px; transition: transform .25s; position: relative; z-index: 1; }
.catpage-card:hover .catpage-card-icon { transform: scale(1.1) rotate(-4deg); }
.catpage-card-name { font-size: 13px; font-weight: 700; color: #1a1b28; line-height: 1.3; margin-bottom: 6px; position: relative; z-index: 1; transition: color .25s; }
.catpage-card:hover .catpage-card-name { color: #D10024; }
.catpage-card-count { font-size: 11px; color: #aaa; font-weight: 500; position: relative; z-index: 1; }
.catpage-card-count span { background: #f5f5f8; padding: 2px 8px; border-radius: 20px; transition: background .25s, color .25s; }
.catpage-card:hover .catpage-card-count span { background: #fff0f2; color: #D10024; }
.catpage-card-arrow { position: absolute; bottom: 12px; right: 14px; font-size: 11px; color: #ddd; transition: color .25s, transform .25s; z-index: 1; }
.catpage-card:hover .catpage-card-arrow { color: #D10024; transform: translateX(3px); }
.catpage-no-results { text-align: center; padding: 60px 20px; color: #bbb; display: none; }
.catpage-no-results i { font-size: 48px; display: block; margin-bottom: 14px; color: #e0e0e0; }
.catpage-empty { text-align: center; padding: 80px 20px; color: #bbb; }
.catpage-empty i { font-size: 56px; display: block; margin-bottom: 16px; color: #e0e0e0; }
@media (max-width: 768px) {
    .catpage-hero { padding: 32px 0 40px; }
    .catpage-hero-title { font-size: 24px; }
    .catpage-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .catpage-stats-row { gap: 20px; }
    .catpage-alpha-nav { top: 56px; }
    .catpage-card-icon { width: 48px; height: 48px; font-size: 18px; }
}
@media (max-width: 480px) {
    .catpage-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endpush

@section('content')
@php
$catColors = [
    '#e74c3c','#3498db','#9b59b6','#27ae60','#e67e22',
    '#16a085','#f39c12','#e91e8c','#1abc9c','#2c3e50',
    '#d35400','#2980b9','#8e44ad','#229954','#f1c40f',
    '#c0392b','#1a5276','#6c3483','#1e8449','#b7950b',
];
$allLetters = range('A', 'Z');
$hasLetters = $grouped->keys()->toArray();
$totalCats = $categories->count();
$colorIdx = 0;
@endphp

<section class="catpage-hero">
    <div class="container catpage-hero-inner">
        <div class="catpage-hero-title"><i class="fa fa-th" style="margin-right:10px;opacity:.85"></i>Semua Kategori</div>
        <div class="catpage-hero-sub">Temukan produk favorit berdasarkan kategori pilihan kamu</div>
        <div class="catpage-stats-row">
            <div class="catpage-stat">
                <span class="catpage-stat-num" id="statCats">{{ $totalCats }}</span>
                <span class="catpage-stat-label">Kategori Aktif</span>
            </div>
            <div class="catpage-stat">
                <span class="catpage-stat-num" id="statProds">{{ $totalProducts }}</span>
                <span class="catpage-stat-label">Total Produk</span>
            </div>
        </div>
        <div class="catpage-search-wrap">
            <input type="text" id="catSearch" placeholder="Cari kategori..." autocomplete="off">
            <i class="fa fa-search catpage-search-icon"></i>
        </div>
    </div>
</section>

<div class="catpage-body">
    <div class="container">
        <div class="catpage-alpha-nav" id="catAlphaNav">
            <span class="catpage-alpha-label">Huruf:</span>
            @foreach($allLetters as $letter)
            @if(in_array($letter, $hasLetters))
                <button class="catpage-alpha-btn active-letter" onclick="scrollToLetter('{{ $letter }}')" data-letter="{{ $letter }}">{{ $letter }}</button>
            @else
                <span class="catpage-alpha-btn">{{ $letter }}</span>
            @endif
            @endforeach
        </div>

        @if($grouped->isEmpty())
        <div class="catpage-empty">
            <i class="fa fa-tags"></i>
            <p style="font-size:16px;font-weight:700;color:#888;margin-bottom:8px">Belum ada kategori</p>
        </div>
        @else
        <div class="catpage-no-results" id="catNoResults">
            <i class="fa fa-search"></i>
            <p style="font-size:15px;font-weight:700;color:#888;margin-bottom:8px">Kategori tidak ditemukan</p>
            <p style="font-size:13px">Coba kata kunci lain</p>
        </div>

        @foreach($grouped->sortKeys() as $letter => $cats)
        <div class="catpage-group" id="letter-{{ $letter }}" data-group="{{ $letter }}">
            <div class="catpage-group-header">
                <div class="catpage-group-letter">{{ $letter }}</div>
                <div>
                    <div style="font-size:14px;font-weight:700;color:#1a1b28">Kategori {{ $letter }}</div>
                    <div class="catpage-group-count">{{ $cats->count() }} kategori</div>
                </div>
            </div>
            <div class="catpage-grid">
                @foreach($cats as $cat)
                @php $color = $catColors[$colorIdx++ % count($catColors)]; @endphp
                <a href="{{ route('products.index', ['category_id' => $cat->id]) }}"
                   class="catpage-card" data-name="{{ strtolower($cat->name) }}">
                    <div class="catpage-card-icon" style="background: {{ $color }}; box-shadow: 0 6px 18px {{ $color }}55;">
                        <i class="fa fa-tag"></i>
                    </div>
                    <div class="catpage-card-name">{{ $cat->name }}</div>
                    <div class="catpage-card-count"><span>{{ $cat->products_count }} produk</span></div>
                    <i class="fa fa-arrow-right catpage-card-arrow"></i>
                </a>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
var catSearchInput = document.getElementById('catSearch');
if (catSearchInput) {
    catSearchInput.addEventListener('input', function() {
        var q = this.value.toLowerCase().trim();
        var groups = document.querySelectorAll('.catpage-group');
        var anyVisible = false;
        groups.forEach(function(group) {
            var groupCards = group.querySelectorAll('.catpage-card');
            var groupVisible = false;
            groupCards.forEach(function(card) {
                var show = !q || (card.dataset.name || '').includes(q);
                card.style.display = show ? '' : 'none';
                if (show) groupVisible = true;
            });
            group.style.display = groupVisible ? '' : 'none';
            if (groupVisible) anyVisible = true;
        });
        var noRes = document.getElementById('catNoResults');
        var alphaNav = document.getElementById('catAlphaNav');
        if (noRes) noRes.style.display = anyVisible ? 'none' : 'block';
        if (alphaNav) alphaNav.style.display = q ? 'none' : '';
    });
}
function scrollToLetter(letter) {
    var el = document.getElementById('letter-' + letter);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        document.querySelectorAll('.catpage-alpha-btn').forEach(function(b) { b.classList.remove('highlighted'); });
        var btn = document.querySelector('[data-letter="' + letter + '"]');
        if (btn) { btn.classList.add('highlighted'); setTimeout(function() { btn.classList.remove('highlighted'); }, 1200); }
    }
}
function animateNum(el, target) {
    var start = 0, step = target / 50;
    var timer = setInterval(function() {
        start += step;
        if (start >= target) { el.textContent = target; clearInterval(timer); return; }
        el.textContent = Math.floor(start);
    }, 16);
}
window.addEventListener('load', function() {
    var sc = document.getElementById('statCats');
    var sp = document.getElementById('statProds');
    if (sc) animateNum(sc, parseInt(sc.textContent));
    if (sp) animateNum(sp, parseInt(sp.textContent));
});
</script>
@endpush
