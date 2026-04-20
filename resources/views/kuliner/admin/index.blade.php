@extends('layouts.admin')

@section('title', 'Kelola Kuliner - Admin Panel')

@section('content')
<style>
.kl-wrap { max-width:1100px; margin:0 auto; padding:4px 0 48px; }

/* Page header */
.kl-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.kl-page-title  { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.kl-page-title i { color:#d97706; font-size:20px; }

/* Stats */
.kl-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:700px){ .kl-stats{ grid-template-columns:repeat(2,1fr); } }
.kl-stat { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:20px; display:flex; align-items:center; gap:14px; }
.kl-si { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; }
.kl-si.orange { background:linear-gradient(135deg,#fef3c7,#fde68a); color:#d97706; }
.kl-si.green  { background:linear-gradient(135deg,#c8f7d6,#edfff3); color:#1a9e50; }
.kl-si.red    { background:linear-gradient(135deg,#ffd6d6,#ffefef); color:#D10024; }
.kl-si.blue   { background:linear-gradient(135deg,#c9e9ff,#edf6ff); color:#0369a1; }
.kl-sv { font-size:26px; font-weight:800; color:#1e1f29; line-height:1; }
.kl-sl { font-size:12px; color:#8d8d8d; margin-top:3px; font-weight:500; }

/* Main card */
.kl-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }

/* Toolbar */
.kl-toolbar { display:flex; align-items:center; gap:10px; padding:18px 22px; border-bottom:1px solid #f2f2f5; flex-wrap:wrap; }
.kl-search { display:flex; align-items:center; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden; transition:border .2s; background:#f9fafb; flex:1; min-width:180px; max-width:260px; }
.kl-search:focus-within { border-color:#d97706; background:#fff; }
.kl-search i { padding:0 11px; color:#c0c0c0; font-size:13px; }
.kl-search input { flex:1; border:none; outline:none; padding:10px 0; font-size:13px; background:transparent; font-family:inherit; }
.kl-filters { display:flex; gap:6px; flex-wrap:wrap; }
.kl-fbtn { padding:7px 14px; border:1.5px solid #e5e7eb; border-radius:20px; background:#fff; font-size:12px; font-weight:700; color:#666; cursor:pointer; font-family:inherit; transition:all .2s; display:inline-flex; align-items:center; gap:5px; white-space:nowrap; }
.kl-fbtn:hover { border-color:#d97706; color:#d97706; }
.kl-fbtn.active { background:#d97706; border-color:#d97706; color:#fff; }
.kl-view-toggle { display:flex; gap:4px; }
.kl-vtbtn { width:34px; height:34px; display:flex; align-items:center; justify-content:center; border:1.5px solid #e5e7eb; border-radius:8px; background:#fff; color:#aaa; cursor:pointer; transition:all .18s; font-size:13px; }
.kl-vtbtn.active { background:#1e1f29; border-color:#1e1f29; color:#fff; }
.kl-count { font-size:12px; color:#8d8d8d; white-space:nowrap; }
.kl-addbtn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; background:#D10024; color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .18s,transform .1s; margin-left:auto; white-space:nowrap; text-decoration:none; }
.kl-addbtn:hover { background:#a8001e; color:#fff; }
.kl-addbtn:active { transform:scale(.97); }

/* Alert */
.kl-alert { display:flex; align-items:center; gap:8px; padding:12px 22px; font-size:13px; }
.kl-alert.success { background:#d1fae5; border-bottom:1px solid #6ee7b7; color:#065f46; }
.kl-alert.error   { background:#fee2e2; border-bottom:1px solid #fca5a5; color:#991b1b; }

/* Grid view */
.kl-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(270px,1fr)); gap:18px; padding:22px; }
@media(max-width:600px){ .kl-grid{ grid-template-columns:1fr; } }

.kl-item { background:#fff; border-radius:14px; border:1.5px solid #f0f0f3; overflow:hidden; transition:box-shadow .2s,transform .18s,border-color .18s; }
.kl-item:hover { box-shadow:0 6px 24px rgba(0,0,0,.1); transform:translateY(-2px); border-color:#fde68a; }

.kl-item-img { width:100%; height:160px; background:linear-gradient(135deg,#fef3c7,#fde68a); display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative; }
.kl-item-img img { width:100%; height:100%; object-fit:cover; transition:transform .35s; }
.kl-item:hover .kl-item-img img { transform:scale(1.05); }
.kl-item-img .no-img { font-size:44px; color:rgba(217,119,6,.2); }

.kl-item-status { position:absolute; top:9px; right:9px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; display:flex; align-items:center; gap:4px; backdrop-filter:blur(4px); }
.kl-item-status.buka  { background:rgba(209,250,229,.92); color:#065f46; }
.kl-item-status.tutup { background:rgba(254,226,226,.92); color:#991b1b; }
.kl-item-status .dot  { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
.kl-item-status.buka .dot  { background:#10b981; }
.kl-item-status.tutup .dot { background:#ef4444; }

.kl-item-body { padding:14px 16px 10px; }
.kl-item-kat { display:inline-flex; align-items:center; gap:4px; font-size:10.5px; font-weight:700; padding:3px 9px; border-radius:6px; margin-bottom:8px; background:#fef3c7; color:#92400e; }
.kl-item-name { font-size:14px; font-weight:800; color:#1e1f29; margin:0 0 7px; line-height:1.3; }
.kl-item-meta { font-size:11.5px; color:#9ca3af; display:flex; flex-direction:column; gap:4px; }
.kl-item-meta span { display:flex; align-items:center; gap:6px; }
.kl-item-meta i { width:13px; text-align:center; color:#d97706; }

.kl-item-actions { display:flex; gap:7px; padding:10px 16px; border-top:1px solid #f5f5f8; background:#fafafa; }
.kl-act-btn { flex:1; display:inline-flex; align-items:center; justify-content:center; gap:4px; padding:7px 10px; border:none; border-radius:7px; font-size:11.5px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; text-decoration:none; }
.kl-act-edit   { background:#e3f2fd; color:#1565c0; }
.kl-act-edit:hover   { background:#bbdefb; }
.kl-act-delete { background:#fee2e2; color:#991b1b; }
.kl-act-delete:hover { background:#fecaca; }

/* List view */
.kl-list { display:none; }
.kl-list-row { display:flex; align-items:center; gap:14px; padding:13px 22px; border-bottom:1px solid #f7f7f9; transition:background .15s; }
.kl-list-row:last-child { border-bottom:none; }
.kl-list-row:hover { background:#fafbfc; }
.kl-list-thumb { width:50px; height:50px; border-radius:10px; flex-shrink:0; overflow:hidden; background:linear-gradient(135deg,#fef3c7,#fde68a); display:flex; align-items:center; justify-content:center; }
.kl-list-thumb img { width:100%; height:100%; object-fit:cover; }
.kl-list-thumb i  { font-size:20px; color:rgba(217,119,6,.35); }
.kl-list-info { flex:1; min-width:0; }
.kl-list-name { font-size:13px; font-weight:800; color:#1e1f29; margin:0 0 3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.kl-list-meta { font-size:11.5px; color:#9ca3af; display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
.kl-list-meta span { display:flex; align-items:center; gap:4px; }
.kl-list-meta i { color:#d97706; }
.kl-list-actions { display:flex; gap:6px; flex-shrink:0; }
.kl-list-btn { display:inline-flex; align-items:center; gap:4px; padding:6px 12px; border:none; border-radius:7px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; text-decoration:none; white-space:nowrap; }
.kl-list-btn.edit { background:#e3f2fd; color:#1565c0; }
.kl-list-btn.edit:hover { background:#bbdefb; }
.kl-list-btn.del  { background:#fee2e2; color:#991b1b; }
.kl-list-btn.del:hover  { background:#fecaca; }

/* Status badge (list) */
.kl-sbadge { display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; flex-shrink:0; }
.kl-sbadge.buka  { background:#d1fae5; color:#065f46; }
.kl-sbadge.tutup { background:#fee2e2; color:#991b1b; }
.kl-sbadge i { font-size:7px; }

/* Empty */
.kl-empty { text-align:center; padding:64px 24px; }
.kl-empty-icon { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#fef3c7,#fde68a); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.kl-empty-icon i { font-size:28px; color:#d97706; }
.kl-empty h4 { font-size:15px; font-weight:700; color:#374151; margin:0 0 6px; }
.kl-empty p  { font-size:13px; color:#9ca3af; margin:0 0 18px; }
</style>

<div class="kl-wrap">
    {{-- Page header --}}
    <div class="kl-page-header">
        <h1 class="kl-page-title"><i class="fa fa-cutlery"></i> Manajemen Kuliner</h1>
        <a href="{{ route('kuliner.index') }}" target="_blank"
           style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;background:#f4f5f7;color:#555;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none;transition:background .15s">
            <i class="fa fa-external-link"></i> Lihat di Situs
        </a>
    </div>

    {{-- Stats --}}
    @php $totalKat = $kuliners->pluck('kategori')->unique()->count(); @endphp
    <div class="kl-stats">
        <div class="kl-stat">
            <div class="kl-si orange"><i class="fa fa-cutlery"></i></div>
            <div><div class="kl-sv">{{ $kuliners->count() }}</div><div class="kl-sl">Total Warung</div></div>
        </div>
        <div class="kl-stat">
            <div class="kl-si green"><i class="fa fa-check-circle"></i></div>
            <div><div class="kl-sv">{{ $kuliners->where('status','buka')->count() }}</div><div class="kl-sl">Sedang Buka</div></div>
        </div>
        <div class="kl-stat">
            <div class="kl-si red"><i class="fa fa-times-circle"></i></div>
            <div><div class="kl-sv">{{ $kuliners->where('status','tutup')->count() }}</div><div class="kl-sl">Sedang Tutup</div></div>
        </div>
        <div class="kl-stat">
            <div class="kl-si blue"><i class="fa fa-tags"></i></div>
            <div><div class="kl-sv">{{ $totalKat }}</div><div class="kl-sl">Kategori</div></div>
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
            <a href="{{ route('admin.kuliner.create') }}" class="kl-addbtn">
                <i class="fa fa-plus"></i> Tambah Warung
            </a>
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
                <a href="{{ route('admin.kuliner.create') }}" class="kl-addbtn" style="margin:0 auto;display:inline-flex">
                    <i class="fa fa-plus"></i> Tambah Warung
                </a>
            </div>
        @else
            {{-- Grid View --}}
            <div class="kl-grid" id="klGrid">
                @foreach($kuliners as $kuliner)
                <div class="kl-item"
                     data-search="{{ strtolower($kuliner->nama.' '.$kuliner->kategori.' '.$kuliner->alamat) }}"
                     data-status="{{ $kuliner->status }}">
                    <div class="kl-item-img">
                        @if($kuliner->gambar && file_exists(public_path('uploads/'.$kuliner->gambar)))
                            <img src="{{ asset('uploads/'.$kuliner->gambar) }}" alt="{{ $kuliner->nama }}" loading="lazy">
                        @else
                            <i class="fa fa-cutlery no-img"></i>
                        @endif
                        <span class="kl-item-status {{ $kuliner->status }}">
                            <span class="dot"></span> {{ ucfirst($kuliner->status) }}
                        </span>
                    </div>
                    <div class="kl-item-body">
                        <div class="kl-item-kat"><i class="fa fa-tag"></i> {{ $kuliner->kategori }}</div>
                        <div class="kl-item-name">{{ $kuliner->nama }}</div>
                        <div class="kl-item-meta">
                            <span><i class="fa fa-map-marker"></i> {{ Str::limit($kuliner->alamat, 48) }}</span>
                            <span><i class="fa fa-clock-o"></i> {{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</span>
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
                            <span><i class="fa fa-tag"></i> {{ $kuliner->kategori }}</span>
                            <span><i class="fa fa-map-marker"></i> {{ Str::limit($kuliner->alamat, 38) }}</span>
                            <span><i class="fa fa-clock-o"></i> {{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</span>
                        </div>
                    </div>
                    <span class="kl-sbadge {{ $kuliner->status }}">
                        <i class="fa fa-circle"></i> {{ ucfirst($kuliner->status) }}
                    </span>
                    <div class="kl-list-actions">
                        <a href="{{ route('admin.kuliner.edit', $kuliner->id) }}" class="kl-list-btn edit">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.kuliner.destroy', $kuliner->id) }}" method="POST"
                              onsubmit="return confirm('Hapus warung {{ addslashes($kuliner->nama) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="kl-list-btn del"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div id="klEmpty2" style="display:none" class="kl-empty">
                <div class="kl-empty-icon"><i class="fa fa-search"></i></div>
                <h4>Tidak Ditemukan</h4>
                <p>Coba kata kunci atau filter lain.</p>
            </div>
        @endif
    </div>
</div>

<script>
var activeFilter = 'all';
var activeView   = 'grid';

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
    var q   = document.getElementById('klSearch').value.toLowerCase().trim();
    var sel = activeView === 'grid' ? '#klGrid .kl-item' : '#klList .kl-list-row';
    var items = document.querySelectorAll(sel);
    var count = 0;
    items.forEach(function(item) {
        var ms = !q || item.dataset.search.includes(q);
        var mf = activeFilter === 'all' || item.dataset.status === activeFilter;
        item.style.display = (ms && mf) ? '' : 'none';
        if (ms && mf) count++;
    });
    var el = document.getElementById('klCount');
    el.textContent = (q || activeFilter !== 'all') ? count + ' dari ' + items.length + ' warung' : '';
    var emp = document.getElementById('klEmpty2');
    if (emp) emp.style.display = (count === 0 && items.length > 0) ? '' : 'none';
}
</script>
@endsection
