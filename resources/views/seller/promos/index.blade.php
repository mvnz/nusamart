@extends('layouts.seller')

@section('title', 'Promo Produk - Seller Center NusaMart')

@section('breadcrumb')Promo / <strong>Daftar Promo</strong>@endsection

@section('content')

<style>
/* ───────── HERO BANNER ───────── */
.pi-hero {
    background: linear-gradient(135deg, #1a0a0e 0%, #2d0a15 40%, #D10024 100%);
    border-radius: 18px;
    padding: 28px 32px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    position: relative;
    overflow: hidden;
}
.pi-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
    pointer-events: none;
}
.pi-hero::after {
    content: '';
    position: absolute;
    bottom: -40px; right: 120px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,.03);
    pointer-events: none;
}
.pi-hero-left h1 {
    margin: 0 0 4px;
    font-size: 22px;
    font-weight: 800;
    color: #fff;
}
.pi-hero-left p {
    margin: 0;
    color: rgba(255,255,255,.65);
    font-size: 13px;
}
.pi-hero-stats {
    display: flex;
    gap: 12px;
    flex-shrink: 0;
}
.pi-stat {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 14px;
    padding: 14px 20px;
    text-align: center;
    min-width: 80px;
    backdrop-filter: blur(6px);
    transition: background .2s;
}
.pi-stat:hover { background: rgba(255,255,255,.16); }
.pi-stat-num {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    margin-bottom: 4px;
}
.pi-stat-lbl {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: rgba(255,255,255,.55);
}
.pi-hero-btn {
    background: #fff;
    color: #D10024;
    padding: 11px 22px;
    border: none;
    border-radius: 10px;
    font-weight: 800;
    font-size: 13px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(0,0,0,.2);
}
.pi-hero-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.25); }

