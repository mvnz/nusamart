@extends('layouts.app')

@section('title', 'Voucher - NusaMart')

@push('styles')
<style>
/* ════════════════════════════════════════
   VOUCHER PAGE — REDESIGN
   ════════════════════════════════════════ */

/* ── Hero Banner ── */
.vc-hero {
    background: linear-gradient(135deg, #1a0533 0%, #D10024 50%, #ff6b35 100%);
    position: relative;
    overflow: hidden;
    padding: 52px 0 70px;
    margin-bottom: -44px;
}
.vc-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Ccircle cx='40' cy='40' r='30' stroke='%23ffffff' stroke-opacity='0.04' stroke-width='1.5'/%3E%3C/g%3E%3C/svg%3E");
}
.vc-hero-blob {
    position: absolute; border-radius: 50%;
    background: rgba(255,255,255,.07);
    animation: blobPulse 4s ease-in-out infinite;
}
.vc-hero-blob.b1 { width:340px; height:340px; top:-90px; right:-70px; animation-delay:0s; }
.vc-hero-blob.b2 { width:220px; height:220px; bottom:-70px; left:8%;  animation-delay:1.6s; }
.vc-hero-blob.b3 { width:130px; height:130px; top:10px;   left:38%; animation-delay:.9s; }
@keyframes blobPulse { 0%,100%{transform:scale(1);opacity:.6} 50%{transform:scale(1.2);opacity:1} }

.vc-hero-inner { position:relative; z-index:2; text-align:center; }

.vc-hero-icon {
    width:82px; height:82px;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(8px);
    border: 2px solid rgba(255,255,255,.28);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 38px; color: #fff;
    margin-bottom: 16px;
    animation: iconFloat 3.2s ease-in-out infinite;
}
@keyframes iconFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-9px)} }

.vc-hero-title {
    font-size: 30px; font-weight: 900; color: #fff;
    text-shadow: 0 4px 18px rgba(0,0,0,.35);
    line-height: 1.2; margin-bottom: 8px;
}
.vc-hero-sub {
    font-size: 14px; color: rgba(255,255,255,.82);
    margin: 0 auto 22px; max-width: 500px;
}
.vc-hero-pills { display:flex; align-items:center; justify-content:center; gap:10px; flex-wrap:wrap; }
.vc-hero-pill {
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.28);
    backdrop-filter: blur(6px);
    color: #fff; font-size: 12px; font-weight: 700;
    padding: 6px 14px; border-radius: 20px;
    display: flex; align-items: center; gap: 6px;
}

