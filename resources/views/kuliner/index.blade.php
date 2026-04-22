@extends('layouts.app')

@section('title', 'Kuliner Lokal Manud Jaya - NusaMart')

@push('styles')
<style>
/* ════════════════════════════════════════
   KULINER INDEX PAGE — voucher-style redesign
   prefix: .kl-
════════════════════════════════════════ */

/* ── Hero Banner ── */
.kl-hero {
    background: linear-gradient(135deg, #1a0533 0%, #D10024 55%, #ff6b35 100%);
    position: relative; overflow: hidden;
    padding: 52px 0 70px;
    margin-bottom: -44px;
}
.kl-hero::after {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Ccircle cx='40' cy='40' r='30' stroke='%23ffffff' stroke-opacity='0.04' stroke-width='1.5'/%3E%3C/g%3E%3C/svg%3E");
}
.kl-blob {
    position: absolute; border-radius: 50%;
    background: rgba(255,255,255,.07);
    animation: klBlobPulse 4s ease-in-out infinite;
}
.kl-blob.b1 { width:340px; height:340px; top:-90px; right:-70px; animation-delay:0s; }
.kl-blob.b2 { width:220px; height:220px; bottom:-70px; left:8%;  animation-delay:1.6s; }
.kl-blob.b3 { width:130px; height:130px; top:10px;   left:38%; animation-delay:.9s; }
@keyframes klBlobPulse { 0%,100%{transform:scale(1);opacity:.6} 50%{transform:scale(1.2);opacity:1} }

.kl-hero-inner { position:relative; z-index:2; text-align:center; }

.kl-hero-icon {
    width:82px; height:82px;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(8px);
    border: 2px solid rgba(255,255,255,.28);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 36px; color: #fff;
    margin-bottom: 16px;
    animation: klIconFloat 3.2s ease-in-out infinite;
}
@keyframes klIconFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-9px)} }

.kl-hero-title {
    font-size: 30px; font-weight: 900; color: #fff;
    text-shadow: 0 4px 18px rgba(0,0,0,.35);
    line-height: 1.2; margin-bottom: 8px;
}
.kl-hero-sub {
    font-size: 14px; color: rgba(255,255,255,.82);
    margin: 0 auto 22px; max-width: 480px;
}
.kl-hero-pills { display:flex; align-items:center; justify-content:center; gap:10px; flex-wrap:wrap; }
.kl-hero-pill {
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.28);
    backdrop-filter: blur(6px);
    color: #fff; font-size: 12px; font-weight: 700;
    padding: 6px 14px; border-radius: 20px;
    display: flex; align-items: center; gap: 6px;
}