/* ───────── FILTER BAR ───────── */
.pi-filter {
    background: #fff;
    border-radius: 14px;
    padding: 14px 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    margin-bottom: 22px;
    display: flex;
    gap: 12px;
    align-items: center;
}
.pi-filter-input {
    flex: 1;
    padding: 10px 14px 10px 36px;
    border: 1.5px solid #e5e7eb;
    border-radius: 9px;
    font-size: 13px;
    font-family: inherit;
    background: #fafafa url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23aaa' stroke-width='2.5'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 12px center;
    transition: border .2s;
}
.pi-filter-input:focus { outline: none; border-color: #D10024; background-color: #fff; }
.pi-filter-tabs {
    display: flex;
    gap: 6px;
}
.pi-tab {
    padding: 8px 16px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    color: #666;
    background: #fff;
    text-decoration: none;
    transition: all .18s;
    white-space: nowrap;
}
.pi-tab:hover { border-color: #D10024; color: #D10024; }
.pi-tab.active { background: #D10024; color: #fff !important; border-color: #D10024; }
.pi-filter-form-btn {
    padding: 10px 18px;
    background: #f4f5f7;
    border: 1.5px solid #e5e7eb;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    color: #555;
    font-family: inherit;
    transition: all .2s;
    white-space: nowrap;
}
.pi-filter-form-btn:hover { background: #D10024; color: #fff; border-color: #D10024; }

/* ───────── CARDS GRID ───────── */
.pi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 18px;
}
.pi-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
    transition: transform .22s, box-shadow .22s;
    position: relative;
    display: flex;
    flex-direction: column;
}
.pi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,.13);
}
/* status-specific accent line at top */
.pi-card::before {
    content: '';
    display: block;
    height: 4px;
    background: var(--accent, #e5e7eb);
}
.pi-card[data-status="active"]::before { --accent: linear-gradient(90deg,#059669,#34d399); background: var(--accent); }
.pi-card[data-status="scheduled"]::before { --accent: linear-gradient(90deg,#d97706,#fbbf24); background: var(--accent); }
.pi-card[data-status="expired"]::before { --accent: linear-gradient(90deg,#9ca3af,#d1d5db); background: var(--accent); }
.pi-card[data-status="inactive"]::before { --accent: linear-gradient(90deg,#ef4444,#fca5a5); background: var(--accent); }

/* product header inside card */
.pi-card-header {
    padding: 16px 18px 12px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.pi-card-thumb {
    width: 54px; height: 54px;
    object-fit: cover;
    border-radius: 10px;
    background: #f3f4f6;
    flex-shrink: 0;
}
.pi-card-thumb-placeholder {
    width: 54px; height: 54px;
    border-radius: 10px;
    background: #f3f4f6;
    display: flex; align-items: center; justify-content: center;
    color: #ccc; font-size: 20px;
    flex-shrink: 0;
}
.pi-card-product-name {
    font-size: 14px;
    font-weight: 800;
    color: #1e1f29;
    line-height: 1.3;
    margin-bottom: 6px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.pi-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .2px;
}
.pi-status-active   { background: #dcfce7; color: #15803d; }
.pi-status-scheduled{ background: #fef3c7; color: #b45309; }
.pi-status-expired  { background: #f3f4f6; color: #6b7280; }
.pi-status-inactive { background: #fee2e2; color: #b91c1c; }

/* price section */
.pi-card-price {
    padding: 10px 18px 12px;
    border-top: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.pi-price-old {
    font-size: 12px;
    text-decoration: line-through;
    color: #9ca3af;
}
.pi-price-new {
    font-size: 20px;
    font-weight: 800;
    color: #D10024;
    letter-spacing: -.3px;
}
.pi-discount-pill {
    background: linear-gradient(135deg,#D10024,#ff4d6d);
    color: #fff;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
    margin-left: auto;
    flex-shrink: 0;
}

/* period + quota */
.pi-card-meta {
    padding: 0 18px 14px;
    font-size: 12px;
    color: #666;
}
.pi-meta-row {
    display: flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 6px;
}
.pi-meta-icon {
    width: 20px; height: 20px;
    border-radius: 6px;
    background: #f3f4f6;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
    color: #888;
    flex-shrink: 0;
}
.pi-quota-wrap {
    margin-top: 10px;
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 10px 12px;
}
.pi-quota-row {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    margin-bottom: 7px;
}
.pi-quota-label { font-weight: 600; color: #555; }
.pi-quota-val   { font-weight: 800; color: #1e1f29; }
.pi-quota-bar {
    height: 7px;
    background: #e5e7eb;
    border-radius: 99px;
    overflow: hidden;
}
.pi-quota-fill {
    height: 100%;
    border-radius: 99px;
    background: linear-gradient(90deg, #D10024, #ff6b6b);
    transition: width .6s ease;
}
.pi-quota-fill.warn { background: linear-gradient(90deg, #f97316, #fb923c); }
.pi-quota-fill.full { background: linear-gradient(90deg, #6b7280, #9ca3af); }
.pi-quota-unlimited {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: 9px 12px;
    font-size: 12px;
    font-weight: 700;
    color: #15803d;
    margin-top: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* actions */
.pi-card-actions {
    padding: 12px 18px 18px;
    display: flex;
    gap: 8px;
    margin-top: auto;
}
.pi-btn {
    flex: 1;
    padding: 9px 10px;
    border: none;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    text-decoration: none;
    transition: all .18s;
    font-family: inherit;
}
.pi-btn-edit     { background: #eff6ff; color: #1d4ed8; }
.pi-btn-edit:hover { background: #dbeafe; }
.pi-btn-deact    { background: #fff7ed; color: #c2410c; }
.pi-btn-deact:hover { background: #fed7aa; }
.pi-btn-act      { background: #f0fdf4; color: #15803d; }
.pi-btn-act:hover { background: #dcfce7; }
.pi-btn-del      { background: #fff1f2; color: #be123c; }
.pi-btn-del:hover { background: #fecdd3; }

/* ───────── EMPTY STATE ───────── */
.pi-empty {
    text-align: center;
    padding: 72px 24px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.pi-empty-icon {
    width: 90px; height: 90px;
    background: linear-gradient(135deg,#fff0f0,#ffe4e6);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
    font-size: 36px;
    color: #D10024;
}
.pi-empty h3 { margin: 0 0 6px; font-size: 18px; font-weight: 800; color: #1e1f29; }
.pi-empty p  { font-size: 13px; color: #aaa; margin: 0 0 24px; }
.pi-empty-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: #D10024; color: #fff;
    padding: 12px 28px; border-radius: 10px;
    text-decoration: none; font-weight: 800; font-size: 14px;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(209,0,36,.3);
}
.pi-empty-btn:hover { background: #a8001e; transform: translateY(-2px); }

/* ───────── ALERT ───────── */
.pi-alert {
    display: flex; gap: 10px; align-items: flex-start;
    padding: 13px 16px; border-radius: 10px; margin-bottom: 20px;
    font-size: 13px;
}
.pi-alert-success { background: #f0fdf4; color: #15803d; border-left: 4px solid #22c55e; }

@media(max-width:640px){
    .pi-hero { flex-direction: column; align-items: flex-start; gap: 16px; }
    .pi-hero-stats { flex-wrap: wrap; }
    .pi-filter { flex-wrap: wrap; }
    .pi-filter-tabs { flex-wrap: wrap; }
    .pi-grid { grid-template-columns: 1fr; }
}
</style>

@php
$allPromos = \App\Models\Promo::where('user_id', auth()->id())->with('product')->get();
$cntActive    = $allPromos->filter(fn($p)=>$p->isActive())->count();
$cntScheduled = $allPromos->filter(fn($p)=>$p->isScheduled())->count();
$cntExpired   = $allPromos->filter(fn($p)=>$p->isExpired())->count();
@endphp

<div>

{{-- SUCCESS --}}
@if(session('success'))
<div class="pi-alert pi-alert-success">
    <i class="fa fa-check-circle" style="margin-top:1px;flex-shrink:0;font-size:15px;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

{{-- HERO BANNER --}}
<div class="pi-hero">
    <div class="pi-hero-left">
        <h1><i class="fa fa-tag" style="margin-right:8px;opacity:.8;"></i>Promo Produk</h1>
        <p>Kelola dan pantau semua promosi produkmu di satu tempat</p>
    </div>
    <div class="pi-hero-stats">
        <div class="pi-stat">
            <div class="pi-stat-num" style="color:#4ade80;">{{ $cntActive }}</div>
            <div class="pi-stat-lbl">Aktif</div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-num" style="color:#fbbf24;">{{ $cntScheduled }}</div>
            <div class="pi-stat-lbl">Terjadwal</div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-num" style="color:#9ca3af;">{{ $cntExpired }}</div>
            <div class="pi-stat-lbl">Berakhir</div>
        </div>
    </div>
    <a href="{{ route('seller.promos.create') }}" class="pi-hero-btn">
        <i class="fa fa-plus"></i> Buat Promo
    </a>
</div>

{{-- FILTER BAR --}}
<div class="pi-filter">
    <form method="GET" style="display:flex;gap:10px;flex:1;align-items:center;min-width:0;" id="piSearchForm">
        <input type="text" name="search" placeholder="Cari nama produk…"
               class="pi-filter-input" value="{{ request('search') }}"
               oninput="clearTimeout(window._piSt);window._piSt=setTimeout(()=>document.getElementById('piSearchForm').submit(),600)">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <button type="submit" class="pi-filter-form-btn"><i class="fa fa-search"></i> Cari</button>
    </form>
    <div class="pi-filter-tabs">
        <a href="{{ request()->fullUrlWithQuery(['status'=>'','page'=>1]) }}" class="pi-tab {{ !request('status') ? 'active' : '' }}">Semua</a>
        <a href="{{ request()->fullUrlWithQuery(['status'=>'active','page'=>1]) }}" class="pi-tab {{ request('status')==='active' ? 'active' : '' }}">✓ Aktif</a>
        <a href="{{ request()->fullUrlWithQuery(['status'=>'scheduled','page'=>1]) }}" class="pi-tab {{ request('status')==='scheduled' ? 'active' : '' }}">⏰ Jadwal</a>
        <a href="{{ request()->fullUrlWithQuery(['status'=>'expired','page'=>1]) }}" class="pi-tab {{ request('status')==='expired' ? 'active' : '' }}">✕ Berakhir</a>
    </div>
</div>

{{-- CARDS --}}
@if($promos->count() > 0)
<div class="pi-grid">
    @foreach($promos as $promo)
    @php
        if ($promo->isActive())        { $status = 'active';    $pillClass = 'pi-status-active';    $pillIcon = '&#x2713;'; $pillText = 'Aktif'; }
        elseif ($promo->isScheduled()) { $status = 'scheduled'; $pillClass = 'pi-status-scheduled'; $pillIcon = '&#x23F0;'; $pillText = 'Terjadwal'; }
        elseif ($promo->isExpired())   { $status = 'expired';   $pillClass = 'pi-status-expired';   $pillIcon = '&#x2715;'; $pillText = 'Berakhir'; }
        else                           { $status = 'inactive';  $pillClass = 'pi-status-inactive';  $pillIcon = '&#x2715;'; $pillText = 'Nonaktif'; }

        $quotaPct = ($promo->quota > 0) ? round($promo->used_quota / $promo->quota * 100) : 0;
        $fillClass = $quotaPct >= 100 ? 'full' : ($quotaPct >= 80 ? 'warn' : '');
    @endphp
    <div class="pi-card" data-status="{{ $status }}">

        {{-- Header --}}
        <div class="pi-card-header">
            @if($promo->product && $promo->product->image)
                <img class="pi-card-thumb" src="{{ asset('storage/'.$promo->product->image) }}" alt="">
            @else
                <div class="pi-card-thumb-placeholder"><i class="fa fa-image"></i></div>
            @endif
            <div style="flex:1;min-width:0;">
                <div class="pi-card-product-name">{{ $promo->product->name ?? '—' }}</div>
                <span class="pi-status-pill {{ $pillClass }}">{!! $pillIcon !!} {{ $pillText }}</span>
            </div>
        </div>

        {{-- Price --}}
        <div class="pi-card-price">
            <span class="pi-price-old">Rp {{ number_format($promo->original_price, 0, ',', '.') }}</span>
            <i class="fa fa-long-arrow-right" style="color:#ccc;font-size:13px;"></i>
            <span class="pi-price-new">Rp {{ number_format($promo->promo_price, 0, ',', '.') }}</span>
            <span class="pi-discount-pill">-{{ $promo->getDiscountPercentage() }}%</span>
        </div>

        {{-- Meta --}}
        <div class="pi-card-meta">
            <div class="pi-meta-row">
                <div class="pi-meta-icon"><i class="fa fa-calendar"></i></div>
                <span>{{ $promo->start_date->format('d M Y, H:i') }}</span>
            </div>
            <div class="pi-meta-row">
                <div class="pi-meta-icon"><i class="fa fa-calendar-times-o"></i></div>
                <span>{{ $promo->end_date->format('d M Y, H:i') }}</span>
            </div>

            @if($promo->quota > 0)
            <div class="pi-quota-wrap">
                <div class="pi-quota-row">
                    <span class="pi-quota-label"><i class="fa fa-users" style="margin-right:4px;"></i>Kuota Terpakai</span>
                    <span class="pi-quota-val">{{ $promo->used_quota }} / {{ $promo->quota }}</span>
                </div>
                <div class="pi-quota-bar">
                    <div class="pi-quota-fill {{ $fillClass }}" style="width:{{ min($quotaPct,100) }}%;"></div>
                </div>
                @if($quotaPct >= 100)
                    <div style="font-size:11px;color:#6b7280;margin-top:5px;text-align:right;">Kuota penuh</div>
                @else
                    <div style="font-size:11px;color:#aaa;margin-top:5px;text-align:right;">{{ 100 - $quotaPct }}% tersisa</div>
                @endif
            </div>
            @else
            <div class="pi-quota-unlimited">
                <i class="fa fa-infinity"></i> Kuota Tidak Terbatas
            </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="pi-card-actions">
            @if(!$promo->isExpired() && !$promo->isActive())
                <a href="{{ route('seller.promos.edit', $promo->id) }}" class="pi-btn pi-btn-edit">
                    <i class="fa fa-pencil"></i> Edit
                </a>
            @endif

            @if($promo->is_active && !$promo->isExpired())
                <form method="POST" action="{{ route('seller.promos.deactivate', $promo->id) }}" style="flex:1;display:flex;">
                    @csrf @method('PATCH')
                    <button type="submit" class="pi-btn pi-btn-deact" style="width:100%;">
                        <i class="fa fa-pause"></i> Nonaktifkan
                    </button>
                </form>
            @elseif(!$promo->is_active && !$promo->isExpired())
                <form method="POST" action="{{ route('seller.promos.activate', $promo->id) }}" style="flex:1;display:flex;">
                    @csrf @method('PATCH')
                    <button type="submit" class="pi-btn pi-btn-act" style="width:100%;">
                        <i class="fa fa-play"></i> Aktifkan
                    </button>
                </form>
            @endif

            <form method="POST" action="{{ route('seller.promos.destroy', $promo->id) }}" style="flex:1;display:flex;"
                  onsubmit="return confirm('Hapus promo untuk produk ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="pi-btn pi-btn-del" style="width:100%;">
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </form>
        </div>

    </div>
    @endforeach
</div>

@if($promos->hasPages())
<div style="margin-top:28px;display:flex;justify-content:center;">
    {{ $promos->links() }}
</div>
@endif

@else
{{-- EMPTY STATE --}}
<div class="pi-empty">
    <div class="pi-empty-icon"><i class="fa fa-tag"></i></div>
    <h3>Belum ada promo</h3>
    <p>{{ request('search') || request('status') ? 'Tidak ada promo yang cocok dengan filter ini.' : 'Anda belum membuat promo apapun. Mulai sekarang!' }}</p>
    @if(!request('search') && !request('status'))
        <a href="{{ route('seller.promos.create') }}" class="pi-empty-btn">
            <i class="fa fa-plus"></i> Buat Promo Pertama
        </a>
    @else
        <a href="{{ route('seller.promos.index') }}" class="pi-empty-btn" style="background:#6b7280;box-shadow:none;">
            <i class="fa fa-times"></i> Reset Filter
        </a>
    @endif
</div>
@endif

</div>

@endsection
