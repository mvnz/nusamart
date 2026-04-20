@extends('layouts.app')

@section('title', 'Kuliner Lokal Manud Jaya - NusaMart')

@push('styles')
<style>
/* ====== PAGE ====== */
.kuliner-page { padding: 36px 0 64px; }

/* ====== HEADER ====== */
.kuliner-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-bottom: 24px; gap: 12px; flex-wrap: wrap;
}
.kuliner-header-left h2 {
    font-size: 22px; font-weight: 800; color: #1e1f29;
    display: flex; align-items: center; gap: 10px; margin: 0 0 4px;
}
.kuliner-header-left h2 i { color: #D10024; }
.kuliner-header-left p { color: #888; font-size: 13px; margin: 0; }
.kuliner-nav-btns { display: flex; gap: 8px; }
.kuliner-nav-btn {
    width: 38px; height: 38px; border-radius: 50%;
    background: #fff; border: 1.5px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 14px; color: #555;
    transition: all .2s; box-shadow: 0 2px 8px rgba(0,0,0,.07);
    user-select: none;
}
.kuliner-nav-btn:hover { background: #D10024; border-color: #D10024; color: #fff; box-shadow: 0 4px 14px rgba(209,0,36,.3); }
.kuliner-nav-btn:active { transform: scale(.93); }

/* ====== CAROUSEL WRAPPER ====== */
.kuliner-carousel-outer { position: relative; }
.kuliner-carousel {
    display: flex; gap: 18px;
    overflow-x: auto; scroll-behavior: smooth;
    padding: 8px 2px 20px;
    scrollbar-width: none;
}
.kuliner-carousel::-webkit-scrollbar { display: none; }

/* ====== CARD (full-image style) ====== */
.kuliner-card {
    flex: 0 0 260px;
    height: 340px;
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    text-decoration: none;
    color: #fff;
    display: block;
    cursor: pointer;
    box-shadow: 0 6px 24px rgba(0,0,0,.15);
    transition: transform .25s, box-shadow .25s;
}
.kuliner-card:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 16px 40px rgba(0,0,0,.22); }

/* background image layer */
.kuliner-card-bg {
    position: absolute; inset: 0;
    background: #1e1f29; /* fallback */
    transition: transform .35s;
}
.kuliner-card:hover .kuliner-card-bg { transform: scale(1.06); }
.kuliner-card-bg img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}
.kuliner-card-bg-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg,#1e1f29,#374151);
    display: flex; align-items: center; justify-content: center;
}
.kuliner-card-bg-placeholder i { font-size: 52px; color: rgba(255,255,255,.12); }

/* dark gradient overlay */
.kuliner-card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(0,0,0,.08) 0%,
        rgba(0,0,0,.0)  30%,
        rgba(0,0,0,.55) 65%,
        rgba(0,0,0,.85) 100%
    );
}

