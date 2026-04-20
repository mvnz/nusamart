@extends('layouts.app')

@section('title', $kuliner->nama . ' - Kuliner Lokal NusaMart')

@push('styles')
<style>
/* ============================================================
   KULINER SHOW PAGE — tiket.com-inspired layout
   prefix: .ks-
============================================================ */

/* ── Reset helpers ── */
.ks-page { background: #f3f4f6; min-height: 100vh; padding-bottom: 64px; }

/* ── Breadcrumb ── */
.ks-breadcrumb {
    padding: 14px 0 10px;
    font-size: 12.5px; color: #888;
    display: flex; align-items: center; gap: 5px;
}
.ks-breadcrumb a { color: #D10024; text-decoration: none; font-weight: 600; }
.ks-breadcrumb a:hover { text-decoration: underline; }

/* ── Hero Photo ── */
.ks-hero { position: relative; background: #1e1f29; }
.ks-hero-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3px;
    height: 400px;
    overflow: hidden;
}
.ks-hero-main {
    grid-row: 1 / 3;
    overflow: hidden;
}
.ks-hero-main img,
.ks-hero-thumb img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .4s;
}
.ks-hero-main:hover img { transform: scale(1.03); }
.ks-hero-thumb { overflow: hidden; }
.ks-hero-thumb:hover img { transform: scale(1.05); }
.ks-hero-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, #1e1f29, #374151);
    display: flex; align-items: center; justify-content: center;
}
.ks-hero-placeholder i { font-size: 72px; color: rgba(255,255,255,.12); }
/* When only 1 image, span full width */
.ks-hero-inner.single { grid-template-columns: 1fr; }
.ks-hero-inner.single .ks-hero-main { grid-row: unset; }

