@extends('layouts.seller')

@section('title', 'Ulasan Produk - Seller Center NusaMart')

@section('breadcrumb')Ulasan / <strong>Kata Pembeli</strong>
@endsection

@section('content')

<style>
/* ─── Hero ─── */
.sr-hero { background:linear-gradient(135deg,#0f0519 0%,#1a0a2e 55%,#2d0a0a 100%); border-radius:18px; padding:28px; margin-bottom:20px; color:#fff; position:relative; overflow:hidden; }
.sr-hero::before { content:''; position:absolute; top:-80px; right:-80px; width:260px; height:260px; background:radial-gradient(circle,rgba(209,0,36,.3) 0%,transparent 65%); pointer-events:none; }
.sr-hero-top { display:flex; align-items:center; gap:16px; margin-bottom:20px; position:relative; z-index:1; }
.sr-hero-icon { width:54px; height:54px; background:rgba(255,255,255,.12); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0; border:1px solid rgba(255,255,255,.2); }
.sr-hero-title { font-size:22px; font-weight:800; margin:0 0 4px; letter-spacing:-.4px; }
.sr-hero-subtitle { font-size:13px; margin:0; opacity:.7; }
.sr-hero-body { display:flex; gap:12px; flex-wrap:wrap; position:relative; z-index:1; align-items:flex-start; }
.sr-hero-avg { display:flex; align-items:center; gap:14px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.16); border-radius:14px; padding:16px 22px; }
.sr-hero-avg-num { font-size:44px; font-weight:800; line-height:1; color:#fbbf24; }
.sr-hero-avg-stars { display:flex; gap:3px; margin:5px 0; }
.sr-hero-avg-star { font-size:17px; color:#fbbf24; }
.sr-hero-avg-star.empty { color:rgba(255,255,255,.3); }
.sr-hero-avg-label { font-size:12px; opacity:.65; }
.sr-hero-stats { display:flex; gap:8px; flex-wrap:wrap; }
.sr-hero-stat { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.16); border-radius:12px; padding:10px 16px; text-align:center; min-width:64px; }
.sr-hero-stat-num { font-size:20px; font-weight:800; line-height:1; }
.sr-hero-stat-label { font-size:11px; opacity:.7; margin-top:3px; font-weight:600; }
.sr-hero-stat-star { color:#fbbf24; }
@media(max-width:768px) { .sr-hero-body { flex-direction:column; } .sr-hero-avg { width:100%; box-sizing:border-box; } }

/* ─── Filter ─── */
.sr-filter { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; align-items:center; }
.sr-dropdown { position:relative; min-width:200px; }
.sr-dropdown-btn { display:flex; align-items:center; justify-content:space-between; gap:8px; padding:9px 14px; border:1.5px solid #e0e0e0; border-radius:8px; font-size:13px; background:#fff; color:#1e1f29; cursor:pointer; user-select:none; transition:border-color .15s; }
.sr-dropdown-btn:hover, .sr-dropdown-btn.open { border-color:#D10024; }
.sr-dropdown-btn .sr-dd-icon { color:#aaa; font-size:11px; transition:transform .2s; }
.sr-dropdown-btn.open .sr-dd-icon { transform:rotate(180deg); color:#D10024; }
.sr-dropdown-list { display:none; position:absolute; top:calc(100% + 4px); left:0; right:0; background:#fff; border:1.5px solid #e0e0e0; border-radius:8px; box-shadow:0 4px 16px rgba(0,0,0,.1); z-index:100; max-height:240px; overflow-y:auto; }
.sr-dropdown-list.open { display:block; }
.sr-dropdown-item { padding:9px 14px; font-size:13px; color:#333; cursor:pointer; transition:background .1s; }
.sr-dropdown-item:hover { background:#fff5f5; color:#D10024; }
.sr-dropdown-item.selected { color:#D10024; font-weight:700; background:#fff5f5; }
.sr-dropdown-item.selected::after { content:'✓'; float:right; }

/* ─── Rating tabs ─── */
.sr-rating-tabs { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:20px; }
.sr-rating-tab { padding:7px 16px; border-radius:20px; font-size:13px; font-weight:600; border:1.5px solid #ddd; background:#fff; color:#555; text-decoration:none; cursor:pointer; transition:.15s; }
.sr-rating-tab.active, .sr-rating-tab:hover { border-color:#D10024; color:#D10024; background:#fff5f5; }

/* ─── Review card ─── */
.sr-card { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); overflow:hidden; margin-bottom:24px; }
.sr-item { padding:18px 22px; border-bottom:1px solid #f3f3f3; transition:background .15s; }
.sr-item:hover { background:#fafbff; }
.sr-item:last-child { border-bottom:none; }
.sr-item-header { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; }
.sr-reviewer { display:flex; align-items:center; gap:10px; }
.sr-avatar { width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg,#D10024,#a8001e); color:#fff; font-weight:700; font-size:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.sr-reviewer-name { font-weight:700; font-size:14px; color:#1e1f29; }
.sr-reviewer-time { font-size:11px; color:#aaa; margin-top:2px; }
.sr-stars { display:flex; gap:2px; }
.sr-star { font-size:15px; color:#f59e0b; }
.sr-star.empty { color:#ddd; }
.sr-product-tag { display:inline-flex; align-items:center; gap:5px; font-size:12px; color:#555; background:#f5f6fa; border-radius:6px; padding:3px 10px; margin-top:6px; border:1px solid #e9eaf0; }
.sr-comment { font-size:14px; color:#333; margin-top:8px; line-height:1.65; }

/* ─── Empty / Misc ─── */
.sr-empty { text-align:center; padding:60px 20px; color:#aaa; }
.sr-empty i { font-size:48px; margin-bottom:16px; display:block; }
.sr-btn { display:inline-block; padding:7px 16px; border-radius:6px; font-size:13px; font-weight:600; background:#D10024; color:#fff; text-decoration:none; border:none; cursor:pointer; }
.sr-btn-outline { background:#fff; color:#D10024; border:1.5px solid #D10024; }
</style>

{{-- Hero Banner --}}
@php
    $totalReviews = $reviews->total();
    $weightedSum = 0;
    foreach([5,4,3,2,1] as $star) { $weightedSum += $star * ($ratingCounts[$star] ?? 0); }
    $avgRating = $totalReviews > 0 ? round($weightedSum / $totalReviews, 1) : 0;
    $fullStars = (int) floor($avgRating);
@endphp
<div class="sr-hero">
    <div class="sr-hero-top">
        <div class="sr-hero-icon"><i class="fa fa-star"></i></div>
        <div>
            <h1 class="sr-hero-title">Ulasan Produk</h1>
            <p class="sr-hero-subtitle">Pantau kepuasan pembeli terhadap produk Anda</p>
        </div>
    </div>
    <div class="sr-hero-body">
        @if($totalReviews > 0)
        <div class="sr-hero-avg">
            <div class="sr-hero-avg-num">{{ $avgRating }}</div>
            <div>
                <div class="sr-hero-avg-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="sr-hero-avg-star {{ $i <= $fullStars ? '' : 'empty' }}">&#9733;</span>
                    @endfor
                </div>
                <div class="sr-hero-avg-label">dari {{ $totalReviews }} ulasan</div>
            </div>
        </div>
        @endif
        <div class="sr-hero-stats">
            @foreach([5,4,3,2,1] as $star)
            <div class="sr-hero-stat">
                <div class="sr-hero-stat-num">{{ $ratingCounts[$star] ?? 0 }}</div>
                <div class="sr-hero-stat-label"><span class="sr-hero-stat-star">&#9733;</span> {{ $star }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('seller.reviews') }}" class="sr-filter" id="srFilterForm">
    <input type="hidden" name="product_id" id="srProductInput" value="{{ request('product_id') }}">
    @if(request('rating'))<input type="hidden" name="rating" value="{{ request('rating') }}">@endif

    <div class="sr-dropdown" id="srDropdown">
        <div class="sr-dropdown-btn" id="srDropdownBtn">
            <span id="srDropdownLabel">
                @if(request('product_id') && ($selectedProduct = $products->firstWhere('id', request('product_id'))))
                    <i class="fa fa-cube" style="margin-right:6px;color:#D10024;"></i>{{ $selectedProduct->name }}
                @else
                    <i class="fa fa-th-list" style="margin-right:6px;color:#aaa;"></i>Semua Produk
                @endif
            </span>
            <i class="fa fa-chevron-down sr-dd-icon"></i>
        </div>
        <div class="sr-dropdown-list" id="srDropdownList">
            <div class="sr-dropdown-item {{ !request('product_id') ? 'selected' : '' }}" data-value="" data-label="Semua Produk">
                <i class="fa fa-th-list" style="margin-right:6px;"></i>Semua Produk
            </div>
            @foreach($products as $p)
            <div class="sr-dropdown-item {{ request('product_id') == $p->id ? 'selected' : '' }}"
                 data-value="{{ $p->id }}" data-label="{{ $p->name }}">
                <i class="fa fa-cube" style="margin-right:6px;"></i>{{ $p->name }}
            </div>
            @endforeach
        </div>
    </div>

    @if(request()->hasAny(['product_id','rating']))
        <a href="{{ route('seller.reviews') }}" class="sr-btn sr-btn-outline">Reset</a>
    @endif
</form>

{{-- Rating filter tabs --}}
<div class="sr-rating-tabs">
    <a href="{{ route('seller.reviews') }}{{ request('product_id') ? '?product_id='.request('product_id') : '' }}"
       class="sr-rating-tab {{ !request('rating') ? 'active' : '' }}">
        Semua
    </a>
    @foreach([5,4,3,2,1] as $star)
    <a href="{{ route('seller.reviews') }}?rating={{ $star }}{{ request('product_id') ? '&product_id='.request('product_id') : '' }}"
       class="sr-rating-tab {{ request('rating') == $star ? 'active' : '' }}">
        &#9733; {{ $star }}
        <span style="font-weight:400;color:#aaa;">({{ $ratingCounts[$star] ?? 0 }})</span>
    </a>
    @endforeach
</div>

{{-- List --}}
<div class="sr-card">
    @if($reviews->isEmpty())
        <div class="sr-empty">
            <i class="fa fa-comment-o"></i>
            <p>Belum ada ulasan.</p>
        </div>
    @else
        @foreach($reviews as $review)
        <div class="sr-item">
            <div class="sr-item-header">
                <div class="sr-reviewer">
                    <div class="sr-avatar">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                    <div>
                        <div class="sr-reviewer-name">{{ $review->user->name ?? 'Pengguna' }}</div>
                        <div class="sr-reviewer-time">{{ $review->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <div class="sr-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="sr-star {{ $i <= $review->rating ? '' : 'empty' }}">&#9733;</span>
                    @endfor
                </div>
            </div>
            <span class="sr-product-tag"><i class="fa fa-cube" style="margin-right:4px;"></i>{{ $review->product->name ?? '-' }}</span>
            <p class="sr-comment">{{ $review->comment }}</p>
        </div>
        @endforeach
    @endif
</div>

{{-- Pagination --}}
@if($reviews->hasPages())
<div style="margin-top:16px;">
    {{ $reviews->withQueryString()->links() }}
</div>
@endif

<script>
(function() {
    const btn  = document.getElementById('srDropdownBtn');
    const list = document.getElementById('srDropdownList');
    const input = document.getElementById('srProductInput');
    const label = document.getElementById('srDropdownLabel');
    const form  = document.getElementById('srFilterForm');

    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        btn.classList.toggle('open');
        list.classList.toggle('open');
    });

    document.addEventListener('click', function() {
        btn.classList.remove('open');
        list.classList.remove('open');
    });

    list.querySelectorAll('.sr-dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const val  = this.dataset.value;
            const text = this.dataset.label;
            input.value = val;
            label.innerHTML = val
                ? '<i class="fa fa-cube" style="margin-right:6px;color:#D10024;"></i>' + text
                : '<i class="fa fa-th-list" style="margin-right:6px;color:#aaa;"></i>' + text;
            list.querySelectorAll('.sr-dropdown-item').forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            btn.classList.remove('open');
            list.classList.remove('open');
            form.submit();
        });
    });
})();
</script>

@endsection