/* ── Page wrapper ── */
.vc-page { padding: 0 0 72px; background: #f5f6fa; min-height: 70vh; }

/* ── Card shell (tabs + content) ── */
.vc-shell {
    background: #fff;
    border-radius: 22px 22px 0 0;
    position: relative; z-index: 2;
    box-shadow: 0 -6px 24px rgba(0,0,0,.07);
}

/* ── Filter tabs ── */
.vc-tabs {
    display: flex; align-items: center; gap: 4px;
    padding: 20px 24px 0;
    border-bottom: 2px solid #f0f0f4;
    overflow-x: auto; scrollbar-width: none;
}
.vc-tabs::-webkit-scrollbar { display:none; }
.vc-tab {
    background: none; border: none; cursor: pointer;
    font-family: inherit; font-size: 13px; font-weight: 700;
    color: #999; padding: 10px 16px;
    border-bottom: 2.5px solid transparent;
    margin-bottom: -2px; white-space: nowrap;
    transition: all .18s;
    display: flex; align-items: center; gap: 6px;
}
.vc-tab .cnt {
    background: #f0f0f4; color: #888;
    font-size: 10px; font-weight: 800;
    padding: 2px 7px; border-radius: 10px;
    transition: all .18s;
}
.vc-tab.active, .vc-tab:hover { color: #D10024; border-bottom-color: #D10024; }
.vc-tab.active .cnt { background: #fee2e2; color: #D10024; }

/* ── Content area ── */
.vc-body { padding: 22px 24px 28px; }

/* ── Notice ── */
.vc-notice {
    background: linear-gradient(135deg, #fffbeb, #fef9ec);
    border: 1.5px solid #fde68a;
    border-radius: 12px;
    padding: 11px 16px; font-size: 12px; color: #92400e;
    margin-bottom: 22px;
    display: flex; align-items: center; gap: 10px;
}
.vc-notice-icon {
    width: 30px; height: 30px; flex-shrink: 0;
    background: #fde68a; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: #d97706;
}

/* ── Grid ── */
.vc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
    gap: 18px;
}
@media(max-width:720px){ .vc-grid { grid-template-columns: 1fr; } }

/* ── Voucher card ── */
.vc-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(0,0,0,.07);
    display: flex; overflow: visible; position: relative;
    transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .22s;
    animation: cardIn .38s ease both;
}
.vc-card:hover { transform: translateY(-5px) scale(1.012); box-shadow: 0 16px 42px rgba(0,0,0,.13); }
@keyframes cardIn { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
.vc-card:nth-child(1){animation-delay:.04s} .vc-card:nth-child(2){animation-delay:.08s}
.vc-card:nth-child(3){animation-delay:.12s} .vc-card:nth-child(4){animation-delay:.16s}
.vc-card:nth-child(5){animation-delay:.20s} .vc-card:nth-child(6){animation-delay:.24s}
.vc-card:nth-child(n+7){animation-delay:.28s}

/* Hover shine sweep */
.vc-card::after {
    content: '';
    position: absolute; inset: 0; border-radius: 16px;
    background: linear-gradient(105deg, transparent 38%, rgba(255,255,255,.32) 50%, transparent 62%);
    background-size: 220% 100%; background-position: -100% 0;
    z-index: 3; pointer-events: none; transition: background-position .55s;
}
.vc-card:hover::after { background-position: 200% 0; }

/* ── Left stub ── */
.vc-left {
    width: 108px; flex-shrink: 0;
    border-radius: 16px 0 0 16px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 16px 8px; position: relative; overflow: hidden;
}
/* diagonal stripe overlay */
.vc-left::before {
    content: '';
    position: absolute; inset: 0;
    background: repeating-linear-gradient(
        45deg, transparent, transparent 10px,
        rgba(255,255,255,.06) 10px, rgba(255,255,255,.06) 20px
    );
    pointer-events: none;
}
/* perforated right edge */
.vc-left::after {
    content: '';
    position: absolute; right: -9px; top: 0; bottom: 0; width: 18px;
    background: radial-gradient(circle at right, #fff 7px, transparent 7px) 0 7px / 18px 18px repeat-y;
    pointer-events: none; z-index: 1;
}

.vc-disc {
    font-size: 26px; font-weight: 900; color: #fff;
    text-align: center; line-height: 1;
    text-shadow: 0 2px 8px rgba(0,0,0,.3);
    letter-spacing: -1px; position: relative; z-index: 1;
}
.vc-disc-unit {
    font-size: 12px; font-weight: 800; color: rgba(255,255,255,.95);
    text-align: center; margin-top: 2px;
    position: relative; z-index: 1;
}
.vc-disc-label {
    font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px;
    color: rgba(255,255,255,.7); text-align: center; margin-top: 6px;
    background: rgba(0,0,0,.16); padding: 2px 8px; border-radius: 5px;
    position: relative; z-index: 1;
}
.vc-left-brand {
    position: absolute; bottom: 7px; left: 50%; transform: translateX(-50%);
    font-size: 7.5px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px;
    color: rgba(255,255,255,.35); white-space: nowrap; z-index: 1;
}

/* ── Dashed separator ── */
.vc-sep { width: 0; border-left: 2px dashed rgba(0,0,0,.07); margin: 12px 0; flex-shrink: 0; }

/* ── Right body ── */
.vc-right {
    flex: 1; min-width: 0;
    padding: 15px 15px 13px 22px;
    display: flex; flex-direction: column;
}
.vc-right-top { flex: 1; }

.vc-name {
    font-size: 14px; font-weight: 800; color: #1e1f29;
    line-height: 1.35; margin-bottom: 5px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

.vc-type-tag {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 9.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .4px;
    padding: 3px 9px; border-radius: 6px; margin-bottom: 8px;
}
.vc-type-tag.pct { background: #ede9fe; color: #6d28d9; }
.vc-type-tag.flat { background: #fee2e2; color: #D10024; }

.vc-metas { display:flex; flex-direction:column; gap:3px; margin-bottom: 10px; }
.vc-meta { display:flex; align-items:center; gap:6px; font-size:11.5px; color:#888; }
.vc-meta .fa { width:12px; text-align:center; font-size:10px; color:#ccc; }
.vc-meta strong { color:#444; font-weight:700; }

/* ── Bottom row ── */
.vc-foot {
    border-top: 1.5px dashed #f0f0f2;
    padding-top: 10px; margin-top: auto;
    display: flex; align-items: center; justify-content: space-between; gap: 8px;
}
.vc-foot-left { display:flex; flex-direction:column; gap:3px; min-width: 0; }
.vc-expiry { font-size: 10.5px; color: #bbb; }
.vc-expiry strong { color: #D10024; font-weight: 700; }
.vc-expiry.urgent strong { animation: expBlink 1s ease-in-out infinite; }
@keyframes expBlink { 0%,100%{opacity:1} 50%{opacity:.35} }

.vc-code {
    font-family: 'Courier New', monospace;
    font-size: 11.5px; font-weight: 800; letter-spacing: 1.5px;
    color: #374151;
    background: linear-gradient(135deg, #f9fafb, #f1f3f6);
    border: 1.5px dashed #d1d5db;
    padding: 4px 10px; border-radius: 7px;
    display: inline-block; max-width: 145px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

.btn-copy {
    flex-shrink: 0;
    padding: 8px 16px;
    border: 2px solid #10b981; border-radius: 22px;
    background: #fff; color: #065f46;
    font-family: inherit; font-size: 12px; font-weight: 800;
    cursor: pointer; white-space: nowrap;
    transition: all .18s;
    display: flex; align-items: center; gap: 5px;
}
.btn-copy:hover { background: #10b981; color: #fff; transform: scale(1.06); }
.btn-copy:active { transform: scale(.96); }
.btn-copy:disabled { border-color: #e5e7eb; color: #d1d5db; cursor:not-allowed; pointer-events:none; }

/* ── Badges ── */
.vc-badges {
    position: absolute; top: -10px; right: 12px;
    display: flex; gap: 5px; z-index: 4;
}
.vc-badge {
    font-size: 10px; font-weight: 800; letter-spacing: .3px;
    padding: 4px 10px; border-radius: 20px;
    box-shadow: 0 3px 8px rgba(0,0,0,.18); color: #fff;
    display: flex; align-items: center; gap: 4px; white-space: nowrap;
}
.vc-badge.unlimited { background: linear-gradient(135deg,#34d399,#059669); }
.vc-badge.many      { background: linear-gradient(135deg,#60a5fa,#2563eb); }
.vc-badge.few       { background: linear-gradient(135deg,#fbbf24,#d97706); }
.vc-badge.habis     { background: linear-gradient(135deg,#9ca3af,#6b7280); }
.vc-badge.soon      { background: linear-gradient(135deg,#f87171,#D10024); }

/* ── Disabled card state ── */
.vc-card.vc-disabled {
    opacity: .48; filter: grayscale(1); pointer-events: none;
}

/* ── Empty state ── */
.vc-empty { text-align:center; padding:72px 20px; }
.vc-empty-orb {
    width:110px; height:110px;
    background: linear-gradient(135deg,#fef2f2,#ffe4e4);
    border-radius: 50%;
    display: inline-flex; align-items:center; justify-content:center;
    font-size: 50px; color: #fca5a5; margin-bottom: 20px;
}
.vc-empty h3 { font-size:18px; font-weight:800; color:#374151; margin-bottom:8px; }
.vc-empty p  { font-size:13px; color:#9ca3af; }

/* ── Hidden filter targets ── */
.vc-card[data-type] { transition: opacity .2s, transform .2s; }
.vc-card.vc-hidden  { display: none; }
</style>
@endpush

@section('content')

{{-- ══ HERO ══ --}}
<div class="vc-hero">
    <div class="vc-hero-blob b1"></div>
    <div class="vc-hero-blob b2"></div>
    <div class="vc-hero-blob b3"></div>
    <div class="container vc-hero-inner">
        <div class="vc-hero-icon"><i class="fa fa-ticket"></i></div>
        <div class="vc-hero-title">Voucher Diskon NusaMart</div>
        <div class="vc-hero-sub">Hemat lebih banyak dengan kode voucher eksklusif kami. Klik tombol <strong style="color:#fff;">Salin Kode</strong> lalu tempelkan saat checkout.</div>
        <div class="vc-hero-pills">
            <div class="vc-hero-pill"><i class="fa fa-check-circle"></i> {{ $vouchers->count() }} Voucher Aktif</div>
            @if($vouchers->where('discount_type','percentage')->count())
            <div class="vc-hero-pill"><i class="fa fa-percent"></i> Diskon Persen</div>
            @endif
            @if($vouchers->where('discount_type','fixed')->count())
            <div class="vc-hero-pill"><i class="fa fa-tag"></i> Potongan Harga</div>
            @endif
        </div>
    </div>
</div>

{{-- ══ MAIN CONTENT ══ --}}
<div class="vc-page">
<div class="container">
<div class="vc-shell">

    {{-- Tabs --}}
    @php
        $cntAll  = $vouchers->count();
        $cntPct  = $vouchers->where('discount_type','percentage')->count();
        $cntFlat = $vouchers->where('discount_type','fixed')->count();
    @endphp
    <div class="vc-tabs">
        <button class="vc-tab active" data-filter="all">
            <i class="fa fa-th-large"></i> Semua <span class="cnt">{{ $cntAll }}</span>
        </button>
        @if($cntPct)
        <button class="vc-tab" data-filter="percentage">
            <i class="fa fa-percent"></i> Diskon % <span class="cnt">{{ $cntPct }}</span>
        </button>
        @endif
        @if($cntFlat)
        <button class="vc-tab" data-filter="fixed">
            <i class="fa fa-tag"></i> Potongan Rp <span class="cnt">{{ $cntFlat }}</span>
        </button>
        @endif
    </div>

    <div class="vc-body">

        {{-- Notice --}}
        <div class="vc-notice">
            <div class="vc-notice-icon"><i class="fa fa-lightbulb-o"></i></div>
            <div>Klik <strong>Salin Kode</strong> pada voucher yang kamu inginkan, lalu tempelkan di kolom voucher saat halaman <strong>Checkout</strong>. Satu kode hanya bisa digunakan sekali.</div>
        </div>

        @if($vouchers->isEmpty())
        {{-- Empty state --}}
        <div class="vc-empty">
            <div class="vc-empty-orb"><i class="fa fa-ticket"></i></div>
            <h3>Belum ada voucher aktif</h3>
            <p>Pantau terus halaman ini — voucher diskon menarik akan segera hadir!</p>
        </div>
        @else
        <div class="vc-grid" id="vcGrid">
            @foreach($vouchers as $v)
            @php
                $remaining  = $v->quota > 0 ? ($v->quota - $v->used_count) : null;
                $isHabis    = $remaining !== null && $remaining <= 0;
                $daysLeft   = $v->end_date ? now()->diffInDays($v->end_date, false) : null;
                $isUrgent   = $daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 3;

                // Quota badge
                if ($isHabis) {
                    $badgeClass = 'habis'; $badgeText = 'Habis';
                } elseif ($remaining === null) {
                    $badgeClass = 'unlimited'; $badgeText = 'Unlimited';
                } elseif ($remaining >= 50) {
                    $badgeClass = 'many'; $badgeText = 'x'.$remaining;
                } elseif ($remaining <= 5) {
                    $badgeClass = 'few'; $badgeText = 'x'.$remaining.' Tersisa';
                } else {
                    $badgeClass = 'many'; $badgeText = 'x'.$remaining;
                }

                // Discount display
                if ($v->discount_type === 'percentage') {
                    $gradFrom  = '#6d28d9';
                    $gradTo    = '#a855f7';
                    $discMain  = $v->discount_value;
                    $discUnit  = '%';
                    $discLabel = 'Diskon';
                    $tagClass  = 'pct';
                    $tagText   = 'Diskon Persen';
                } else {
                    $val      = $v->discount_value;
                    $gradFrom  = '#B30020';
                    $gradTo    = '#ff5252';
                    $discMain  = ($val >= 1000 ? 'Rp'.number_format($val/1000, 0).'rb' : 'Rp'.number_format($val,0));
                    $discUnit  = '';
                    $discLabel = 'Potongan';
                    $tagClass  = 'flat';
                    $tagText   = 'Potongan Harga';
                }
            @endphp
            <div class="vc-card {{ $isHabis ? 'vc-disabled' : '' }}" data-type="{{ $v->discount_type }}">

                {{-- Badges --}}
                <div class="vc-badges">
                    @if($isUrgent && !$isHabis)
                        <div class="vc-badge soon"><i class="fa fa-fire"></i> Segera Habis</div>
                    @endif
                    <div class="vc-badge {{ $badgeClass }}">{{ $badgeText }}</div>
                </div>

                {{-- Left stub --}}
                <div class="vc-left" style="background: linear-gradient(160deg, {{ $gradFrom }}, {{ $gradTo }});">
                    <div class="vc-disc">{{ $discMain }}</div>
                    @if($discUnit)
                        <div class="vc-disc-unit">{{ $discUnit }}</div>
                    @endif
                    <div class="vc-disc-label">{{ $discLabel }}</div>
                    <div class="vc-left-brand">NusaMart</div>
                </div>

                {{-- Separator --}}
                <div class="vc-sep"></div>

                {{-- Right body --}}
                <div class="vc-right">
                    <div class="vc-right-top">
                        <div class="vc-name">{{ $v->name }}</div>
                        <div class="vc-type-tag {{ $tagClass }}">
                            <i class="fa fa-{{ $v->discount_type === 'percentage' ? 'percent' : 'tag' }}"></i>
                            {{ $tagText }}
                        </div>
                        <div class="vc-metas">
                            <div class="vc-meta">
                                <i class="fa fa-shopping-bag"></i>
                                Min. belanja
                                <strong>Rp {{ $v->min_purchase > 0 ? number_format($v->min_purchase, 0, ',', '.') : '0' }}</strong>
                            </div>
                            @if($v->discount_type === 'percentage' && $v->max_discount)
                            <div class="vc-meta">
                                <i class="fa fa-arrow-circle-down"></i>
                                Maks. diskon <strong>Rp {{ number_format($v->max_discount, 0, ',', '.') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Footer row --}}
                    <div class="vc-foot">
                        <div class="vc-foot-left">
                            <div class="vc-expiry {{ $isUrgent ? 'urgent' : '' }}">
                                <i class="fa fa-clock-o" style="font-size:9px;"></i>
                                @if($v->end_date)
                                    @if($isUrgent && !$isHabis)
                                        <strong>{{ $daysLeft == 0 ? 'Hari ini berakhir!' : 'Berakhir '.($daysLeft == 1 ? 'besok' : $daysLeft.' hari lagi') }}</strong>
                                    @else
                                        s/d <strong>{{ $v->end_date->translatedFormat('d M Y') }}</strong>
                                    @endif
                                @else
                                    <strong>Tidak terbatas</strong>
                                @endif
                            </div>
                            <div class="vc-code">{{ $v->code }}</div>
                        </div>

                        @if($isHabis)
                            <button class="btn-copy" disabled>
                                <i class="fa fa-ban"></i> Habis
                            </button>
                        @else
                            <button class="btn-copy" onclick="copyVoucher('{{ $v->code }}', this)">
                                <i class="fa fa-clipboard"></i> Salin Kode
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- No results after filter --}}
        <div id="vcNoResult" style="display:none;text-align:center;padding:40px;color:#aaa;">
            <i class="fa fa-inbox" style="font-size:36px;display:block;margin-bottom:10px;"></i>
            Tidak ada voucher untuk kategori ini.
        </div>
        @endif

    </div>{{-- /vc-body --}}
</div>{{-- /vc-shell --}}
</div>{{-- /container --}}
</div>{{-- /vc-page --}}
@endsection

@push('scripts')
<script>
/* ── Copy to clipboard ── */
function copyVoucher(code, btn) {
    var copy = function() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(code).catch(function(){});
        } else {
            var ta = document.createElement('textarea');
            ta.value = code;
            ta.style.cssText = 'position:fixed;opacity:0;top:0;left:0';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
        }
    };
    copy();
    var orig = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-check"></i> Disalin!';
    btn.style.cssText = 'background:#10b981;color:#fff;border-color:#10b981;transform:scale(1.05)';
    setTimeout(function() {
        btn.innerHTML = orig;
        btn.style.cssText = '';
    }, 2000);
}

/* ── Filter tabs ── */
document.querySelectorAll('.vc-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.vc-tab').forEach(function(t){ t.classList.remove('active'); });
        this.classList.add('active');

        var filter = this.dataset.filter;
        var cards  = document.querySelectorAll('#vcGrid .vc-card');
        var shown  = 0;

        cards.forEach(function(c) {
            if (filter === 'all' || c.dataset.type === filter) {
                c.classList.remove('vc-hidden');
                shown++;
            } else {
                c.classList.add('vc-hidden');
            }
        });

        var noResult = document.getElementById('vcNoResult');
        if (noResult) noResult.style.display = shown === 0 ? 'block' : 'none';
    });
});
</script>
@endpush