/* Status badge over hero */
.ks-hero-badge {
    position: absolute; top: 20px; left: 20px; z-index: 3;
    display: flex; align-items: center; gap: 7px;
    padding: 7px 16px; border-radius: 24px;
    font-size: 13px; font-weight: 700;
    backdrop-filter: blur(6px);
    box-shadow: 0 2px 12px rgba(0,0,0,.2);
}
.ks-hero-badge.buka  { background: rgba(5,150,105,.9); color: #fff; }
.ks-hero-badge.tutup { background: rgba(220,38,38,.9);  color: #fff; }

/* ── Sticky Tab Nav ── */
.ks-tab-wrap {
    position: sticky; top: 0; z-index: 100;
    background: #fff; border-bottom: 1.5px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}
.ks-tabs {
    display: flex; gap: 0;
    overflow-x: auto; scrollbar-width: none;
}
.ks-tabs::-webkit-scrollbar { display: none; }
.ks-tab {
    padding: 16px 22px; font-size: 13.5px; font-weight: 700;
    color: #666; white-space: nowrap; cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: color .15s, border-color .15s;
    text-decoration: none; display: block;
}
.ks-tab:hover { color: #D10024; }
.ks-tab.active { color: #D10024; border-bottom-color: #D10024; }

/* ── Layout ── */
.ks-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    padding-top: 24px;
    align-items: start;
}
@media (max-width: 900px) {
    .ks-layout { grid-template-columns: 1fr; }
    .ks-sidebar { order: -1; }
    .ks-hero-inner { height: 260px; grid-template-columns: 1fr; }
    .ks-hero-inner .ks-hero-thumb { display: none; }
}

/* ── Main column ── */
.ks-main { display: flex; flex-direction: column; gap: 16px; }

/* Header card (name + kategori + highlights) */
.ks-card {
    background: #fff; border-radius: 14px;
    padding: 24px 26px;
    box-shadow: 0 1px 6px rgba(0,0,0,.07);
}
.ks-card + .ks-card { /* no extra margin needed, gap handles it */ }

.ks-name-row { display: flex; align-items: flex-start; gap: 12px; flex-wrap: wrap; margin-bottom: 12px; }
.ks-kat-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 16px;
    font-size: 11.5px; font-weight: 700; white-space: nowrap;
    background: #fff7ed; color: #d97706;
}
.ks-title { font-size: 24px; font-weight: 900; color: #1a1b25; line-height: 1.25; margin: 0 0 6px; }
.ks-subtitle { font-size: 13px; color: #888; display: flex; align-items: center; gap: 6px; }

/* Highlights */
.ks-highlights {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
    margin-top: 20px;
}
@media (max-width: 600px) { .ks-highlights { grid-template-columns: 1fr 1fr; } }
.ks-hl {
    background: #f9fafb; border-radius: 10px; padding: 14px 12px;
    display: flex; align-items: flex-start; gap: 10px;
}
.ks-hl-icon {
    width: 36px; height: 36px; border-radius: 8px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 14px;
}
.ks-hl-icon.red    { background: #fee2e2; color: #D10024; }
.ks-hl-icon.orange { background: #fff7ed; color: #d97706; }
.ks-hl-icon.green  { background: #d1fae5; color: #059669; }
.ks-hl-icon.blue   { background: #dbeafe; color: #2563eb; }
.ks-hl-icon.purple { background: #ede9fe; color: #7c3aed; }
.ks-hl-text { flex: 1; }
.ks-hl-label { font-size: 10.5px; color: #aaa; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 3px; }
.ks-hl-val  { font-size: 13px; font-weight: 700; color: #1e1f29; line-height: 1.35; }

/* Section title */
.ks-sec-title {
    font-size: 16px; font-weight: 800; color: #1a1b25;
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 16px;
}
.ks-sec-title::after {
    content: ''; flex: 1; height: 1.5px; background: #f0f0f0; border-radius: 2px;
}

/* Tentang / Deskripsi */
.ks-desc-text { font-size: 14px; color: #555; line-height: 1.8; white-space: pre-wrap; }
.ks-read-more {
    margin-top: 10px; font-size: 13px; font-weight: 700; color: #D10024;
    cursor: pointer; display: inline-flex; align-items: center; gap: 5px;
    background: none; border: none; padding: 0; font-family: inherit;
}
.ks-read-more:hover { text-decoration: underline; }

/* Lokasi */
.ks-map-frame {
    width: 100%; height: 220px; border-radius: 12px; overflow: hidden;
    background: #e5e7eb; margin-top: 4px; position: relative;
}
.ks-map-placeholder {
    width: 100%; height: 100%; background: linear-gradient(135deg,#dbeafe,#ede9fe);
    display: flex; align-items: center; justify-content: center;
    flex-direction: column; gap: 8px; color: #6b7280;
}
.ks-map-placeholder i { font-size: 36px; color: #D10024; }
.ks-map-placeholder p { font-size: 12px; font-weight: 600; margin: 0; }
.ks-addr-block {
    margin-top: 14px; padding: 14px 16px;
    background: #f9fafb; border-radius: 10px;
    font-size: 13px; color: #444; line-height: 1.6;
    display: flex; align-items: flex-start; gap: 10px;
}
.ks-addr-block i { color: #D10024; margin-top: 2px; flex-shrink: 0; }

/* ── Sidebar ── */
.ks-sidebar {
    position: sticky; top: 64px;
    display: flex; flex-direction: column; gap: 16px;
}

.ks-cta-card {
    background: #fff; border-radius: 14px;
    padding: 22px 22px 20px;
    box-shadow: 0 2px 16px rgba(0,0,0,.09);
}

.ks-status-large {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; margin-bottom: 18px;
    font-size: 15px; font-weight: 800;
}
.ks-status-large.buka  { background: #d1fae5; color: #065f46; }
.ks-status-large.tutup { background: #fee2e2; color: #991b1b; }
.ks-status-large i { font-size: 10px; }

.ks-info-rows { display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px; }
.ks-info-row {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 14px; background: #f9fafb; border-radius: 10px;
}
.ks-info-icon {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 13px;
}
.ks-info-label { font-size: 10.5px; color: #aaa; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
.ks-info-val   { font-size: 13px; font-weight: 700; color: #1e1f29; }

/* CTA Buttons */
.ks-btn-wa {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 14px; border-radius: 10px;
    background: linear-gradient(135deg, #25d366, #128c7e);
    color: #fff; font-size: 14px; font-weight: 800;
    text-decoration: none; border: none;
    transition: opacity .2s, transform .15s;
    cursor: pointer; margin-bottom: 10px;
}
.ks-btn-wa:hover { opacity: .93; transform: translateY(-1px); }

.ks-btn-maps {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 12px; border-radius: 10px;
    background: #fff; color: #D10024;
    font-size: 13.5px; font-weight: 800;
    text-decoration: none; border: 2px solid #D10024;
    transition: background .18s, color .18s;
}
.ks-btn-maps:hover { background: #D10024; color: #fff; }

/* Share card */
.ks-share-card {
    background: #fff; border-radius: 14px; padding: 18px 22px;
    box-shadow: 0 1px 6px rgba(0,0,0,.07);
}
.ks-share-title { font-size: 13px; font-weight: 700; color: #555; margin-bottom: 12px; }
.ks-share-btns { display: flex; gap: 10px; }
.ks-share-btn {
    flex: 1; padding: 9px; border-radius: 8px; border: 1.5px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; cursor: pointer; background: #fff;
    transition: all .18s; text-decoration: none; color: inherit;
}
.ks-share-btn.wa   { color: #25d366; } .ks-share-btn.wa:hover   { background: #25d366; color: #fff; border-color: #25d366; }
.ks-share-btn.copy { color: #6b7280; } .ks-share-btn.copy:hover { background: #6b7280; color: #fff; border-color: #6b7280; }

/* ── Back link ── */
.ks-back {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 16px; background: #fff; color: #555;
    border-radius: 8px; font-size: 13px; font-weight: 700;
    text-decoration: none; border: 1.5px solid #e5e7eb;
    transition: all .15s; margin-bottom: 0;
}
.ks-back:hover { background: #f4f5f7; color: #1e1f29; }

/* ── Section anchors offset ── */
.ks-anchor { scroll-margin-top: 72px; }

/* ── Desc collapse ── */
.ks-desc-collapsed { max-height: 96px; overflow: hidden; }
</style>
@endpush

@section('content')
<div class="ks-page">

    {{-- Hero Photo --}}
    <div class="ks-hero">
        <div class="ks-hero-inner single">
            {{-- Main photo --}}
            <div class="ks-hero-main">
                @if($kuliner->gambar && file_exists(public_path('uploads/' . $kuliner->gambar)))
                    <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}">
                @else
                    <div class="ks-hero-placeholder">
                        <i class="fa fa-cutlery"></i>
                    </div>
                @endif
            </div>

        </div>

        {{-- Status badge --}}
        <div class="ks-hero-badge {{ $kuliner->status }}">
            <i class="fa fa-circle" style="font-size:8px"></i>
            {{ $kuliner->status === 'buka' ? 'Sedang Buka' : 'Sedang Tutup' }}
        </div>
    </div>

    {{-- Sticky Tab Nav --}}
    <div class="ks-tab-wrap">
        <div class="container">
            <div class="ks-tabs">
                <a class="ks-tab active" href="#ks-info"    onclick="ksTab(this)">Info</a>
                <a class="ks-tab"        href="#ks-tentang" onclick="ksTab(this)">Tentang</a>
                <a class="ks-tab"        href="#ks-lokasi"  onclick="ksTab(this)">Lokasi</a>
                <a class="ks-tab"        href="#ks-kontak"  onclick="ksTab(this)">Kontak</a>
            </div>
        </div>
    </div>

    <div class="container">
        {{-- Breadcrumb --}}
        <div class="ks-breadcrumb">
            <a href="{{ route('kuliner.index') }}">Kuliner Lokal</a>
            <i class="fa fa-chevron-right" style="font-size:9px"></i>
            <span>{{ $kuliner->nama }}</span>
        </div>

        <div class="ks-layout">
            {{-- ===== MAIN COLUMN ===== --}}
            <div class="ks-main">

                {{-- Info card (name + highlights) --}}
                <div class="ks-card ks-anchor" id="ks-info">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;flex-wrap:wrap">
                        <span class="ks-kat-pill"><i class="fa fa-tag"></i> {{ $kuliner->kategori }}</span>
                        <a href="{{ route('kuliner.index') }}" class="ks-back"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                    <h1 class="ks-title">{{ $kuliner->nama }}</h1>
                    <div class="ks-subtitle">
                        <i class="fa fa-map-marker" style="color:#D10024"></i>
                        {{ Str::limit($kuliner->alamat, 60) }}
                    </div>

                    {{-- Highlights --}}
                    <div class="ks-highlights">
                        <div class="ks-hl">
                            <div class="ks-hl-icon orange"><i class="fa fa-clock-o"></i></div>
                            <div class="ks-hl-text">
                                <div class="ks-hl-label">Jam Buka</div>
                                <div class="ks-hl-val">{{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</div>
                            </div>
                        </div>
                        <div class="ks-hl">
                            <div class="ks-hl-icon green"><i class="fa fa-whatsapp"></i></div>
                            <div class="ks-hl-text">
                                <div class="ks-hl-label">WhatsApp</div>
                                <div class="ks-hl-val">+{{ $kuliner->kontak_wa }}</div>
                            </div>
                        </div>
                        <div class="ks-hl">
                            <div class="ks-hl-icon {{ $kuliner->status === 'buka' ? 'green' : 'red' }}">
                                <i class="fa fa-circle" style="font-size:10px"></i>
                            </div>
                            <div class="ks-hl-text">
                                <div class="ks-hl-label">Status</div>
                                <div class="ks-hl-val">{{ $kuliner->status === 'buka' ? 'Sedang Buka' : 'Sedang Tutup' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tentang --}}
                @if($kuliner->deskripsi)
                <div class="ks-card ks-anchor" id="ks-tentang">
                    <div class="ks-sec-title"><i class="fa fa-info-circle" style="color:#D10024"></i> Tentang Warung</div>
                    <div class="ks-desc-text ks-desc-collapsed" id="ksDescText">{{ $kuliner->deskripsi }}</div>
                    <button class="ks-read-more" id="ksReadMore" onclick="ksToggleDesc()">
                        Lihat selengkapnya <i class="fa fa-chevron-down"></i>
                    </button>
                </div>
                @endif

                {{-- Lokasi --}}
                <div class="ks-card ks-anchor" id="ks-lokasi">
                    <div class="ks-sec-title"><i class="fa fa-map-o" style="color:#D10024"></i> Lokasi</div>
                    <div class="ks-map-frame">
                        <iframe
                            src="https://maps.google.com/maps?q={{ urlencode($kuliner->alamat) }}&output=embed&hl=id&z=16"
                            width="100%" height="100%"
                            style="border:0; display:block;"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <div class="ks-addr-block">
                        <i class="fa fa-map-marker"></i>
                        <span>{{ $kuliner->alamat }}</span>
                    </div>
                    @if($kuliner->link_maps)
                    <a href="{{ $kuliner->link_maps }}" target="_blank" rel="noopener noreferrer"
                       style="margin-top:14px;display:inline-flex;align-items:center;gap:7px;
                              padding:10px 18px;background:#D10024;color:#fff;
                              border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">
                        <i class="fa fa-map-o"></i> Buka di Google Maps
                    </a>
                    @endif
                </div>

                {{-- Kontak --}}
                <div class="ks-card ks-anchor" id="ks-kontak">
                    <div class="ks-sec-title"><i class="fa fa-phone" style="color:#D10024"></i> Kontak</div>
                    <div class="ks-info-rows">
                        <div class="ks-info-row">
                            <div class="ks-info-icon green" style="background:#d1fae5;color:#059669"><i class="fa fa-whatsapp"></i></div>
                            <div>
                                <div class="ks-info-label">WhatsApp</div>
                                <div class="ks-info-val">
                                    <a href="https://wa.me/{{ $kuliner->kontak_wa }}" target="_blank" rel="noopener noreferrer"
                                       style="color:#059669;font-weight:700;text-decoration:none">
                                        +{{ $kuliner->kontak_wa }} <i class="fa fa-external-link" style="font-size:10px"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="ks-info-row">
                            <div class="ks-info-icon" style="background:#fee2e2;color:#D10024;width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fa fa-map-marker"></i></div>
                            <div>
                                <div class="ks-info-label">Alamat Lengkap</div>
                                <div class="ks-info-val">{{ $kuliner->alamat }}</div>
                            </div>
                        </div>
                        <div class="ks-info-row">
                            <div class="ks-info-icon" style="background:#fff7ed;color:#d97706;width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fa fa-clock-o"></i></div>
                            <div>
                                <div class="ks-info-label">Jam Operasional</div>
                                <div class="ks-info-val">{{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }} WIB</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- end .ks-main --}}

            {{-- ===== SIDEBAR ===== --}}
            <div class="ks-sidebar">
                {{-- CTA Card --}}
                <div class="ks-cta-card">
                    <div class="ks-status-large {{ $kuliner->status }}">
                        <i class="fa fa-circle"></i>
                        {{ $kuliner->status === 'buka' ? 'Warung Sedang Buka' : 'Warung Sedang Tutup' }}
                    </div>

                    <div class="ks-info-rows">
                        <div class="ks-info-row">
                            <div class="ks-info-icon" style="background:#fff7ed;color:#d97706;width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fa fa-clock-o"></i></div>
                            <div>
                                <div class="ks-info-label">Jam Buka</div>
                                <div class="ks-info-val">{{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</div>
                            </div>
                        </div>
                        <div class="ks-info-row">
                            <div class="ks-info-icon" style="background:#fff7ed;color:#d97706;width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fa fa-tag"></i></div>
                            <div>
                                <div class="ks-info-label">Kategori</div>
                                <div class="ks-info-val">{{ $kuliner->kategori }}</div>
                            </div>
                        </div>
                    </div>

                    @if($kuliner->kontak_wa)
                    <a href="https://wa.me/{{ $kuliner->kontak_wa }}" target="_blank" rel="noopener noreferrer" class="ks-btn-wa">
                        <i class="fa fa-whatsapp" style="font-size:18px"></i> Chat via WhatsApp
                    </a>
                    @endif

                    @if($kuliner->link_maps)
                    <a href="{{ $kuliner->link_maps }}" target="_blank" rel="noopener noreferrer" class="ks-btn-maps">
                        <i class="fa fa-map-o"></i> Lihat di Google Maps
                    </a>
                    @endif
                </div>

                {{-- Share card --}}
                <div class="ks-share-card">
                    <div class="ks-share-title"><i class="fa fa-share-alt"></i> Bagikan Warung Ini</div>
                    <div class="ks-share-btns">
                        <a href="https://wa.me/?text={{ urlencode($kuliner->nama . ' — ' . $kuliner->alamat . ' ' . request()->url()) }}"
                           target="_blank" rel="noopener noreferrer" class="ks-share-btn wa" title="Bagikan via WhatsApp">
                            <i class="fa fa-whatsapp"></i>
                        </a>
                        <button class="ks-share-btn copy" onclick="ksCopyLink()" title="Salin tautan">
                            <i class="fa fa-link"></i>
                        </button>
                    </div>
                </div>
            </div>{{-- end .ks-sidebar --}}

        </div>{{-- end .ks-layout --}}
    </div>{{-- end .container --}}
</div>{{-- end .ks-page --}}

<script>
/* Tab active highlight on click */
function ksTab(el) {
    document.querySelectorAll('.ks-tab').forEach(function(t){ t.classList.remove('active'); });
    el.classList.add('active');
}

/* Highlight tab on scroll */
window.addEventListener('scroll', function() {
    var sections = ['ks-info','ks-tentang','ks-lokasi','ks-kontak'];
    var active = sections[0];
    sections.forEach(function(id) {
        var el = document.getElementById(id);
        if (el && el.getBoundingClientRect().top <= 90) active = id;
    });
    var tab = document.querySelector('.ks-tab[href="#' + active + '"]');
    if (tab) {
        document.querySelectorAll('.ks-tab').forEach(function(t){ t.classList.remove('active'); });
        tab.classList.add('active');
    }
}, { passive: true });

/* Collapse/expand description */
var ksDescExpanded = false;
function ksToggleDesc() {
    var el  = document.getElementById('ksDescText');
    var btn = document.getElementById('ksReadMore');
    if (!el) return;
    ksDescExpanded = !ksDescExpanded;
    if (ksDescExpanded) {
        el.classList.remove('ks-desc-collapsed');
        btn.innerHTML = 'Sembunyikan <i class="fa fa-chevron-up"></i>';
    } else {
        el.classList.add('ks-desc-collapsed');
        btn.innerHTML = 'Lihat selengkapnya <i class="fa fa-chevron-down"></i>';
    }
}

/* Copy link */
function ksCopyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        var btn = document.querySelector('.ks-share-btn.copy');
        if (btn) {
            btn.innerHTML = '<i class="fa fa-check"></i>';
            setTimeout(function(){ btn.innerHTML = '<i class="fa fa-link"></i>'; }, 2000);
        }
    });
}
</script>
@endsection
