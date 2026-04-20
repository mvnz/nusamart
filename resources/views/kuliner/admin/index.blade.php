@extends('layouts.admin')

@section('title', 'Kelola Kuliner - NusaMart Admin')

@section('content')
<style>
.kl-wrap { max-width: 1200px; margin: 0 auto; padding: 4px 0 48px; }

/* Page header */
.kl-page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 26px; flex-wrap: wrap; gap: 12px; }
.kl-page-title { font-size: 22px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 10px; margin: 0; }
.kl-page-title i { color: #d97706; font-size: 21px; }
.kl-addbtn { display: inline-flex; align-items: center; gap: 7px; padding: 10px 20px; background: linear-gradient(135deg, #D10024, #a8001e); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all .2s; text-decoration: none; box-shadow: 0 3px 10px rgba(209,0,36,.25); }
.kl-addbtn:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(209,0,36,.35); color: #fff; }

/* Stats */
.kl-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
@media(max-width: 800px) { .kl-stats { grid-template-columns: repeat(2, 1fr); } }
.kl-stat { background: #fff; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,.06); padding: 20px; display: flex; align-items: center; gap: 14px; transition: box-shadow .2s, transform .15s; }
.kl-stat:hover { box-shadow: 0 4px 18px rgba(0,0,0,.1); transform: translateY(-1px); }
.kl-si { width: 50px; height: 50px; border-radius: 13px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
.kl-si.orange { background: linear-gradient(135deg, #ffe4b2, #fff7e6); color: #d97706; }
.kl-si.green  { background: linear-gradient(135deg, #c8f7d6, #edfff3); color: #1a9e50; }
.kl-si.red    { background: linear-gradient(135deg, #ffd6d6, #ffefef); color: #D10024; }
.kl-si.blue   { background: linear-gradient(135deg, #c9e9ff, #edf6ff); color: #0369a1; }
.kl-sv { font-size: 28px; font-weight: 800; color: #1e1f29; line-height: 1; }
.kl-sl { font-size: 12px; color: #8d8d8d; margin-top: 3px; font-weight: 500; }

/* Main card */
.kl-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow: hidden; }

/* Toolbar */
.kl-toolbar { display: flex; align-items: center; gap: 10px; padding: 16px 22px; border-bottom: 1px solid #f2f2f5; flex-wrap: wrap; }
.kl-search { display: flex; align-items: center; border: 1.5px solid #e5e7eb; border-radius: 10px; overflow: hidden; transition: border .2s; background: #f9fafb; flex: 1; min-width: 180px; max-width: 280px; }
.kl-search:focus-within { border-color: #d97706; background: #fff; }
.kl-search i { padding: 0 12px; color: #c0c0c0; font-size: 13px; }
.kl-search input { flex: 1; border: none; outline: none; padding: 10px 0; font-size: 13px; background: transparent; font-family: inherit; }
.kl-filters { display: flex; gap: 6px; flex-wrap: wrap; }
.kl-fbtn { padding: 7px 14px; border: 1.5px solid #e5e7eb; border-radius: 20px; background: #fff; font-size: 12px; font-weight: 700; color: #666; cursor: pointer; font-family: inherit; transition: all .2s; white-space: nowrap; }
.kl-fbtn:hover { border-color: #d97706; color: #d97706; }
.kl-fbtn.active { background: #d97706; border-color: #d97706; color: #fff; }
.kl-count { font-size: 12px; color: #8d8d8d; margin-left: auto; white-space: nowrap; }

/* Alert */
.kl-alert { display: flex; align-items: center; gap: 8px; padding: 12px 22px; font-size: 13px; }
.kl-alert.success { background: #d1fae5; border-bottom: 1px solid #6ee7b7; color: #065f46; }
.kl-alert.error   { background: #fee2e2; border-bottom: 1px solid #fca5a5; color: #991b1b; }

/* Card grid */
.kl-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; padding: 22px; }
@media(max-width: 640px) { .kl-grid { grid-template-columns: 1fr; } }

.kl-item { background: #fff; border-radius: 14px; border: 1.5px solid #f0f0f3; overflow: hidden; transition: box-shadow .2s, transform .15s, border-color .2s; position: relative; }
.kl-item:hover { box-shadow: 0 6px 24px rgba(0,0,0,.1); transform: translateY(-2px); border-color: #e0e0e5; }

.kl-item-img { width: 100%; height: 160px; background: linear-gradient(135deg, #f5f5f8, #ece9e3); display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; }
.kl-item-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
.kl-item:hover .kl-item-img img { transform: scale(1.04); }
.kl-item-img .no-img { font-size: 48px; color: #e0dbd2; }

.kl-item-status { position: absolute; top: 10px; right: 10px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.kl-item-status.buka  { background: rgba(209,250,229,.92); color: #065f46; }
.kl-item-status.tutup { background: rgba(254,226,226,.92); color: #991b1b; }

.kl-item-body { padding: 14px 16px; }
.kl-item-kat { display: inline-flex; align-items: center; gap: 5px; font-size: 10.5px; font-weight: 700; padding: 3px 9px; border-radius: 6px; margin-bottom: 8px; }
.kl-kat-makanan  { background: #fff7ed; color: #c2410c; }
.kl-kat-jajanan  { background: #fdf4ff; color: #7e22ce; }
.kl-kat-minuman  { background: #eff6ff; color: #1d4ed8; }
.kl-kat-seafood  { background: #ecfeff; color: #0e7490; }
.kl-kat-sarapan  { background: #fefce8; color: #854d0e; }
.kl-kat-dessert  { background: #fdf2f8; color: #be185d; }
.kl-kat-lainnya  { background: #f3f4f6; color: #4b5563; }

.kl-item-name { font-size: 14.5px; font-weight: 800; color: #1e1f29; margin: 0 0 5px; line-height: 1.3; }
.kl-item-meta { font-size: 11.5px; color: #8d8d8d; display: flex; flex-direction: column; gap: 4px; }
.kl-item-meta span { display: flex; align-items: center; gap: 6px; }
.kl-item-meta i { width: 13px; text-align: center; color: #bbb; }

.kl-item-actions { display: flex; gap: 8px; padding: 12px 16px; border-top: 1px solid #f5f5f8; background: #fafafa; }
.kl-act-btn { flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 5px; padding: 7px 10px; border: none; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all .18s; text-decoration: none; }
.kl-act-edit   { background: #e3f2fd; color: #1565c0; }
.kl-act-edit:hover   { background: #bbdefb; color: #0d47a1; }
.kl-act-delete { background: #fce4ec; color: #D10024; }
.kl-act-delete:hover { background: #ffcdd2; color: #b71c1c; }

/* Empty state */
.kl-empty { text-align: center; padding: 64px 24px; }
.kl-empty-icon { width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, #ffe4b2, #fff7e6); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.kl-empty-icon i { font-size: 30px; color: #d97706; }
.kl-empty h4 { font-size: 15px; font-weight: 700; color: #374151; margin: 0 0 6px; }
.kl-empty p  { font-size: 13px; color: #9ca3af; margin: 0 0 18px; }
</style>

<div class="kl-wrap">
    <div class="kl-page-header">
        <h1 class="kl-page-title"><i class="fa fa-cutlery"></i> Kelola Kuliner Lokal</h1>
        <a href="{{ route('admin.kuliner.create') }}" class="kl-addbtn">
            <i class="fa fa-plus"></i> Tambah Warung
        </a>
    </div>

    {{-- Stats --}}
    @php
        $totalKat = $kuliners->pluck('kategori')->unique()->count();
    @endphp
    <div class="kl-stats">
        <div class="kl-stat">
            <div class="kl-si orange"><i class="fa fa-cutlery"></i></div>
            <div>
                <div class="kl-sv">{{ $kuliners->count() }}</div>
                <div class="kl-sl">Total Warung</div>
            </div>
        </div>
        <div class="kl-stat">
            <div class="kl-si green"><i class="fa fa-check-circle"></i></div>
            <div>
                <div class="kl-sv">{{ $kuliners->where('status', 'buka')->count() }}</div>
                <div class="kl-sl">Sedang Buka</div>
            </div>
        </div>
        <div class="kl-stat">
            <div class="kl-si red"><i class="fa fa-times-circle"></i></div>
            <div>
                <div class="kl-sv">{{ $kuliners->where('status', 'tutup')->count() }}</div>
                <div class="kl-sl">Sedang Tutup</div>
            </div>
        </div>
        <div class="kl-stat">
            <div class="kl-si blue"><i class="fa fa-tags"></i></div>
            <div>
                <div class="kl-sv">{{ $totalKat }}</div>
                <div class="kl-sl">Kategori</div>
            </div>
        </div>
    </div>

    <div class="kl-card">
        <div class="kl-toolbar">
            <div class="kl-search">
                <i class="fa fa-search"></i>
                <input type="text" id="klSearch" placeholder="Cari nama warung, alamat..." oninput="filterKuliner()">
            </div>
            <div class="kl-filters">
                <button class="kl-fbtn active" onclick="setFilter(this,'all')">Semua</button>
                <button class="kl-fbtn" onclick="setFilter(this,'buka')"><i class="fa fa-circle" style="color:#1a9e50;font-size:8px"></i> Buka</button>
                <button class="kl-fbtn" onclick="setFilter(this,'tutup')"><i class="fa fa-circle" style="color:#D10024;font-size:8px"></i> Tutup</button>
            </div>
            <span class="kl-count" id="klCount"></span>
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
                <a href="{{ route('admin.kuliner.create') }}" class="kl-addbtn" style="display:inline-flex"><i class="fa fa-plus"></i> Tambah Warung</a>
            </div>
        @else
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
                     data-search="{{ strtolower($kuliner->nama . ' ' . $kuliner->kategori . ' ' . $kuliner->alamat) }}"
                     data-status="{{ $kuliner->status }}">
                    <div class="kl-item-img">
                        @if($kuliner->gambar && file_exists(public_path('uploads/' . $kuliner->gambar)))
                            <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}" loading="lazy">
                        @else
                            <i class="fa fa-cutlery no-img"></i>
                        @endif
                        <span class="kl-item-status {{ $kuliner->status }}">
                            <i class="fa fa-circle" style="font-size:7px"></i>
                            {{ ucfirst($kuliner->status) }}
                        </span>
                    </div>
                    <div class="kl-item-body">
                        <div class="kl-item-kat {{ $katClass }}">
                            <i class="fa fa-tag"></i> {{ $kuliner->kategori }}
                        </div>
                        <div class="kl-item-name">{{ $kuliner->nama }}</div>
                        <div class="kl-item-meta">
                            <span><i class="fa fa-map-marker"></i> {{ Str::limit($kuliner->alamat, 48) }}</span>
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
                              style="flex:1; display:flex;"
                              onsubmit="return confirm('Hapus warung {{ addslashes($kuliner->nama) }}? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="kl-act-btn kl-act-delete" style="width:100%">
                                <i class="fa fa-trash"></i> Hapus
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

function setFilter(btn, filter) {
    activeFilter = filter;
    document.querySelectorAll('.kl-fbtn').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    filterKuliner();
}

function filterKuliner() {
    var q = document.getElementById('klSearch').value.toLowerCase().trim();
    var cards = document.querySelectorAll('#klGrid .kl-item');
    var count = 0;

    cards.forEach(function(card) {
        var matchSearch = !q || card.dataset.search.includes(q);
        var matchFilter = (activeFilter === 'all') || (card.dataset.status === activeFilter);
        var show = matchSearch && matchFilter;
        card.style.display = show ? '' : 'none';
        if (show) count++;
    });

    var total = cards.length;
    var el = document.getElementById('klCount');
    el.textContent = (q || activeFilter !== 'all') ? count + ' dari ' + total + ' warung' : '';

    var emptyEl = document.getElementById('klEmpty');
    if (emptyEl) emptyEl.style.display = (count === 0 && total > 0) ? '' : 'none';
}
</script>
@endsection
