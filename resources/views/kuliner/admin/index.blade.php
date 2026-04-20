@extends('layouts.admin')

@section('title', 'Manajemen Kuliner - Admin Panel')

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
.kl-stat { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:18px; display:flex; align-items:center; gap:13px; }
.kl-si { width:46px; height:46px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.kl-si.orange { background:linear-gradient(135deg,#fef3c7,#fde68a); color:#d97706; }
.kl-si.green  { background:linear-gradient(135deg,#c8f7d6,#edfff3); color:#1a9e50; }
.kl-si.red    { background:linear-gradient(135deg,#ffd6d6,#ffefef); color:#D10024; }
.kl-si.blue   { background:linear-gradient(135deg,#c9e9ff,#edf6ff); color:#0369a1; }
.kl-sv { font-size:26px; font-weight:800; color:#1e1f29; line-height:1; }
.kl-sl { font-size:11.5px; color:#8d8d8d; margin-top:3px; font-weight:500; }

/* Main card */
.kl-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:visible; }

/* Toolbar */
.kl-toolbar { display:flex; align-items:center; gap:12px; padding:18px 22px; border-bottom:1px solid #f2f2f5; flex-wrap:wrap; }
.kl-search { display:flex; align-items:center; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden; transition:border .2s; background:#f9fafb; flex:1; min-width:180px; max-width:260px; }
.kl-search:focus-within { border-color:#d97706; background:#fff; }
.kl-search i { padding:0 11px; color:#c0c0c0; font-size:13px; }
.kl-search input { flex:1; border:none; outline:none; padding:10px 0; font-size:13px; background:transparent; font-family:inherit; }
.kl-filters { display:flex; gap:6px; flex-wrap:wrap; }
.kl-fbtn { padding:7px 14px; border:1.5px solid #e5e7eb; border-radius:20px; background:#fff; font-size:12px; font-weight:700; color:#666; cursor:pointer; font-family:inherit; transition:all .2s; display:inline-flex; align-items:center; gap:5px; white-space:nowrap; }
.kl-fbtn:hover { border-color:#d97706; color:#d97706; }
.kl-fbtn.active { background:#d97706; border-color:#d97706; color:#fff; }
.kl-addbtn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; background:#D10024; color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .18s,transform .1s; margin-left:auto; white-space:nowrap; text-decoration:none; }
.kl-addbtn:hover { background:#a8001e; color:#fff; }
.kl-addbtn:active { transform:scale(.97); }

/* Alert */
.kl-alert { display:flex; align-items:center; gap:8px; padding:12px 22px; font-size:13px; border-bottom:1px solid transparent; }
.kl-alert.success { background:#d1fae5; border-color:#6ee7b7; color:#065f46; }
.kl-alert.error   { background:#fee2e2; border-color:#fca5a5; color:#991b1b; }

/* Table */
.kl-table-wrap { overflow-x:auto; border-radius:0 0 16px 16px; }
.kl-table { width:100%; border-collapse:collapse; font-size:13px; }
.kl-table th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:11px 16px; text-align:left; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.kl-table td { padding:12px 16px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.kl-row:hover td { background:#fafbfc; }

/* Warung cell */
.kl-warung { display:flex; align-items:center; gap:10px; }
.kl-warung-img { width:44px; height:44px; border-radius:9px; object-fit:cover; background:linear-gradient(135deg,#fef3c7,#fde68a); flex-shrink:0; display:flex; align-items:center; justify-content:center; color:rgba(217,119,6,.4); font-size:16px; border:1px solid #f0f0f0; overflow:hidden; }
.kl-warung-img img { width:100%; height:100%; object-fit:cover; }
.kl-warung-name { font-weight:700; color:#1e1f29; font-size:13px; line-height:1.3; max-width:160px; }
.kl-warung-id { font-size:10px; color:#bbb; margin-top:2px; }

/* Category badge */
.kl-kat { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; background:#fef3c7; color:#92400e; white-space:nowrap; }

/* Meta */
.kl-meta { font-size:12px; color:#555; line-height:1.7; }
.kl-meta i { color:#d97706; margin-right:4px; font-size:11px; }

/* Status badge */
.kl-badge { display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:700; padding:4px 11px; border-radius:20px; white-space:nowrap; }
.kl-badge i { font-size:7px; }
.kl-badge.buka  { background:#d1fae5; color:#065f46; }
.kl-badge.tutup { background:#fee2e2; color:#991b1b; }

/* Actions */
.kl-actions { display:flex; gap:5px; flex-wrap:nowrap; }
.kl-btn { display:inline-flex; align-items:center; gap:4px; padding:6px 11px; border:none; border-radius:7px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; white-space:nowrap; text-decoration:none; }
.kl-btn.edit { background:#e3f2fd; color:#1565c0; }
.kl-btn.edit:hover { background:#bbdefb; }
.kl-btn.del  { background:#fee2e2; color:#991b1b; }
.kl-btn.del:hover  { background:#fecaca; }

/* Empty */
.kl-empty { text-align:center; padding:64px 24px; }
.kl-empty-icon { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#fde68a,#fffbeb); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.kl-empty-icon i { font-size:28px; color:#d97706; }
.kl-empty h4 { font-size:15px; font-weight:700; color:#374151; margin:0 0 6px; }
.kl-empty p  { font-size:13px; color:#9ca3af; margin:0; }

/* Admin Hero Banner */
.admin-hero { background:linear-gradient(135deg,#0f0519 0%,#1a0a2e 55%,#2d1500 100%); border-radius:18px; padding:28px 28px 24px; margin-bottom:22px; display:flex; align-items:center; gap:20px; flex-wrap:wrap; color:#fff; position:relative; overflow:hidden; }
.admin-hero::before { content:''; position:absolute; top:-80px; right:-80px; width:260px; height:260px; background:radial-gradient(circle,rgba(217,119,6,.35) 0%,transparent 65%); pointer-events:none; }
.admin-hero-left { display:flex; align-items:center; gap:16px; flex:1; min-width:200px; position:relative; z-index:1; }
.admin-hero-icon { width:54px; height:54px; background:rgba(255,255,255,.12); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0; border:1px solid rgba(255,255,255,.2); }
.admin-hero-title { font-size:22px; font-weight:800; margin:0 0 4px; letter-spacing:-.4px; }
.admin-hero-sub { font-size:13px; margin:0; opacity:.7; }
.admin-hero-stats { display:flex; gap:10px; flex-wrap:wrap; position:relative; z-index:1; }
.admin-hero-stat { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.16); border-radius:12px; padding:10px 18px; text-align:center; min-width:72px; }
.admin-hero-stat-num { font-size:24px; font-weight:800; line-height:1; }
.admin-hero-stat-label { font-size:11px; opacity:.7; margin-top:3px; font-weight:600; letter-spacing:.3px; text-transform:uppercase; }
.admin-hero-action { position:relative; z-index:1; }
.admin-hero-addbtn { display:inline-flex; align-items:center; gap:8px; padding:11px 20px; background:#D10024; color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; text-decoration:none; box-shadow:0 4px 14px rgba(209,0,36,.4); }
.admin-hero-addbtn:hover { background:#a8001e; color:#fff; }
@media(max-width:768px) { .admin-hero { flex-direction:column; align-items:flex-start; } }

/* Modal */
.kl-overlay { display:none; position:fixed; inset:0; background:rgba(10,12,20,.55); z-index:9000; justify-content:center; align-items:center; padding:20px; }
.kl-overlay.open { display:flex; }
.kl-modal { background:#fff; border-radius:18px; width:400px; max-width:100%; box-shadow:0 24px 64px rgba(0,0,0,.28); animation:klSlideIn .2s ease; overflow:hidden; }
@keyframes klSlideIn { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:translateY(0)} }
.kl-mheader { padding:18px 24px 16px; background:linear-gradient(135deg,#1a1f2e 0%,#2d3347 100%); display:flex; align-items:center; justify-content:space-between; }
.kl-mtitle { font-size:15px; font-weight:800; color:#fff; display:flex; align-items:center; gap:8px; }
.kl-mtitle i { color:rgba(255,255,255,.5); }
.kl-mclose { background:rgba(255,255,255,.12); border:none; font-size:18px; color:#fff; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:8px; line-height:1; }
.kl-mclose:hover { background:rgba(255,255,255,.25); }
.kl-mbody { padding:24px; }
.kl-micon { text-align:center; font-size:44px; margin-bottom:14px; color:#ef4444; }
.kl-mtext { text-align:center; font-size:14px; color:#333; line-height:1.6; margin-bottom:6px; }
.kl-msub  { text-align:center; font-size:12px; color:#aaa; }
.kl-mfooter { display:flex; justify-content:flex-end; gap:10px; margin-top:24px; }
.btn-mok-danger { padding:10px 22px; background:#ef4444; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; }
.btn-mok-danger:hover { background:#dc2626; }
.btn-mcancel { padding:10px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; }
.btn-mcancel:hover { background:#e5e7eb; }
</style>

<div class="kl-wrap">

    {{-- Hero Banner --}}
    @php $totalKat = $kuliners->pluck('kategori')->unique()->count(); @endphp
    <div class="admin-hero">
        <div class="admin-hero-left">
            <div class="admin-hero-icon"><i class="fa fa-cutlery"></i></div>
            <div>
                <h1 class="admin-hero-title">Manajemen Kuliner</h1>
                <p class="admin-hero-sub">Kelola informasi warung kuliner lokal di NusaMart</p>
            </div>
        </div>
        <div class="admin-hero-stats">
            <div class="admin-hero-stat">
                <div class="admin-hero-stat-num">{{ $kuliners->count() }}</div>
                <div class="admin-hero-stat-label">Total</div>
            </div>
            <div class="admin-hero-stat">
                <div class="admin-hero-stat-num" style="color:#6ee7b7;">{{ $kuliners->where('status','buka')->count() }}</div>
                <div class="admin-hero-stat-label">Buka</div>
            </div>
            <div class="admin-hero-stat">
                <div class="admin-hero-stat-num" style="color:#fca5a5;">{{ $kuliners->where('status','tutup')->count() }}</div>
                <div class="admin-hero-stat-label">Tutup</div>
            </div>
            <div class="admin-hero-stat">
                <div class="admin-hero-stat-num" style="color:#fde68a;">{{ $totalKat }}</div>
                <div class="admin-hero-stat-label">Kategori</div>
            </div>
        </div>
        <div class="admin-hero-action">
            <a href="{{ route('admin.kuliner.create') }}" class="admin-hero-addbtn">
                <i class="fa fa-plus"></i> Tambah Warung
            </a>
        </div>
    </div>

    {{-- Stats clickable --}}
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
                    <i class="fa fa-circle" style="font-size:8px;color:#10b981"></i> Buka
                </button>
                <button class="kl-fbtn" onclick="setFilter(this,'tutup')">
                    <i class="fa fa-circle" style="font-size:8px;color:#ef4444"></i> Tutup
                </button>
            </div>
            <a href="{{ route('kuliner.index') }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#f4f5f7;color:#555;border:none;border-radius:9px;font-size:12px;font-weight:700;text-decoration:none;margin-left:auto">
                <i class="fa fa-external-link"></i> Lihat di Situs
            </a>
        </div>

        @if(session('success'))
            <div class="kl-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="kl-alert error"><i class="fa fa-exclamation-triangle"></i> {{ session('error') }}</div>
        @endif

        @if($kuliners->isEmpty())
            <div class="kl-empty">
                <div class="kl-empty-icon"><i class="fa fa-cutlery"></i></div>
                <h4>Belum Ada Warung</h4>
                <p>Mulai tambahkan warung kuliner lokal pertama.</p>
            </div>
        @else
        <div class="kl-table-wrap">
            <table class="kl-table">
                <thead>
                    <tr>
                        <th>Warung</th>
                        <th>Kategori</th>
                        <th>Lokasi &amp; Jam</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="klBody">
                @foreach($kuliners as $kuliner)
                <tr class="kl-row"
                    data-search="{{ strtolower($kuliner->nama.' '.$kuliner->kategori.' '.$kuliner->alamat) }}"
                    data-status="{{ $kuliner->status }}">
                    <td>
                        <div class="kl-warung">
                            <div class="kl-warung-img">
                                @if($kuliner->gambar && file_exists(public_path('uploads/'.$kuliner->gambar)))
                                    <img src="{{ asset('uploads/'.$kuliner->gambar) }}" alt="{{ $kuliner->nama }}" loading="lazy">
                                @else
                                    <i class="fa fa-cutlery"></i>
                                @endif
                            </div>
                            <div>
                                <div class="kl-warung-name">{{ $kuliner->nama }}</div>
                                <div class="kl-warung-id">#{{ $kuliner->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="kl-kat">{{ $kuliner->kategori }}</span></td>
                    <td>
                        <div class="kl-meta">
                            <div><i class="fa fa-map-marker"></i> {{ Str::limit($kuliner->alamat, 40) }}</div>
                            <div><i class="fa fa-clock-o"></i> {{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</div>
                        </div>
                    </td>
                    <td>
                        @if($kuliner->kontak_wa)
                            <div class="kl-meta"><i class="fa fa-whatsapp"></i> +{{ $kuliner->kontak_wa }}</div>
                        @else
                            <span style="color:#bbb;font-size:12px;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($kuliner->status === 'buka')
                            <span class="kl-badge buka"><i class="fa fa-circle"></i> Buka</span>
                        @else
                            <span class="kl-badge tutup"><i class="fa fa-circle"></i> Tutup</span>
                        @endif
                    </td>
                    <td>
                        <div class="kl-actions">
                            <a href="{{ route('admin.kuliner.edit', $kuliner->id) }}" class="kl-btn edit">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            <button type="button" class="kl-btn del"
                                    onclick="klOpenDelete({{ $kuliner->id }}, '{{ addslashes($kuliner->nama) }}')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div id="klEmpty2" style="display:none" class="kl-empty">
            <div class="kl-empty-icon"><i class="fa fa-search"></i></div>
            <h4>Tidak Ditemukan</h4>
            <p>Coba kata kunci atau filter lain.</p>
        </div>
        @endif
    </div>

</div>

{{-- Modal: Hapus --}}
<div class="kl-overlay" id="klModalDelete">
    <div class="kl-modal">
        <div class="kl-mheader">
            <span class="kl-mtitle"><i class="fa fa-trash"></i> Hapus Warung</span>
            <button type="button" class="kl-mclose" onclick="klCloseModal()">&times;</button>
        </div>
        <div class="kl-mbody">
            <div class="kl-micon"><i class="fa fa-exclamation-triangle"></i></div>
            <div class="kl-mtext">Hapus warung <strong id="klDeleteName"></strong>?</div>
            <div class="kl-msub">Tindakan ini permanen dan tidak dapat dibatalkan.</div>
            <form method="POST" id="klDeleteForm" action="">
                @csrf @method('DELETE')
                <div class="kl-mfooter">
                    <button type="button" class="btn-mcancel" onclick="klCloseModal()">Batal</button>
                    <button type="submit" class="btn-mok-danger"><i class="fa fa-trash"></i> Ya, Hapus</button>
                </div>
            </form>
        </div>
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
    var rows = document.querySelectorAll('#klBody .kl-row');
    var count = 0;
    rows.forEach(function(row) {
        var ms = !q || row.dataset.search.includes(q);
        var mf = activeFilter === 'all' || row.dataset.status === activeFilter;
        row.style.display = (ms && mf) ? '' : 'none';
        if (ms && mf) count++;
    });
    var emp = document.getElementById('klEmpty2');
    if (emp) emp.style.display = (count === 0 && rows.length > 0) ? '' : 'none';
}

function klOpenDelete(id, nama) {
    document.getElementById('klDeleteName').textContent = nama;
    document.getElementById('klDeleteForm').action = '/admin/kuliner/' + id;
    document.getElementById('klModalDelete').classList.add('open');
}

function klCloseModal() {
    document.getElementById('klModalDelete').classList.remove('open');
}

document.getElementById('klModalDelete').addEventListener('click', function(e) {
    if (e.target === this) klCloseModal();
});
</script>
@endsection