/* status badge (top right) */
.kuliner-card-status {
    position: absolute; top: 14px; right: 14px; z-index: 2;
    padding: 4px 10px; border-radius: 20px;
    font-size: 10.5px; font-weight: 700;
    display: flex; align-items: center; gap: 5px;
    backdrop-filter: blur(4px);
}
.kc-buka  { background: rgba(16,185,129,.85); color: #fff; }
.kc-tutup { background: rgba(239,68,68,.8);  color: #fff; }

/* text content (bottom left) */
.kuliner-card-content {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 18px 18px 20px; z-index: 2;
}
.kuliner-card-kat {
    font-size: 10.5px; font-weight: 700; letter-spacing: .6px;
    text-transform: uppercase; color: rgba(255,255,255,.7);
    margin-bottom: 6px;
}
.kuliner-card-nama {
    font-size: 16px; font-weight: 800; color: #fff;
    line-height: 1.3; margin-bottom: 8px;
    text-shadow: 0 1px 4px rgba(0,0,0,.4);
}
.kuliner-card-meta {
    font-size: 11.5px; color: rgba(255,255,255,.7);
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
}
.kuliner-card-meta span { display: flex; align-items: center; gap: 4px; }
.kuliner-card-meta i { font-size: 10px; }

/* ====== EMPTY ====== */
.kuliner-empty { text-align: center; padding: 72px 20px; color: #999; }
.kuliner-empty .fa { font-size: 52px; margin-bottom: 16px; display: block; color: #ddd; }
.kuliner-empty h3 { font-size: 18px; color: #555; margin-bottom: 8px; }

/* ====== FILTER PILLS ====== */
.kuliner-filters {
    display: flex; gap: 8px; margin-bottom: 18px; flex-wrap: wrap;
}
.kuliner-fpill {
    padding: 7px 16px; border-radius: 20px; font-size: 12px; font-weight: 700;
    border: 1.5px solid #e5e7eb; background: #fff; color: #555;
    cursor: pointer; transition: all .18s; font-family: inherit;
}
.kuliner-fpill:hover { border-color: #D10024; color: #D10024; }
.kuliner-fpill.active { background: #D10024; border-color: #D10024; color: #fff; }
</style>
@endpush

@section('content')
<div class="kuliner-page">
    <div class="container">

        {{-- Header --}}
        <div class="kuliner-header">
            <div class="kuliner-header-left">
                <h2><i class="fa fa-cutlery"></i> Kuliner Lokal Manud Jaya</h2>
                <p>Temukan warung dan kuliner lokal pilihan dari Desa Manud Jaya</p>
            </div>
            @if(!$kuliners->isEmpty())
            <div class="kuliner-nav-btns">
                <button class="kuliner-nav-btn" id="klPrev" onclick="klScroll(-1)"><i class="fa fa-chevron-left"></i></button>
                <button class="kuliner-nav-btn" id="klNext" onclick="klScroll(1)"><i class="fa fa-chevron-right"></i></button>
            </div>
            @endif
        </div>

        @if(!$kuliners->isEmpty())
        {{-- Category filter pills --}}
        @php $kats = $kuliners->pluck('kategori')->unique()->sort()->values(); @endphp
        @if($kats->count() > 1)
        <div class="kuliner-filters">
            <button class="kuliner-fpill active" onclick="klFilter(this,'all')">Semua</button>
            @foreach($kats as $kat)
            <button class="kuliner-fpill" onclick="klFilter(this,'{{ $kat }}')">{{ $kat }}</button>
            @endforeach
        </div>
        @endif
        @endif

        @if($kuliners->isEmpty())
            <div class="kuliner-empty">
                <i class="fa fa-cutlery"></i>
                <h3>Belum ada kuliner terdaftar</h3>
                <p>Informasi warung lokal akan segera hadir.</p>
            </div>
        @else
        <div class="kuliner-carousel-outer">
            <div class="kuliner-carousel" id="klCarousel">
                @foreach($kuliners as $kuliner)
                <a href="{{ route('kuliner.show', $kuliner->id) }}"
                   class="kuliner-card"
                   data-kat="{{ $kuliner->kategori }}">
                    {{-- Background image --}}
                    <div class="kuliner-card-bg">
                        @if($kuliner->gambar && file_exists(public_path('uploads/' . $kuliner->gambar)))
                            <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}" loading="lazy">
                        @else
                            <div class="kuliner-card-bg-placeholder">
                                <i class="fa fa-cutlery"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Gradient overlay --}}
                    <div class="kuliner-card-overlay"></div>

                    {{-- Status badge --}}
                    <div class="kuliner-card-status {{ $kuliner->status === 'buka' ? 'kc-buka' : 'kc-tutup' }}">
                        <i class="fa fa-circle" style="font-size:7px"></i>
                        {{ ucfirst($kuliner->status) }}
                    </div>

                    {{-- Text content --}}
                    <div class="kuliner-card-content">
                        <div class="kuliner-card-kat">{{ $kuliner->kategori }}</div>
                        <div class="kuliner-card-nama">{{ $kuliner->nama }}</div>
                        <div class="kuliner-card-meta">
                            <span><i class="fa fa-clock-o"></i> {{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</span>
                            <span><i class="fa fa-map-marker"></i> {{ Str::limit($kuliner->alamat, 30) }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<script>
var klActive = 'all';

function klScroll(dir) {
    var el = document.getElementById('klCarousel');
    el.scrollBy({ left: dir * 560, behavior: 'smooth' });
}

function klFilter(btn, kat) {
    klActive = kat;
    document.querySelectorAll('.kuliner-fpill').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');

    var cards = document.querySelectorAll('#klCarousel .kuliner-card');
    cards.forEach(function(c) {
        c.style.display = (kat === 'all' || c.dataset.kat === kat) ? '' : 'none';
    });
}
</script>
@endsection
