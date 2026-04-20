@extends('layouts.admin')

@section('title', 'Kelola Kuliner - NusaMart Admin')

@section('content')
<style>
/* ===== BASE ===== */
.kl-wrap { max-width: 1240px; margin: 0 auto; padding: 4px 0 52px; }

/* ===== HERO BANNER ===== */
.kl-hero {
    background: linear-gradient(135deg, #78350f 0%, #b45309 40%, #d97706 70%, #f59e0b 100%);
    border-radius: 20px; padding: 32px 36px; margin-bottom: 26px;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;
    position: relative; overflow: hidden;
}
.kl-hero::before {
    content: ''; position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.kl-hero-left { position: relative; z-index: 1; }
.kl-hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,.18); color: #fff; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-bottom: 10px; letter-spacing: .3px; }
.kl-hero-title { font-size: 26px; font-weight: 900; color: #fff; margin: 0 0 6px; letter-spacing: -.3px; }
.kl-hero-sub { font-size: 13px; color: rgba(255,255,255,.8); margin: 0; }
.kl-hero-right { position: relative; z-index: 1; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.kl-hero-addbtn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; background: #fff; color: #b45309;
    border: none; border-radius: 12px; font-size: 13px; font-weight: 800;
    cursor: pointer; font-family: inherit; transition: all .2s; text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
}
.kl-hero-addbtn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.2); color: #92400e; }
.kl-hero-viewbtn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 18px; background: rgba(255,255,255,.15); color: #fff;
    border: 1.5px solid rgba(255,255,255,.4); border-radius: 12px; font-size: 13px; font-weight: 700;
    cursor: pointer; font-family: inherit; transition: all .2s; text-decoration: none;
}
.kl-hero-viewbtn:hover { background: rgba(255,255,255,.25); color: #fff; }

/* ===== STATS ===== */
.kl-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 26px; }
@media(max-width: 900px) { .kl-stats { grid-template-columns: repeat(2, 1fr); } }
.kl-stat {
    background: #fff; border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 12px rgba(0,0,0,.04);
    padding: 20px 22px; display: flex; align-items: center; gap: 16px;
    transition: box-shadow .2s, transform .15s; border-left: 4px solid transparent;
    position: relative; overflow: hidden;
}
.kl-stat::after {
    content: ''; position: absolute; right: -10px; top: -10px;
    width: 70px; height: 70px; border-radius: 50%; opacity: .06;
}
.kl-stat.s-orange { border-left-color: #f59e0b; }
.kl-stat.s-orange::after { background: #f59e0b; }
.kl-stat.s-green  { border-left-color: #10b981; }
.kl-stat.s-green::after  { background: #10b981; }
.kl-stat.s-red    { border-left-color: #ef4444; }
.kl-stat.s-red::after    { background: #ef4444; }
.kl-stat.s-blue   { border-left-color: #3b82f6; }
.kl-stat.s-blue::after   { background: #3b82f6; }
.kl-stat:hover { box-shadow: 0 4px 20px rgba(0,0,0,.1); transform: translateY(-2px); }
.kl-si { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 19px; flex-shrink: 0; }
.kl-si.orange { background: linear-gradient(135deg, #fde68a, #fbbf24); color: #78350f; }
.kl-si.green  { background: linear-gradient(135deg, #6ee7b7, #34d399); color: #064e3b; }
.kl-si.red    { background: linear-gradient(135deg, #fca5a5, #f87171); color: #7f1d1d; }
.kl-si.blue   { background: linear-gradient(135deg, #93c5fd, #60a5fa); color: #1e3a5f; }
.kl-sv { font-size: 30px; font-weight: 900; color: #1e1f29; line-height: 1; letter-spacing: -1px; }
.kl-sl { font-size: 12px; color: #8d8d8d; margin-top: 3px; font-weight: 600; }

/* ===== MAIN CARD ===== */
.kl-card { background: #fff; border-radius: 18px; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 8px 24px rgba(0,0,0,.05); overflow: hidden; }

/* ===== TOOLBAR ===== */
.kl-toolbar {
    display: flex; align-items: center; gap: 10px;
    padding: 16px 24px; border-bottom: 1px solid #f3f4f6; flex-wrap: wrap;
    background: #fafafa;
}
.kl-search {
    display: flex; align-items: center; border: 1.5px solid #e5e7eb; border-radius: 10px;
    overflow: hidden; transition: all .2s; background: #fff; flex: 1; min-width: 180px; max-width: 300px;
}
.kl-search:focus-within { border-color: #d97706; box-shadow: 0 0 0 3px rgba(217,119,6,.1); }
.kl-search i { padding: 0 12px; color: #c0c0c0; font-size: 13px; }
.kl-search input { flex: 1; border: none; outline: none; padding: 10px 0; font-size: 13px; background: transparent; font-family: inherit; }

.kl-filters { display: flex; gap: 6px; flex-wrap: wrap; }
.kl-fbtn {
    padding: 7px 14px; border: 1.5px solid #e5e7eb; border-radius: 20px;
    background: #fff; font-size: 12px; font-weight: 700; color: #666;
    cursor: pointer; font-family: inherit; transition: all .18s; white-space: nowrap;
    display: inline-flex; align-items: center; gap: 5px;
}
.kl-fbtn:hover { border-color: #d97706; color: #d97706; }
.kl-fbtn.active { background: linear-gradient(135deg, #d97706, #b45309); border-color: #d97706; color: #fff; box-shadow: 0 2px 8px rgba(217,119,6,.3); }

/* view toggle */
.kl-view-toggle { display: flex; gap: 4px; margin-left: auto; }
.kl-vtbtn { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: 1.5px solid #e5e7eb; border-radius: 8px; background: #fff; color: #aaa; cursor: pointer; transition: all .18s; font-size: 13px; }
.kl-vtbtn.active { background: #1e1f29; border-color: #1e1f29; color: #fff; }

.kl-count { font-size: 12px; color: #8d8d8d; white-space: nowrap; }

/* ===== ALERT ===== */
.kl-alert { display: flex; align-items: center; gap: 10px; padding: 13px 24px; font-size: 13px; }
.kl-alert.success { background: linear-gradient(90deg, #d1fae5, #ecfdf5); border-bottom: 1px solid #a7f3d0; color: #065f46; }
.kl-alert.error   { background: linear-gradient(90deg, #fee2e2, #fff5f5); border-bottom: 1px solid #fecaca; color: #991b1b; }

/* ===== GRID VIEW ===== */
.kl-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 20px; padding: 24px; }
@media(max-width: 640px) { .kl-grid { grid-template-columns: 1fr; } }

.kl-item {
    background: #fff; border-radius: 16px;
    border: 1.5px solid #f0f0f3; overflow: hidden;
    transition: box-shadow .25s, transform .2s, border-color .2s;
    position: relative;
}
.kl-item:hover { box-shadow: 0 8px 32px rgba(0,0,0,.12); transform: translateY(-3px); border-color: #fde68a; }

.kl-item-img {
    width: 100%; height: 170px;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; position: relative;
}
.kl-item-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.kl-item:hover .kl-item-img img { transform: scale(1.06); }
.kl-item-img .no-img { font-size: 52px; color: rgba(217,119,6,.25); }
.kl-item-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,.55));
    opacity: 0; transition: opacity .25s;
}
.kl-item:hover .kl-item-img-overlay { opacity: 1; }

.kl-item-status {
    position: absolute; top: 10px; right: 10px;
    padding: 4px 11px; border-radius: 20px; font-size: 11px; font-weight: 700;
    display: flex; align-items: center; gap: 4px;
    backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
}
.kl-item-status.buka  { background: rgba(209,250,229,.95); color: #065f46; border: 1px solid rgba(167,243,208,.6); }
.kl-item-status.tutup { background: rgba(254,226,226,.95); color: #991b1b; border: 1px solid rgba(254,202,202,.6); }
.kl-item-status .dot  { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.kl-item-status.buka  .dot { background: #10b981; }
.kl-item-status.tutup .dot { background: #ef4444; }

.kl-item-body { padding: 16px 18px 12px; }
.kl-item-kat {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 10.5px; font-weight: 700; padding: 3px 10px;
    border-radius: 6px; margin-bottom: 9px;
}
.kl-kat-makanan  { background: #fff7ed; color: #c2410c; }
.kl-kat-jajanan  { background: #fdf4ff; color: #7e22ce; }
.kl-kat-minuman  { background: #eff6ff; color: #1d4ed8; }
.kl-kat-seafood  { background: #ecfeff; color: #0e7490; }
.kl-kat-sarapan  { background: #fefce8; color: #854d0e; }
.kl-kat-dessert  { background: #fdf2f8; color: #be185d; }
.kl-kat-lainnya  { background: #f3f4f6; color: #4b5563; }

.kl-item-name { font-size: 15px; font-weight: 800; color: #1e1f29; margin: 0 0 8px; line-height: 1.3; }
.kl-item-meta { font-size: 11.5px; color: #9ca3af; display: flex; flex-direction: column; gap: 5px; }
.kl-item-meta span { display: flex; align-items: center; gap: 7px; }
.kl-item-meta i { width: 14px; text-align: center; color: #d97706; font-size: 12px; }

.kl-item-actions {
    display: flex; gap: 8px; padding: 12px 18px;
    border-top: 1px solid #f5f5f8;
    background: linear-gradient(to bottom, #fdfdfd, #f9f9fb);
}
.kl-act-btn {
    flex: 1; display: inline-flex; align-items: center; justify-content: center;
    gap: 5px; padding: 8px 10px; border: none; border-radius: 9px;
    font-size: 12px; font-weight: 700; cursor: pointer;
    font-family: inherit; transition: all .18s; text-decoration: none;
}
.kl-act-edit   { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
.kl-act-edit:hover   { background: #2563eb; color: #fff; border-color: #2563eb; }
.kl-act-delete { background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; }
.kl-act-delete:hover { background: #e11d48; color: #fff; border-color: #e11d48; }

/* ===== LIST VIEW ===== */
.kl-list { display: none; }
.kl-list-row {
    display: flex; align-items: center; gap: 16px;
    padding: 14px 24px; border-bottom: 1px solid #f5f5f8;
    transition: background .15s;
}
.kl-list-row:last-child { border-bottom: none; }
.kl-list-row:hover { background: #fffbf0; }
.kl-list-thumb {
    width: 54px; height: 54px; border-radius: 10px; flex-shrink: 0;
    overflow: hidden; background: linear-gradient(135deg, #fef3c7, #fde68a);
    display: flex; align-items: center; justify-content: center;
}
.kl-list-thumb img { width: 100%; height: 100%; object-fit: cover; }
.kl-list-thumb i  { font-size: 22px; color: rgba(217,119,6,.4); }
.kl-list-info { flex: 1; min-width: 0; }
.kl-list-name { font-size: 13.5px; font-weight: 800; color: #1e1f29; margin: 0 0 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.kl-list-meta { font-size: 11.5px; color: #9ca3af; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.kl-list-meta span { display: flex; align-items: center; gap: 4px; }
.kl-list-meta i { color: #d97706; }
.kl-list-kat { flex-shrink: 0; }
.kl-list-status { flex-shrink: 0; }
.kl-list-actions { display: flex; gap: 6px; flex-shrink: 0; }
.kl-list-btn {
    display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px;
    border: none; border-radius: 7px; font-size: 11.5px; font-weight: 700;
    cursor: pointer; font-family: inherit; transition: all .18s; text-decoration: none;
}
.kl-list-btn.edit   { background: #eff6ff; color: #2563eb; }
.kl-list-btn.edit:hover   { background: #2563eb; color: #fff; }
.kl-list-btn.del    { background: #fff1f2; color: #e11d48; }
.kl-list-btn.del:hover    { background: #e11d48; color: #fff; }

/* ===== EMPTY STATE ===== */
.kl-empty { text-align: center; padding: 72px 24px; }
.kl-empty-icon {
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, #fde68a, #fbbf24);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px; box-shadow: 0 8px 24px rgba(251,191,36,.4);
}
.kl-empty-icon i { font-size: 32px; color: #78350f; }
.kl-empty h4 { font-size: 17px; font-weight: 800; color: #374151; margin: 0 0 8px; }
.kl-empty p  { font-size: 13px; color: #9ca3af; margin: 0 0 20px; }
</style>

<div class="kl-wrap">
    {{-- Hero Banner --}}
    <div class="kl-hero">
        <div class="kl-hero-left">
            <div class="kl-hero-badge"><i class="fa fa-cutlery"></i> Kuliner Lokal NusaMart</div>
            <h1 class="kl-hero-title">Manajemen Warung Kuliner</h1>
            <p class="kl-hero-sub">Kelola dan publikasikan informasi warung kuliner lokal</p>
        </div>
        <div class="kl-hero-right">
            <a href="{{ route('kuliner.index') }}" target="_blank" class="kl-hero-viewbtn">
                <i class="fa fa-eye"></i> Lihat di Situs
            </a>
            <a href="{{ route('admin.kuliner.create') }}" class="kl-hero-addbtn">
                <i class="fa fa-plus"></i> Tambah Warung
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php $totalKat = $kuliners->pluck('kategori')->unique()->count(); @endphp
    <div class="kl-stats">
        <div class="kl-stat s-orange">
            <div class="kl-si orange"><i class="fa fa-cutlery"></i></div>
            <div>
                <div class="kl-sv">{{ $kuliners->count() }}</div>
                <div class="kl-sl">Total Warung</div>
            </div>
        </div>
        <div class="kl-stat s-green">
            <div class="kl-si green"><i class="fa fa-check-circle"></i></div>
            <div>
                <div class="kl-sv">{{ $kuliners->where('status','buka')->count() }}</div>
                <div class="kl-sl">Sedang Buka</div>
            </div>
        </div>
        <div class="kl-stat s-red">
            <div class="kl-si red"><i class="fa fa-times-circle"></i></div>
            <div>
                <div class="kl-sv">{{ $kuliners->where('status','tutup')->count() }}</div>
                <div class="kl-sl">Sedang Tutup</div>
            </div>
        </div>
        <div class="kl-stat s-blue">
            <div class="kl-si blue"><i class="fa fa-tags"></i></div>
            <div>
                <div class="kl-sv">{{ $totalKat }}</div>
                <div class="kl-sl">Kategori</div>
            </div>
        </div>
    </div>

    {{-- Main card --}}
    <div class="kl-card">
        <div class="kl-toolbar">
            <div class="kl-search">
                <i class="fa fa-search"></i>
                <input type="text" id="klSearch" placeholder="Cari nama, kategori, alamat..." oninput="filterKuliner()">
            </div>
            <div class="kl-filters">
                <button class="kl-fbtn active" onclick="setFilter(this,'all')">Semua</button>
                <button class="kl-fbtn" onclick="setFilter(this,'buka')">
                    <span style="width:7px;height:7px;border-radius:50%;background:#10b981;display:inline-block"></span> Buka
                </button>
                <button class="kl-fbtn" onclick="setFilter(this,'tutup')">
                    <span style="width:7px;height:7px;border-radius:50%;background:#ef4444;display:inline-block"></span> Tutup
                </button>
            </div>
            <span class="kl-count" id="klCount"></span>
            <div class="kl-view-toggle">
                <button class="kl-vtbtn active" id="btnGrid" onclick="setView('grid')" title="Grid"><i class="fa fa-th-large"></i></button>
                <button class="kl-vtbtn" id="btnList" onclick="setView('list')" title="List"><i class="fa fa-list"></i></button>
            </div>
        </div>

        @if(session('success'))
            <div class="kl-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="kl-alert error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @if($kuliners->isEmpty())
            <div class="kl-empty">
                <div class="kl-empty-icon"><i class="fa fa-cutlery"></i></div>
                <h4>Belum Ada Warung</h4>
                <p>Mulai tambahkan warung kuliner lokal pertama.</p>
                <a href="{{ route('admin.kuliner.create') }}" class="kl-hero-addbtn" style="display:inline-flex;text-decoration:none">
                    <i class="fa fa-plus"></i> Tambah Warung
                </a>
            </div>
        @else
            {{-- Grid View --}}
            <div class="kl-grid" id="klGrid">
                @foreach($kuliners as $kuliner)
                @php
                    $katClass = match(strtolower($kuliner->kategori)) {
                        'makanan berat' => 'kl-kat-makanan',
                        'jajanan'       => 'kl-kat-jajanan',
                        'minuman'       => 'kl-kat-minuman',
                        'seafood'       => 'kl-kat-seafood',
                        'sarapan'       => 'kl-kat-sarapan',
                        'dessert'       => 'kl-kat-dessert',
                        default         => 'kl-kat-lainnya',
                    };
                @endphp
                <div class="kl-item"
                     data-search="{{ strtolower($kuliner->nama.' '.$kuliner->kategori.' '.$kuliner->alamat) }}"
                     data-status="{{ $kuliner->status }}">
                    <div class="kl-item-img">
                        @if($kuliner->gambar && file_exists(public_path('uploads/'.$kuliner->gambar)))
                            <img src="{{ asset('uploads/'.$kuliner->gambar) }}" alt="{{ $kuliner->nama }}" loading="lazy">
                        @else
                            <i class="fa fa-cutlery no-img"></i>
                        @endif
                        <div class="kl-item-img-overlay"></div>
                        <span class="kl-item-status {{ $kuliner->status }}">
                            <span class="dot"></span> {{ ucfirst($kuliner->status) }}
                        </span>
                    </div>
                    <div class="kl-item-body">
                        <div class="kl-item-kat {{ $katClass }}">
                            <i class="fa fa-tag"></i> {{ $kuliner->kategori }}
                        </div>
                        <div class="kl-item-name">{{ $kuliner->nama }}</div>
                        <div class="kl-item-meta">
                            <span><i class="fa fa-map-marker"></i> {{ Str::limit($kuliner->alamat, 50) }}</span>
                            <span><i class="fa fa-clock-o"></i> {{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</span>
                            @if($kuliner->kontak_wa)
                            <span><i class="fa fa-whatsapp"></i> +{{ $kuliner->kontak_wa }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="kl-item-actions">
                        <a href="{{ route('admin.kuliner.edit', $kuliner->id) }}" class="kl-act-btn kl-act-edit">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.kuliner.destroy', $kuliner->id) }}" method="POST"
                              style="flex:1;display:flex"
                              onsubmit="return confirm('Hapus warung {{ addslashes($kuliner->nama) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="kl-act-btn kl-act-delete" style="width:100%">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- List View --}}
            <div class="kl-list" id="klList">
                @foreach($kuliners as $kuliner)
                @php
                    $katClass2 = match(strtolower($kuliner->kategori)) {
                        'makanan berat' => 'kl-kat-makanan',
                        'jajanan'       => 'kl-kat-jajanan',
                        'minuman'       => 'kl-kat-minuman',
                        'seafood'       => 'kl-kat-seafood',
                        'sarapan'       => 'kl-kat-sarapan',
                        'dessert'       => 'kl-kat-dessert',
                        default         => 'kl-kat-lainnya',
                    };
                @endphp
                <div class="kl-list-row"
                     data-search="{{ strtolower($kuliner->nama.' '.$kuliner->kategori.' '.$kuliner->alamat) }}"
                     data-status="{{ $kuliner->status }}">
                    <div class="kl-list-thumb">
                        @if($kuliner->gambar && file_exists(public_path('uploads/'.$kuliner->gambar)))
                            <img src="{{ asset('uploads/'.$kuliner->gambar) }}" alt="{{ $kuliner->nama }}" loading="lazy">
                        @else
                            <i class="fa fa-cutlery"></i>
                        @endif
                    </div>
                    <div class="kl-list-info">
                        <div class="kl-list-name">{{ $kuliner->nama }}</div>
                        <div class="kl-list-meta">
                            <span><i class="fa fa-map-marker"></i> {{ Str::limit($kuliner->alamat, 40) }}</span>
                            <span><i class="fa fa-clock-o"></i> {{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</span>
                        </div>
                    </div>
                    <div class="kl-list-kat">
                        <span class="kl-item-kat {{ $katClass2 }}" style="margin:0"><i class="fa fa-tag"></i> {{ $kuliner->kategori }}</span>
                    </div>
                    <div class="kl-list-status">
                        <span class="kl-item-status {{ $kuliner->status }}" style="position:static">
                            <span class="dot"></span> {{ ucfirst($kuliner->status) }}
                        </span>
                    </div>
                    <div class="kl-list-actions">
                        <a href="{{ route('admin.kuliner.edit', $kuliner->id) }}" class="kl-list-btn edit">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.kuliner.destroy', $kuliner->id) }}" method="POST"
                              onsubmit="return confirm('Hapus warung {{ addslashes($kuliner->nama) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="kl-list-btn del">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div id="klEmpty" style="display:none" class="kl-empty">
                <div class="kl-empty-icon"><i class="fa fa-search"></i></div>
                <h4>Tidak Ditemukan</h4>
                <p>Coba kata kunci atau filter lain.</p>
            </div>
        @endif
    </div>
</div>

<script>
var activeFilter = 'all';
var activeView = 'grid';

function setFilter(btn, filter) {
    activeFilter = filter;
    document.querySelectorAll('.kl-fbtn').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    filterKuliner();
}

function setView(view) {
    activeView = view;
    document.getElementById('klGrid').style.display = (view === 'grid') ? '' : 'none';
    document.getElementById('klList').style.display = (view === 'list') ? '' : 'none';
    document.getElementById('btnGrid').classList.toggle('active', view === 'grid');
    document.getElementById('btnList').classList.toggle('active', view === 'list');
    filterKuliner();
}

function filterKuliner() {
    var q = document.getElementById('klSearch').value.toLowerCase().trim();
    var container = activeView === 'grid' ? '#klGrid' : '#klList';
    var selector  = activeView === 'grid' ? '.kl-item' : '.kl-list-row';
    var items = document.querySelectorAll(container + ' ' + selector);
    var count = 0;

    items.forEach(function(item) {
        var ms = !q || item.dataset.search.includes(q);
        var mf = activeFilter === 'all' || item.dataset.status === activeFilter;
        item.style.display = (ms && mf) ? '' : 'none';
        if (ms && mf) count++;
    });

    var el = document.getElementById('klCount');
    el.textContent = (q || activeFilter !== 'all') ? count + ' dari ' + items.length + ' warung' : '';
    var emptyEl = document.getElementById('klEmpty');
    if (emptyEl) emptyEl.style.display = (count === 0 && items.length > 0) ? '' : 'none';
}
</script>
@endsection
