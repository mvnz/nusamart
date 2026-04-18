@extends('layouts.app')

@section('title', 'Voucher - NusaMart')

@push('styles')
<style>
.vc-page { padding: 36px 0 64px; }
.vc-header { margin-bottom: 28px; }
.vc-title { font-size: 22px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 10px; }
.vc-title .fa { color: #D10024; }
.vc-subtitle { font-size: 13px; color: #888; margin-top: 4px; }

.vc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 16px; }
@media(max-width:600px){ .vc-grid { grid-template-columns: 1fr; } }

/* ── Voucher card ── */
.vc-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 14px rgba(0,0,0,.08);
    display: flex;
    overflow: visible;
    position: relative;
    transition: transform .18s, box-shadow .18s;
}
.vc-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.13); }

/* Left colored panel */
.vc-left {
    width: 100px;
    flex-shrink: 0;
    border-radius: 14px 0 0 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 14px 8px;
    position: relative;
    overflow: hidden;
}
.vc-left::after {
    content: '';
    position: absolute;
    right: -10px;
    top: 0;
    bottom: 0;
    width: 20px;
    background: radial-gradient(circle at right, #fff 8px, transparent 8px) 0 0 / 20px 20px repeat-y;
}
.vc-left-disc {
    font-size: 26px;
    font-weight: 900;
    color: #fff;
    text-align: center;
    line-height: 1.1;
    text-shadow: 0 2px 6px rgba(0,0,0,.2);
    letter-spacing: -.5px;
}
.vc-left-sub {
    font-size: 10px;
    font-weight: 700;
    color: rgba(255,255,255,.85);
    text-transform: uppercase;
    text-align: center;
    margin-top: 4px;
    letter-spacing: .5px;
}
/* vertical text label on left */
.vc-left-nm {
    font-size: 9px;
    font-weight: 800;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: 1px;
    writing-mode: vertical-rl;
    text-orientation: mixed;
    margin-top: 8px;
}

/* Right content */
.vc-right {
    flex: 1;
    padding: 14px 16px 14px 20px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.vc-name {
    font-size: 14px;
    font-weight: 800;
    color: #1e1f29;
    line-height: 1.3;
}
.vc-meta {
    font-size: 12px;
    color: #888;
    display: flex;
    align-items: center;
    gap: 4px;
}
.vc-meta .fa { font-size: 11px; }
.vc-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 8px;
}
.vc-expiry {
    font-size: 11px;
    color: #aaa;
}
.vc-expiry strong { color: #D10024; }
.btn-pakai {
    padding: 7px 18px;
    border: 2px solid #10b981;
    border-radius: 20px;
    background: #fff;
    color: #065f46;
    font-family: inherit;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all .18s;
    white-space: nowrap;
}
.btn-pakai:hover { background: #10b981; color: #fff; }
.btn-pakai.disabled, .btn-pakai:disabled { border-color: #d1d5db; color: #9ca3af; cursor: not-allowed; pointer-events: none; }

/* Disabled / quota-full card */
.vc-card.vc-disabled { opacity: .55; filter: grayscale(1); }
.vc-card.vc-disabled .vc-left { background: linear-gradient(160deg, #9ca3af, #d1d5db) !important; }
.vc-card.vc-disabled:hover { transform: none; box-shadow: 0 3px 14px rgba(0,0,0,.08); }
.vc-habis-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    background: #f3f4f6; color: #9ca3af;
    font-size: 11px; font-weight: 700;
    border: 1.5px solid #e5e7eb;
    white-space: nowrap;
}

/* Quota badge */
.vc-quota {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #ff6b6b, #D10024);
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    padding: 4px 9px;
    border-radius: 20px;
    box-shadow: 0 3px 8px rgba(209,0,36,.35);
    white-space: nowrap;
    letter-spacing: .3px;
    z-index: 2;
}
.vc-quota.many { background: linear-gradient(135deg, #34d399, #10b981); box-shadow: 0 3px 8px rgba(16,185,129,.35); }
.vc-quota.few  { background: linear-gradient(135deg, #fbbf24, #f59e0b); box-shadow: 0 3px 8px rgba(245,158,11,.35); }

/* Divider dots */
.vc-divider {
    width: 1px;
    border-left: 2px dashed #f0f0f0;
    margin: 10px 0;
    flex-shrink: 0;
}

/* Empty */
.vc-empty { text-align: center; padding: 60px 20px; background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
.vc-empty .fa { font-size: 52px; color: #e0e0e0; display: block; margin-bottom: 14px; }
.vc-empty h3 { font-size: 17px; color: #555; margin-bottom: 6px; }
.vc-empty p  { font-size: 13px; color: #999; }

/* Notice */
.vc-notice {
    background: linear-gradient(135deg,#fef3c7,#fffbeb);
    border: 1px solid #fde68a;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 12px;
    color: #92400e;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
</style>
@endpush

@section('content')
<div class="container vc-page">
    <div class="vc-header">
        <div class="vc-title"><i class="fa fa-ticket"></i> Voucher Tersedia</div>
        <div class="vc-subtitle">Gunakan kode voucher di halaman checkout untuk mendapatkan potongan harga</div>
    </div>

    <div class="vc-notice">
        <i class="fa fa-info-circle" style="font-size:15px;flex-shrink:0;color:#f59e0b;"></i>
        Klik tombol <strong>Pakai</strong> untuk menyalin kode, lalu tempelkan di kolom voucher saat checkout.
    </div>

    @if($vouchers->isEmpty())
        <div class="vc-empty">
            <i class="fa fa-ticket"></i>
            <h3>Belum ada voucher aktif</h3>
            <p>Pantau terus halaman ini, voucher diskon akan segera hadir!</p>
        </div>
    @else
        <div class="vc-grid">
            @foreach($vouchers as $v)
            @php
                $remaining = $v->quota > 0 ? ($v->quota - $v->used_count) : null;
                $isHabis   = $remaining !== null && $remaining <= 0;
                $quotaClass = '';
                $quotaLabel = '';
                if ($isHabis) {
                    $quotaLabel = 'Habis';
                    $quotaClass = 'few';
                } elseif ($remaining !== null) {
                    $quotaLabel = 'x' . $remaining;
                    $quotaClass = $remaining <= 5 ? 'few' : ($remaining >= 50 ? 'many' : '');
                } else {
                    $quotaLabel = 'Unlimited';
                    $quotaClass = 'many';
                }

                // Card color by discount type
                if ($v->discount_type === 'percentage') {
                    $gradFrom = '#7c3aed';
                    $gradTo   = '#a855f7';
                    $discLine1 = $v->discount_value . '%';
                    $discLine2 = 'Diskon';
                } else {
                    $val = $v->discount_value;
                    $gradFrom = '#D10024';
                    $gradTo   = '#ff6b6b';
                    $discLine1 = 'Rp' . ($val >= 1000 ? number_format($val/1000, 0).'rb' : number_format($val, 0));
                    $discLine2 = 'Potongan';
                }
            @endphp
            <div class="vc-card {{ $isHabis ? 'vc-disabled' : '' }}">
                {{-- Quota badge --}}
                <div class="vc-quota {{ $quotaClass }}">{{ $quotaLabel }}</div>

                {{-- Left panel --}}
                <div class="vc-left" style="background: linear-gradient(160deg, {{ $gradFrom }}, {{ $gradTo }});">
                    <div class="vc-left-disc">{{ $discLine1 }}</div>
                    <div class="vc-left-sub">{{ $discLine2 }}</div>
                    <div class="vc-left-nm">NusaMart</div>
                </div>

                {{-- Right content --}}
                <div class="vc-right">
                    <div class="vc-name">{{ $v->name }}</div>

                    @if($v->min_purchase > 0)
                    <div class="vc-meta">
                        <i class="fa fa-shopping-bag"></i>
                        Min. Blj <strong style="margin-left:3px;color:#555;">Rp {{ number_format($v->min_purchase, 0, ',', '.') }}</strong>
                    </div>
                    @else
                    <div class="vc-meta"><i class="fa fa-shopping-bag"></i> Min. Blj <strong style="margin-left:3px;color:#555;">Rp0</strong></div>
                    @endif

                    @if($v->discount_type === 'percentage' && $v->max_discount)
                    <div class="vc-meta">
                        <i class="fa fa-arrow-down"></i>
                        Maks. diskon <strong style="margin-left:3px;color:#555;">Rp {{ number_format($v->max_discount, 0, ',', '.') }}</strong>
                    </div>
                    @endif

                    <div class="vc-bottom">
                        <div>
                            <div class="vc-expiry">
                                Berlaku hingga:
                                @if($v->end_date)
                                    <strong>{{ $v->end_date->translatedFormat('d M Y') }}</strong>
                                @else
                                    <strong>Tidak terbatas</strong>
                                @endif
                            </div>
                            <div style="margin-top:5px;">
                                <code style="font-size:12px;background:#f3f4f6;padding:3px 8px;border-radius:5px;font-weight:700;letter-spacing:1px;color:#374151;">{{ $v->code }}</code>
                            </div>
                        </div>
                        <button class="btn-pakai{{ $isHabis ? ' disabled' : '' }}" {{ $isHabis ? 'disabled' : "onclick=\"pakaiVoucher('".$v->code."', this)\"" }}>
                            @if($isHabis)
                                <i class="fa fa-ban" style="margin-right:4px;"></i>Habis
                            @else
                                <i class="fa fa-clipboard" style="margin-right:4px;"></i>Pakai
                            @endif
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function pakaiVoucher(code, btn) {
    // Copy to clipboard
    if (navigator.clipboard) {
        navigator.clipboard.writeText(code).catch(function(){});
    } else {
        var ta = document.createElement('textarea');
        ta.value = code;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
    }

    var orig = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-check" style="margin-right:4px;"></i>Disalin!';
    btn.style.background = '#10b981';
    btn.style.color = '#fff';
    btn.style.borderColor = '#10b981';

    setTimeout(function() {
        btn.innerHTML = orig;
        btn.style.background = '';
        btn.style.color = '';
        btn.style.borderColor = '';
    }, 1800);
}
</script>
@endpush