/* ── Page wrapper ── */
.kl-page { padding: 0 0 72px; background: #f5f6fa; min-height: 70vh; }

/* ── Shell card ── */
.kl-shell {
    background: #fff;
    border-radius: 22px 22px 0 0;
    position: relative; z-index: 2;
    box-shadow: 0 -6px 24px rgba(0,0,0,.07);
}

/* ── Filter tabs ── */
.kl-tabs {
    display: flex; align-items: center; gap: 4px;
    padding: 20px 24px 0;
    border-bottom: 2px solid #f0f0f4;
    overflow-x: auto; scrollbar-width: none;
}
.kl-tabs::-webkit-scrollbar { display:none; }
.kl-tab {
    background: none; border: none; cursor: pointer;
    font-family: inherit; font-size: 13px; font-weight: 700;
    color: #999; padding: 10px 16px;
    border-bottom: 2.5px solid transparent;
    margin-bottom: -2px; white-space: nowrap;
    transition: all .18s;
    display: flex; align-items: center; gap: 6px;
}
.kl-tab .cnt {
    background: #f0f0f4; color: #888;
    font-size: 10px; font-weight: 800;
    padding: 2px 7px; border-radius: 10px;
    transition: all .18s;
}
.kl-tab.active, .kl-tab:hover { color: #D10024; border-bottom-color: #D10024; }
.kl-tab.active .cnt { background: #fee2e2; color: #D10024; }

/* ── Body ── */
.kl-body { padding: 24px 24px 28px; }

/* ── Grid ── */
.kl-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
}
@media(max-width:600px){ .kl-grid { grid-template-columns: 1fr 1fr; gap:12px; } }
@media(max-width:420px){ .kl-grid { grid-template-columns: 1fr; } }

/* ── Card ── */
.kl-card {
    border-radius: 16px; overflow: hidden;
    position: relative; text-decoration: none;
    color: #fff; display: block; height: 300px;
    box-shadow: 0 4px 18px rgba(0,0,0,.12);
    transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s;
    animation: klCardIn .38s ease both;
}
.kl-card:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 18px 44px rgba(0,0,0,.2); }
@keyframes klCardIn { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
.kl-card:nth-child(1){animation-delay:.04s} .kl-card:nth-child(2){animation-delay:.08s}
.kl-card:nth-child(3){animation-delay:.12s} .kl-card:nth-child(4){animation-delay:.16s}
.kl-card:nth-child(5){animation-delay:.20s} .kl-card:nth-child(6){animation-delay:.24s}
.kl-card:nth-child(n+7){animation-delay:.28s}

/* Shine sweep on hover */
.kl-card::after {
    content: '';
    position: absolute; inset: 0; border-radius: 16px;
    background: linear-gradient(105deg, transparent 38%, rgba(255,255,255,.18) 50%, transparent 62%);
    background-size: 220% 100%; background-position: -100% 0;
    z-index: 4; pointer-events: none; transition: background-position .5s;
}
.kl-card:hover::after { background-position: 200% 0; }

/* background image */
.kl-card-bg {
    position: absolute; inset: 0;
    background: #1e1f29;
    transition: transform .4s;
}
.kl-card:hover .kl-card-bg { transform: scale(1.07); }
.kl-card-bg img { width:100%; height:100%; object-fit:cover; display:block; }
.kl-card-placeholder {
    width:100%; height:100%;
    background: linear-gradient(135deg,#1e1f29,#374151);
    display:flex; align-items:center; justify-content:center;
}
.kl-card-placeholder i { font-size:48px; color:rgba(255,255,255,.1); }

/* gradient overlay */
.kl-card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(0,0,0,.05) 0%,
        rgba(0,0,0,.0) 30%,
        rgba(0,0,0,.6) 65%,
        rgba(0,0,0,.88) 100%
    );
    z-index: 1;
}

/* status badge */
.kl-card-status {
    position: absolute; top: 12px; right: 12px; z-index: 3;
    padding: 4px 10px; border-radius: 20px;
    font-size: 10.5px; font-weight: 700;
    display: flex; align-items: center; gap: 5px;
    backdrop-filter: blur(4px);
}
.kl-s-buka  { background: rgba(16,185,129,.85); color: #fff; }
.kl-s-tutup { background: rgba(239,68,68,.8);  color: #fff; }

/* text content */
.kl-card-content {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 16px 16px 18px; z-index: 2;
}
.kl-card-kat {
    font-size: 10px; font-weight: 700; letter-spacing: .6px;
    text-transform: uppercase; color: rgba(255,255,255,.7); margin-bottom: 5px;
}
.kl-card-nama {
    font-size: 15px; font-weight: 800; color: #fff;
    line-height: 1.3; margin-bottom: 7px;
    text-shadow: 0 1px 4px rgba(0,0,0,.4);
}
.kl-card-meta {
    font-size: 11px; color: rgba(255,255,255,.7);
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
}
.kl-card-meta span { display:flex; align-items:center; gap:4px; }

/* ── Empty state ── */
.kl-empty { text-align: center; padding: 64px 20px; color: #999; }
.kl-empty i { font-size: 52px; display: block; margin-bottom: 16px; color: #ddd; }
.kl-empty h3 { font-size: 18px; color: #555; margin-bottom: 8px; }

/* ════════════════════════════════════════
   KULINER WELCOME POPUP
   prefix: .klp-
════════════════════════════════════════ */
.klp-overlay {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(15, 10, 30, 0.72);
    backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
    animation: klpFadeIn .35s ease;
}
.klp-overlay.klp-hide {
    animation: klpFadeOut .3s ease forwards;
}
@keyframes klpFadeIn  { from{opacity:0} to{opacity:1} }
@keyframes klpFadeOut { from{opacity:1} to{opacity:0} }

.klp-box {
    background: #fff;
    border-radius: 24px;
    max-width: 460px; width: 100%;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,.35);
    animation: klpSlideUp .38s cubic-bezier(.34,1.56,.64,1);
}
@keyframes klpSlideUp { from{transform:translateY(40px) scale(.95);opacity:0} to{transform:translateY(0) scale(1);opacity:1} }

/* header gradient */
.klp-head {
    background: linear-gradient(135deg, #1a0533 0%, #D10024 55%, #ff6b35 100%);
    padding: 36px 28px 28px;
    text-align: center;
    position: relative; overflow: hidden;
}
.klp-head::before {
    content:'';
    position:absolute; inset:0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='22' stroke='%23ffffff' stroke-opacity='0.06' stroke-width='1' fill='none'/%3E%3C/svg%3E");
}
.klp-head-blob {
    position:absolute; border-radius:50%;
    background:rgba(255,255,255,.08);
}
.klp-head-blob.hb1{ width:180px;height:180px; top:-60px; right:-50px; }
.klp-head-blob.hb2{ width:110px;height:110px; bottom:-30px; left:-20px; }

.klp-icon {
    width: 76px; height: 76px;
    background: rgba(255,255,255,.18);
    border: 2px solid rgba(255,255,255,.30);
    backdrop-filter: blur(8px);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 34px; color: #fff;
    margin-bottom: 14px; position: relative; z-index: 1;
    animation: klIconFloat 3.2s ease-in-out infinite;
}
.klp-head-title {
    font-size: 22px; font-weight: 900; color: #fff;
    text-shadow: 0 3px 14px rgba(0,0,0,.3);
    line-height: 1.2; margin-bottom: 6px; position: relative; z-index: 1;
}
.klp-head-sub {
    font-size: 13px; color: rgba(255,255,255,.82);
    margin: 0 auto; max-width: 320px; position: relative; z-index: 1;
}

/* stats row */
.klp-stats {
    display: flex; gap: 0;
    border-bottom: 1px solid #f0f0f4;
}
.klp-stat {
    flex: 1; text-align: center; padding: 16px 8px;
    border-right: 1px solid #f0f0f4;
}
.klp-stat:last-child { border-right: none; }
.klp-stat-num {
    font-size: 22px; font-weight: 900; color: #D10024;
    line-height: 1;
}
.klp-stat-lbl {
    font-size: 10.5px; font-weight: 600; color: #999;
    margin-top: 3px; text-transform: uppercase; letter-spacing: .4px;
}

/* feature pills */
.klp-body { padding: 20px 24px 8px; }
.klp-features {
    display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    margin-bottom: 4px;
}
.klp-feat {
    display: flex; align-items: center; gap: 10px;
    background: #fdf2f2; border-radius: 12px;
    padding: 10px 12px;
}
.klp-feat-icon {
    width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg,#ffd6d6,#ffefef);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: #D10024;
}
.klp-feat-text { font-size: 11.5px; font-weight: 700; color: #444; line-height: 1.35; }
.klp-feat-text small { font-weight: 500; color: #888; display: block; }

/* footer buttons */
.klp-footer { padding: 16px 24px 24px; display: flex; flex-direction: column; gap: 10px; }
.klp-btn-main {
    display: block; width: 100%;
    background: linear-gradient(135deg, #D10024, #ff4455);
    color: #fff; font-weight: 800; font-size: 15px;
    padding: 14px; border-radius: 14px; border: none;
    cursor: pointer; text-align: center; letter-spacing: .3px;
    transition: transform .18s, box-shadow .18s;
    box-shadow: 0 6px 20px rgba(209,0,36,.35);
}
.klp-btn-main:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(209,0,36,.45); }
.klp-btn-skip {
    background: none; border: none; width: 100%;
    color: #aaa; font-size: 12.5px; font-weight: 600;
    cursor: pointer; padding: 4px; letter-spacing: .2px;
    transition: color .18s;
}
.klp-btn-skip:hover { color: #666; }

/* close X button */
.klp-close {
    position: absolute; top: 14px; right: 16px; z-index: 10;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    color: #fff; font-size: 16px;
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .18s;
}
.klp-close:hover { background: rgba(255,255,255,.32); }

@media(max-width:480px){
    .klp-features { grid-template-columns: 1fr; }
    .klp-head-title { font-size: 20px; }
}
</style>
@endpush

@section('content')
@php
    $nowWib = \Carbon\Carbon::now('Asia/Jakarta');
    $kulinersWithStatus = $kuliners->map(function($k) use ($nowWib) {
        $jamBuka  = \Carbon\Carbon::createFromFormat('H:i', $k->jam_buka,  'Asia/Jakarta');
        $jamTutup = \Carbon\Carbon::createFromFormat('H:i', $k->jam_tutup, 'Asia/Jakarta');
        $k->is_open_now = $jamTutup->gt($jamBuka)
            ? $nowWib->between($jamBuka, $jamTutup)
            : ($nowWib->gte($jamBuka) || $nowWib->lte($jamTutup));
        return $k;
    });
    $total = $kulinersWithStatus->count();
    $buka  = $kulinersWithStatus->where('is_open_now', true)->count();
    $tutup = $kulinersWithStatus->where('is_open_now', false)->count();
    $kats  = $kulinersWithStatus->pluck('kategori')->unique()->sort()->values();
@endphp

{{-- ═══ HERO BANNER ═══ --}}
<div class="kl-hero">
    <div class="kl-blob b1"></div>
    <div class="kl-blob b2"></div>
    <div class="kl-blob b3"></div>
    <div class="kl-hero-inner">
        <div class="kl-hero-icon"><i class="fa fa-cutlery"></i></div>
        <div class="kl-hero-title">Kuliner Lokal Manud Jaya</div>
        <p class="kl-hero-sub">Temukan warung dan kuliner lokal pilihan dari Desa Manud Jaya</p>
        <div class="kl-hero-pills">
            <div class="kl-hero-pill"><i class="fa fa-store"></i> {{ $total }} Warung</div>
            <div class="kl-hero-pill"><i class="fa fa-circle" style="font-size:8px;color:#4ade80"></i> {{ $buka }} Buka</div>
            @if($kats->count())
            <div class="kl-hero-pill"><i class="fa fa-tag"></i> {{ $kats->count() }} Kategori</div>
            @endif
        </div>
    </div>
</div>

{{-- ═══ SHELL CARD ═══ --}}
<div class="kl-page">
  <div class="container">
    <div class="kl-shell">

      {{-- Filter tabs --}}
      <div class="kl-tabs" id="klTabs">
          <button class="kl-tab active" onclick="klTab(this,'all')">
              Semua <span class="cnt">{{ $total }}</span>
          </button>
          <button class="kl-tab" onclick="klTab(this,'buka')">
              <i class="fa fa-circle" style="font-size:8px;color:#10b981"></i> Buka <span class="cnt">{{ $buka }}</span>
          </button>
          <button class="kl-tab" onclick="klTab(this,'tutup')">
              <i class="fa fa-circle" style="font-size:8px;color:#ef4444"></i> Tutup <span class="cnt">{{ $tutup }}</span>
          </button>
          @foreach($kats as $kat)
          <button class="kl-tab" onclick="klTab(this,'kat:{{ $kat }}')">
              {{ $kat }} <span class="cnt">{{ $kuliners->where('kategori',$kat)->count() }}</span>
          </button>
          @endforeach
      </div>

      {{-- Body --}}
      <div class="kl-body">
          @if($kuliners->isEmpty())
          <div class="kl-empty">
              <i class="fa fa-cutlery"></i>
              <h3>Belum ada kuliner terdaftar</h3>
              <p>Informasi warung lokal akan segera hadir.</p>
          </div>
          @else
          <div class="kl-grid" id="klGrid">
              @foreach($kulinersWithStatus as $kuliner)
              <a href="{{ route('kuliner.show', $kuliner->id) }}"
                 class="kl-card"
                 data-status="{{ $kuliner->is_open_now ? 'buka' : 'tutup' }}"
                 data-kat="{{ $kuliner->kategori }}">
                  {{-- Background --}}
                  <div class="kl-card-bg">
                      @if($kuliner->gambar)
                          <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}" loading="lazy">
                      @else
                          <div class="kl-card-placeholder"><i class="fa fa-cutlery"></i></div>
                      @endif
                  </div>
                  <div class="kl-card-overlay"></div>
                  <div class="kl-card-status {{ $kuliner->is_open_now ? 'kl-s-buka' : 'kl-s-tutup' }}">
                      <i class="fa fa-circle" style="font-size:7px"></i>
                      {{ $kuliner->is_open_now ? 'Buka' : 'Tutup' }}
                  </div>
                  <div class="kl-card-content">
                      <div class="kl-card-kat">{{ $kuliner->kategori }}</div>
                      <div class="kl-card-nama">{{ $kuliner->nama }}</div>
                      <div class="kl-card-meta">
                          <span><i class="fa fa-clock-o"></i> {{ $kuliner->jam_buka }}–{{ $kuliner->jam_tutup }}</span>
                          <span><i class="fa fa-map-marker"></i> {{ Str::limit($kuliner->alamat, 28) }}</span>
                      </div>
                  </div>
              </a>
              @endforeach
          </div>
          @endif
      </div>

    </div>{{-- end .kl-shell --}}
  </div>
</div>

<script>
var klActive = 'all';

function klTab(btn, filter) {
    document.querySelectorAll('.kl-tab').forEach(function(t){ t.classList.remove('active'); });
    btn.classList.add('active');
    klActive = filter;

    var cards = document.querySelectorAll('#klGrid .kl-card');
    cards.forEach(function(c) {
        var show = false;
        if (filter === 'all')             show = true;
        else if (filter === 'buka')       show = c.dataset.status === 'buka';
        else if (filter === 'tutup')      show = c.dataset.status === 'tutup';
        else if (filter.startsWith('kat:')) show = c.dataset.kat === filter.slice(4);
        c.style.display = show ? '' : 'none';
    });
}
</script>

{{-- ═══ WELCOME POPUP ═══ --}}
@php $nowWib2 = \Carbon\Carbon::now('Asia/Jakarta'); @endphp
<div class="klp-overlay" id="klPopup" role="dialog" aria-modal="true" aria-labelledby="klpTitle">
    <div class="klp-box">
        {{-- Header --}}
        <div class="klp-head">
            <div class="klp-head-blob hb1"></div>
            <div class="klp-head-blob hb2"></div>
            <button class="klp-close" onclick="klpClose()" aria-label="Tutup"><i class="fa fa-times"></i></button>
            <div class="klp-icon"><i class="fa fa-cutlery"></i></div>
            <div class="klp-head-title" id="klpTitle">Kuliner Lokal Manud Jaya</div>
            <p class="klp-head-sub">Jelajahi warung dan kuliner asli khas Desa Manud Jaya yang lezat</p>
        </div>

        {{-- Stats --}}
        <div class="klp-stats">
            <div class="klp-stat">
                <div class="klp-stat-num">{{ $total }}</div>
                <div class="klp-stat-lbl">Warung</div>
            </div>
            <div class="klp-stat">
                <div class="klp-stat-num" style="color:#10b981;">{{ $buka }}</div>
                <div class="klp-stat-lbl">Buka Sekarang</div>
            </div>
            <div class="klp-stat">
                <div class="klp-stat-num">{{ $kats->count() }}</div>
                <div class="klp-stat-lbl">Kategori</div>
            </div>
        </div>

        {{-- Features --}}
        <div class="klp-body">
            <div class="klp-features">
                <div class="klp-feat">
                    <div class="klp-feat-icon"><i class="fa fa-map-marker"></i></div>
                    <div class="klp-feat-text">Lokasi Lengkap <small>Alamat & Google Maps</small></div>
                </div>
                <div class="klp-feat">
                    <div class="klp-feat-icon"><i class="fa fa-clock-o"></i></div>
                    <div class="klp-feat-text">Jam Operasional <small>Info buka & tutup real-time</small></div>
                </div>
                <div class="klp-feat">
                    <div class="klp-feat-icon"><i class="fa fa-whatsapp"></i></div>
                    <div class="klp-feat-text">Kontak WhatsApp <small>Langsung hubungi warung</small></div>
                </div>
                <div class="klp-feat">
                    <div class="klp-feat-icon"><i class="fa fa-tag"></i></div>
                    <div class="klp-feat-text">Filter Kategori <small>Nasi, mie, jajanan & lainnya</small></div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="klp-footer">
            <button class="klp-btn-main" onclick="klpClose()">
                <i class="fa fa-cutlery"></i>&nbsp; Jelajahi Kuliner Sekarang
            </button>
            <button class="klp-btn-skip" onclick="klpClose(true)">
                Jangan tampilkan lagi hari ini
            </button>
        </div>
    </div>
</div>

<script>
(function(){
    var popup = document.getElementById('klPopup');
    if(!popup) return;

    // Key menyimpan kapan popup terakhir ditutup (per hari)
    var storageKey = 'klp_dismissed';
    var today      = new Date().toISOString().slice(0, 10); // YYYY-MM-DD

    // Jika sudah dismiss hari ini → langsung sembunyikan tanpa animasi
    if(localStorage.getItem(storageKey) === today){
        popup.style.display = 'none';
        return;
    }

    // Scroll body lock saat popup terbuka
    document.body.style.overflow = 'hidden';

    // Tutup dengan klik latar belakang
    popup.addEventListener('click', function(e){
        if(e.target === popup) klpClose();
    });

    // Tutup dengan Escape
    document.addEventListener('keydown', function(e){
        if(e.key === 'Escape') klpClose();
    });
})();

function klpClose(remember) {
    var popup = document.getElementById('klPopup');
    if(!popup) return;

    if(remember){
        var today = new Date().toISOString().slice(0, 10);
        localStorage.setItem('klp_dismissed', today);
    }

    popup.classList.add('klp-hide');
    document.body.style.overflow = '';

    setTimeout(function(){ popup.style.display = 'none'; }, 290);
}
</script>
@endsection
