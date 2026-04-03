@extends('layouts.app')

@section('title', 'Manajemen Kurir - NusaMart Admin')

@section('content')
<style>
/* ── Wrap ────────────────────────────────── */
.ck-wrap { max-width:1140px; margin:0 auto; padding:28px 16px 48px; }

/* ── Page header ─────────────────────────── */
.ck-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.ck-page-title  { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.ck-page-title i { color:#D10024; font-size:20px; }
.ck-back-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:background .15s; font-family:inherit; }
.ck-back-btn:hover { background:#e5e7eb; color:#1e1f29; }

/* ── Stats ───────────────────────────────── */
.ck-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:700px){ .ck-stats{ grid-template-columns:repeat(2,1fr); } }
.ck-stat { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:20px; display:flex; align-items:center; gap:14px; }
.ck-si { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; }
.ck-si.red   { background:linear-gradient(135deg,#ffd6d6,#ffefef); color:#D10024; }
.ck-si.green { background:linear-gradient(135deg,#c8f7d6,#edfff3); color:#1a9e50; }
.ck-si.grey  { background:linear-gradient(135deg,#e5e7eb,#f3f4f6); color:#6b7280; }
.ck-si.blue  { background:linear-gradient(135deg,#c9e9ff,#edf6ff); color:#1565c0; }
.ck-sv { font-size:26px; font-weight:800; color:#1e1f29; line-height:1; }
.ck-sl { font-size:12px; color:#8d8d8d; margin-top:3px; font-weight:500; }

/* ── Main card ───────────────────────────── */
.ck-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }

/* ── Toolbar ─────────────────────────────── */
.ck-toolbar { display:flex; align-items:center; gap:12px; padding:18px 22px; border-bottom:1px solid #f2f2f5; flex-wrap:wrap; }
.ck-search { display:flex; align-items:center; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden; transition:border .2s; background:#f9fafb; flex:1; min-width:180px; max-width:280px; }
.ck-search:focus-within { border-color:#D10024; background:#fff; }
.ck-search i { padding:0 12px; color:#c0c0c0; font-size:13px; }
.ck-search input { flex:1; border:none; outline:none; padding:10px 0; font-size:13px; background:transparent; font-family:inherit; }
.ck-filters { display:flex; gap:6px; flex-wrap:wrap; }
.ck-fbtn { padding:8px 16px; border:1.5px solid #e5e7eb; border-radius:20px; background:#fff; font-size:12px; font-weight:700; color:#666; cursor:pointer; font-family:inherit; transition:all .2s; display:inline-flex; align-items:center; gap:5px; white-space:nowrap; }
.ck-fbtn:hover { border-color:#D10024; color:#D10024; }
.ck-fbtn.active { background:#D10024; border-color:#D10024; color:#fff; }
.ck-addbtn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; background:#D10024; color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .18s,transform .1s; margin-left:auto; white-space:nowrap; }
.ck-addbtn:hover { background:#a8001e; }
.ck-addbtn:active { transform:scale(.97); }
.ck-count { font-size:12px; color:#aaa; white-space:nowrap; }

/* ── Alerts ──────────────────────────────── */
.ck-alert { display:flex; align-items:center; gap:8px; padding:12px 22px; font-size:13px; }
.ck-alert.success { background:#d1fae5; border-bottom:1px solid #6ee7b7; color:#065f46; }
.ck-alert.error   { background:#fee2e2; border-bottom:1px solid #fca5a5; color:#991b1b; }

/* ── Table ───────────────────────────────── */
.ck-table-wrap { overflow-x:auto; }
.ck-table { width:100%; border-collapse:collapse; font-size:13px; }
.ck-table th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:11px 16px; text-align:left; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.ck-table td { padding:13px 16px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.ck-cr { cursor:pointer; }
.ck-cr:hover td { background:#fafbfc; }
.ck-cr.ck-open td { background:#fff8f8; border-bottom-color:transparent; }

/* ── Courier cell ────────────────────────── */
.ck-cc { display:flex; align-items:center; gap:12px; }
.ck-logo { width:44px; height:44px; border-radius:11px; background:linear-gradient(135deg,#f0f1f5,#e8eaf0); display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden; border:1px solid #ebebeb; }
.ck-logo img { width:100%; height:100%; object-fit:contain; padding:4px; box-sizing:border-box; }
.ck-logo i { font-size:18px; color:#c4c6d0; }
.ck-cn { font-size:13px; font-weight:700; color:#1e1f29; }
.ck-code { display:inline-block; background:#f0f1f5; color:#5b21b6; font-size:10px; font-weight:700; padding:2px 7px; border-radius:5px; text-transform:uppercase; margin-top:3px; }
.ck-desc { font-size:12px; color:#9ca3af; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

/* ── Badges ──────────────────────────────── */
.ck-badge { display:inline-block; padding:3px 11px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; }
.ck-badge.aktif    { background:#d1fae5; color:#065f46; }
.ck-badge.nonaktif { background:#fee2e2; color:#991b1b; }
.ck-badge.svc      { background:#ede9fe; color:#5b21b6; }

/* ── Action buttons ──────────────────────── */
.ck-actions { display:flex; gap:6px; align-items:center; }
.ck-btn { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border:none; border-radius:7px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; white-space:nowrap; }
.ck-btn.edit  { background:#e3f2fd; color:#1565c0; }
.ck-btn.edit:hover { background:#bbdefb; }
.ck-btn.ton   { background:#d1fae5; color:#065f46; }
.ck-btn.ton:hover  { background:#a7f3d0; }
.ck-btn.toff  { background:#fef3c7; color:#92400e; }
.ck-btn.toff:hover { background:#fde68a; }
.ck-btn.del   { background:#fee2e2; color:#991b1b; }
.ck-btn.del:hover  { background:#fecaca; }
.ck-expand { font-size:11px; color:#ccc; transition:transform .22s; display:inline-block; margin-left:2px; }
.ck-cr.ck-open .ck-expand { transform:rotate(180deg); color:#D10024; }

/* ── Services expand row ─────────────────── */
.ck-svc-tr { display:none; }
.ck-svc-tr.ck-open { display:table-row; }
.ck-svc-outer { background:#f8f9fb; padding:0 0 20px; border-bottom:2px solid #fee2e2; }
.ck-svc-inner { padding:16px 20px 0; }
.ck-svc-head { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#8d8d8d; margin-bottom:12px; display:flex; align-items:center; gap:6px; }
.ck-svc-head i { color:#D10024; }
.ck-svctbl { width:100%; border-collapse:collapse; font-size:13px; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,.06); }
.ck-svctbl th { background:#f0f1f5; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:#888; padding:9px 14px; text-align:left; }
.ck-svctbl td { padding:10px 14px; border-bottom:1px solid #f5f5f5; vertical-align:middle; }
.ck-svctbl tr:last-child td { border-bottom:none; }
.ck-sbadge { display:inline-block; padding:2px 9px; border-radius:12px; font-size:10px; font-weight:700; }
.ck-sbadge.aktif    { background:#d1fae5; color:#065f46; }
.ck-sbadge.nonaktif { background:#fee2e2; color:#991b1b; }
.ck-scode { display:inline-block; background:#f0f1f5; color:#5b21b6; font-size:11px; font-weight:700; padding:2px 8px; border-radius:6px; }
.ck-svc-add-btn { margin-top:12px; display:inline-flex; align-items:center; gap:6px; padding:7px 14px; background:#ede9fe; color:#5b21b6; border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; }
.ck-svc-add-btn:hover { background:#ddd6fe; }
.ck-svc-form { background:#fff; border:1.5px dashed #D10024; border-radius:10px; padding:14px 16px; margin-top:10px; display:none; }
.ck-svc-form.ck-open { display:block; }
.ck-sfrow { display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; align-items:end; }
@media(max-width:600px){ .ck-sfrow{ grid-template-columns:1fr 1fr; } }
.ck-sfg label { font-size:11px; font-weight:700; color:#555; display:block; margin-bottom:5px; }
.ck-sfg input { width:100%; padding:8px 10px; border:1.5px solid #e5e7eb; border-radius:7px; font-size:13px; font-family:inherit; outline:none; box-sizing:border-box; transition:border .2s; }
.ck-sfg input:focus { border-color:#D10024; }
.ck-sfa { display:flex; gap:8px; margin-top:10px; }
.ck-sfs { padding:8px 16px; background:#D10024; color:#fff; border:none; border-radius:7px; font-size:12px; font-weight:700; cursor:pointer; font-family:inherit; }
.ck-sfs:hover { background:#a8001e; }
.ck-sfc { padding:8px 14px; background:#f4f5f7; color:#555; border:none; border-radius:7px; font-size:12px; font-weight:700; cursor:pointer; font-family:inherit; }
.ck-sfc:hover { background:#e5e7eb; }
.ck-svc-empty { text-align:center; padding:18px; color:#bbb; font-size:12px; }

/* ── Empty state ─────────────────────────── */
.ck-empty { text-align:center; padding:64px 24px; }
.ck-empty-icon { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#ffd6d6,#ffefef); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.ck-empty-icon i { font-size:28px; color:#D10024; }
.ck-empty h4 { font-size:15px; font-weight:700; color:#374151; margin:0 0 6px; }
.ck-empty p { font-size:13px; color:#9ca3af; margin:0; }

/* ── Modals ──────────────────────────────── */
.cm-overlay { display:none; position:fixed; inset:0; background:rgba(10,12,20,.55); z-index:9000; justify-content:center; align-items:center; padding:20px; }
.cm-overlay.open { display:flex; }
.cm-modal { background:#fff; border-radius:18px; width:480px; max-width:100%; max-height:90vh; overflow-y:auto; box-shadow:0 24px 64px rgba(0,0,0,.28); animation:cmSlideIn .22s ease; }
@keyframes cmSlideIn { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
.cm-modal::-webkit-scrollbar { width:4px; }
.cm-modal::-webkit-scrollbar-thumb { background:#e5e7eb; border-radius:2px; }
.cm-header { padding:18px 24px 16px; background:linear-gradient(135deg,#1a1f2e 0%,#2d3347 100%); border-radius:18px 18px 0 0; display:flex; align-items:center; justify-content:space-between; }
.cm-title { font-size:15px; font-weight:800; color:#fff; display:flex; align-items:center; gap:8px; }
.cm-title i { color:rgba(255,255,255,.55); }
.cm-close { background:rgba(255,255,255,.12); border:none; font-size:18px; color:#fff; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:8px; transition:background .15s; line-height:1; }
.cm-close:hover { background:rgba(255,255,255,.25); }
.cm-body { padding:20px 24px 24px; }
.cm-field { margin-bottom:16px; }
.cm-field label { display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:7px; }
.cm-field input, .cm-field textarea { width:100%; padding:10px 12px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; outline:none; box-sizing:border-box; transition:border .2s; }
.cm-field input:focus, .cm-field textarea:focus { border-color:#D10024; }
.cm-field textarea { resize:vertical; min-height:72px; }
.cm-field .hint { font-size:11px; color:#aaa; margin-top:4px; }
.cm-logo-preview { width:72px; height:72px; border-radius:8px; object-fit:contain; border:1px solid #ebebeb; background:#f4f5f7; padding:4px; }
.cm-footer { display:flex; justify-content:flex-end; gap:10px; padding-top:4px; }
.btn-cm-save { padding:10px 22px; background:#D10024; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; }
.btn-cm-save:hover { background:#a8001e; }
.btn-cm-cancel { padding:10px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; }
.btn-cm-cancel:hover { background:#e5e7eb; }
.del-modal { width:360px; }
.del-icon { text-align:center; padding:8px 0 16px; font-size:44px; color:#D10024; }
.del-text { text-align:center; font-size:14px; color:#333; line-height:1.6; margin-bottom:6px; }
.del-sub  { text-align:center; font-size:12px; color:#aaa; }
</style>

<div class="ck-wrap">

    <div class="ck-page-header">
        <h1 class="ck-page-title"><i class="fa fa-truck"></i> Manajemen Kurir Pengiriman</h1>
        <a href="{{ route('dashboard') }}" class="ck-back-btn"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>

    {{-- Stats --}}
    <div class="ck-stats">
        <div class="ck-stat"><div class="ck-si red"><i class="fa fa-truck"></i></div><div><div class="ck-sv">{{ $stats['total'] }}</div><div class="ck-sl">Total Kurir</div></div></div>
        <div class="ck-stat"><div class="ck-si green"><i class="fa fa-check-circle"></i></div><div><div class="ck-sv">{{ $stats['active'] }}</div><div class="ck-sl">Kurir Aktif</div></div></div>
        <div class="ck-stat"><div class="ck-si grey"><i class="fa fa-ban"></i></div><div><div class="ck-sv">{{ $stats['inactive'] }}</div><div class="ck-sl">Nonaktif</div></div></div>
        <div class="ck-stat"><div class="ck-si blue"><i class="fa fa-list-alt"></i></div><div><div class="ck-sv">{{ $stats['services'] }}</div><div class="ck-sl">Layanan Aktif</div></div></div>
    </div>

    <div class="ck-card">

        {{-- Toolbar --}}
        <div class="ck-toolbar">
            <div class="ck-search">
                <i class="fa fa-search"></i>
                <input type="text" id="ckSearch" placeholder="Cari nama atau kode kurir..." oninput="ckFilter()">
            </div>
            <div class="ck-filters">
                <button type="button" onclick="ckSetFilter('')"        id="ckFAll"     class="ck-fbtn active">Semua</button>
                <button type="button" onclick="ckSetFilter('aktif')"   id="ckFAktif"   class="ck-fbtn"><i class="fa fa-check-circle" style="font-size:10px"></i> Aktif</button>
                <button type="button" onclick="ckSetFilter('nonaktif')" id="ckFNonaktif" class="ck-fbtn"><i class="fa fa-ban" style="font-size:10px"></i> Nonaktif</button>
            </div>
            <button type="button" class="ck-addbtn" onclick="openAddModal()">
                <i class="fa fa-plus"></i> Tambah Kurir
            </button>
        </div>

        @if(session('success'))
            <div class="ck-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="ck-alert error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="ck-alert error"><i class="fa fa-exclamation-triangle"></i> {{ $errors->first() }}</div>
        @endif

        <div class="ck-table-wrap">
            @if($couriers->isEmpty())
                <div class="ck-empty">
                    <div class="ck-empty-icon"><i class="fa fa-truck"></i></div>
                    <h4>Belum Ada Kurir Terdaftar</h4>
                    <p>Klik <strong>Tambah Kurir</strong> untuk menambahkan kurir pengiriman pertama.</p>
                </div>
            @else
            <table class="ck-table">
                <thead>
                    <tr>
                        <th>Kurir</th>
                        <th>Deskripsi</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th style="width:36px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($couriers as $courier)
                    {{-- Main row --}}
                    <tr class="ck-cr"
                        id="ckRow{{ $courier->id }}"
                        data-search="{{ strtolower($courier->name . ' ' . $courier->code) }}"
                        data-status="{{ $courier->is_active ? 'aktif' : 'nonaktif' }}"
                        onclick="toggleCourier({{ $courier->id }})">
                        <td>
                            <div class="ck-cc">
                                <div class="ck-logo">
                                    @if($courier->logo)
                                        <img src="{{ asset('storage/'.$courier->logo) }}" alt="{{ $courier->name }}">
                                    @else
                                        <i class="fa fa-truck"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="ck-cn">{{ $courier->name }}</div>
                                    <div class="ck-code">{{ strtoupper($courier->code) }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="ck-desc">{{ $courier->description ?? '-' }}</span></td>
                        <td><span class="ck-badge svc"><i class="fa fa-list-alt"></i> {{ $courier->services_count }} layanan</span></td>
                        <td><span class="ck-badge {{ $courier->is_active ? 'aktif' : 'nonaktif' }}">{{ $courier->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td onclick="event.stopPropagation()">
                            <div class="ck-actions">
                                <button class="ck-btn edit" onclick="openEditModal({{ $courier->id }})">
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.couriers.toggle', $courier) }}" style="display:inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="ck-btn {{ $courier->is_active ? 'ton' : 'toff' }}">
                                        <i class="fa fa-{{ $courier->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                    </button>
                                </form>
                                <button class="ck-btn del" onclick="openDeleteModal({{ $courier->id }}, '{{ addslashes($courier->name) }}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        <td style="text-align:center">
                            <i class="fa fa-chevron-down ck-expand"></i>
                        </td>
                    </tr>

                    {{-- Services expand row --}}
                    <tr class="ck-svc-tr" id="ckSvc{{ $courier->id }}">
                        <td colspan="6" style="padding:0">
                            <div class="ck-svc-outer">
                                <div class="ck-svc-inner">
                                    <div class="ck-svc-head"><i class="fa fa-list-alt"></i> Layanan {{ $courier->name }}</div>
                                    @if($courier->services->isEmpty())
                                        <div class="ck-svc-empty"><i class="fa fa-inbox"></i> Belum ada layanan. Tambahkan di bawah.</div>
                                    @else
                                    <table class="ck-svctbl">
                                        <thead>
                                            <tr>
                                                <th>Nama Layanan</th>
                                                <th>Kode</th>
                                                <th>Estimasi</th>
                                                <th>Status</th>
                                                <th style="width:110px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($courier->services as $service)
                                            <tr>
                                                <td style="font-weight:600;color:#1e1f29">{{ $service->name }}</td>
                                                <td><span class="ck-scode">{{ $service->code }}</span></td>
                                                <td style="color:#888">{{ $service->estimated_days ? $service->estimated_days . ' hari' : '-' }}</td>
                                                <td><span class="ck-sbadge {{ $service->is_active ? 'aktif' : 'nonaktif' }}">{{ $service->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                                                <td>
                                                    <div style="display:flex;gap:5px">
                                                        <form method="POST" action="{{ route('admin.couriers.services.toggle', $service) }}" style="display:inline">
                                                            @csrf @method('PATCH')
                                                            <button type="submit" class="ck-btn {{ $service->is_active ? 'ton' : 'toff' }}">
                                                                <i class="fa fa-{{ $service->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.couriers.services.destroy', $service) }}" style="display:inline"
                                                              onsubmit="return confirm('Hapus layanan {{ addslashes($service->name) }}?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="ck-btn del"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                    <button class="ck-svc-add-btn" onclick="toggleSvcForm({{ $courier->id }})">
                                        <i class="fa fa-plus"></i> Tambah Layanan
                                    </button>
                                    <div class="ck-svc-form" id="svcForm{{ $courier->id }}">
                                        <form method="POST" action="{{ route('admin.couriers.services.store', $courier) }}">
                                            @csrf
                                            <div class="ck-sfrow">
                                                <div class="ck-sfg">
                                                    <label>Nama Layanan <span style="color:#D10024">*</span></label>
                                                    <input type="text" name="name" placeholder="Reguler, Express..." required>
                                                </div>
                                                <div class="ck-sfg">
                                                    <label>Kode <span style="color:#D10024">*</span></label>
                                                    <input type="text" name="code" placeholder="REG, YES, OKE..." required maxlength="20">
                                                </div>
                                                <div class="ck-sfg">
                                                    <label>Estimasi (hari)</label>
                                                    <input type="text" name="estimated_days" placeholder="2-3">
                                                </div>
                                            </div>
                                            <div class="ck-sfa">
                                                <button type="submit" class="ck-sfs"><i class="fa fa-check"></i> Simpan</button>
                                                <button type="button" class="ck-sfc" onclick="toggleSvcForm({{ $courier->id }})">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

    </div>

</div>{{-- /.ck-wrap --}}


{{-- ════ ADD COURIER MODAL ════ --}}
<div class="cm-overlay" id="addModal">
    <div class="cm-modal">
        <div class="cm-header">
            <span class="cm-title"><i class="fa fa-plus-circle" style="color:#D10024"></i> Tambah Kurir Baru</span>
            <button class="cm-close" onclick="closeModal('addModal')">&times;</button>
        </div>
        <div class="cm-body">
            <form method="POST" action="{{ route('admin.couriers.store') }}" enctype="multipart/form-data" id="addCourierForm">
                @csrf
                <div class="cm-field">
                    <label>Nama Kurir <span style="color:#D10024">*</span></label>
                    <input type="text" name="name" placeholder="Contoh: JNE, SiCepat, JNT..." required maxlength="100" value="{{ old('name') }}">
                </div>
                <div class="cm-field">
                    <label>Kode Kurir <span style="color:#D10024">*</span></label>
                    <input type="text" name="code" placeholder="Contoh: jne, sicepat, jnt" required maxlength="20" value="{{ old('code') }}">
                    <div class="hint">Huruf kecil, tanpa spasi (boleh tanda hubung/garis bawah)</div>
                </div>
                <div class="cm-field">
                    <label>Deskripsi</label>
                    <textarea name="description" placeholder="Deskripsi singkat kurir (opsional)..." maxlength="255">{{ old('description') }}</textarea>
                </div>
                <div class="cm-field">
                    <label>Logo Kurir <span style="color:#aaa;font-weight:400">(opsional, maks 512KB)</span></label>
                    <input type="file" name="logo" accept="image/*" onchange="previewLogo(event,'addLogoPreview')">
                    <img id="addLogoPreview" class="cm-logo-preview" src="" alt="" style="display:none;margin-top:8px">
                </div>
                <div class="cm-footer">
                    <button type="button" class="btn-cm-cancel" onclick="closeModal('addModal')">Batal</button>
                    <button type="submit" class="btn-cm-save"><i class="fa fa-check"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ════ EDIT COURIER MODALS ════ --}}
@foreach($couriers as $courier)
<div class="cm-overlay" id="editModal{{ $courier->id }}">
    <div class="cm-modal">
        <div class="cm-header">
            <span class="cm-title"><i class="fa fa-pencil" style="color:#D10024"></i> Edit Kurir</span>
            <button class="cm-close" onclick="closeModal('editModal{{ $courier->id }}')">&times;</button>
        </div>
        <div class="cm-body">
            <form method="POST" action="{{ route('admin.couriers.update', $courier) }}" enctype="multipart/form-data">
                @csrf
                <div class="cm-field">
                    <label>Nama Kurir <span style="color:#D10024">*</span></label>
                    <input type="text" name="name" value="{{ $courier->name }}" required maxlength="100">
                </div>
                <div class="cm-field">
                    <label>Kode Kurir <span style="color:#D10024">*</span></label>
                    <input type="text" name="code" value="{{ $courier->code }}" required maxlength="20">
                </div>
                <div class="cm-field">
                    <label>Deskripsi</label>
                    <textarea name="description" maxlength="255">{{ $courier->description }}</textarea>
                </div>
                <div class="cm-field">
                    <label>Logo Kurir <span style="color:#aaa;font-weight:400">(kosongkan jika tidak ingin mengubah)</span></label>
                    @if($courier->logo)
                        <div style="margin-bottom:8px">
                            <img src="{{ asset('storage/'.$courier->logo) }}" class="cm-logo-preview" alt="Logo">
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*" onchange="previewLogo(event,'editLogoPreview{{ $courier->id }}')">
                    <img id="editLogoPreview{{ $courier->id }}" class="cm-logo-preview" src="" alt="" style="display:none;margin-top:8px">
                </div>
                <div class="cm-footer">
                    <button type="button" class="btn-cm-cancel" onclick="closeModal('editModal{{ $courier->id }}')">Batal</button>
                    <button type="submit" class="btn-cm-save"><i class="fa fa-check"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- ════ DELETE CONFIRM MODAL ════ --}}
<div class="cm-overlay" id="deleteModal">
    <div class="cm-modal del-modal">
        <div class="cm-header">
            <span class="cm-title">Konfirmasi Hapus</span>
            <button class="cm-close" onclick="closeModal('deleteModal')">&times;</button>
        </div>
        <div class="cm-body">
            <div class="del-icon"><i class="fa fa-trash"></i></div>
            <div class="del-text">Hapus kurir <strong id="delCourierName"></strong>?</div>
            <div class="del-sub">Semua data layanan kurir ini juga akan dihapus. Tindakan ini tidak dapat dibatalkan.</div>
            <form method="POST" id="deleteForm" style="margin-top:20px">
                @csrf @method('DELETE')
                <div class="cm-footer">
                    <button type="button" class="btn-cm-cancel" onclick="closeModal('deleteModal')">Batal</button>
                    <button type="submit" class="btn-cm-save" style="background:#c0392b"><i class="fa fa-trash"></i> Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ── Expand / collapse courier services row ────────────────────
function toggleCourier(id) {
    var mainRow = document.getElementById('ckRow' + id);
    var svcRow  = document.getElementById('ckSvc' + id);
    var opening = !mainRow.classList.contains('ck-open');
    mainRow.classList.toggle('ck-open');
    svcRow.classList.toggle('ck-open');
    svcRow.style.display = opening ? 'table-row' : 'none';
}

// ── Add-service inline form ───────────────────────────────────
function toggleSvcForm(id) {
    var form = document.getElementById('svcForm' + id);
    form.classList.toggle('ck-open');
}

// ── Modals ────────────────────────────────────────────────────
function openAddModal()  { document.getElementById('addModal').classList.add('open'); }
function openEditModal(id) { document.getElementById('editModal' + id).classList.add('open'); }
function openDeleteModal(id, name) {
    document.getElementById('delCourierName').textContent = name;
    document.getElementById('deleteForm').action = '/admin/couriers/' + id;
    document.getElementById('deleteModal').classList.add('open');
}
function closeModal(id)  { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.cm-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); });
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') document.querySelectorAll('.cm-overlay.open').forEach(function(el) { el.classList.remove('open'); });
});

// ── Logo preview ──────────────────────────────────────────────
function previewLogo(event, previewId) {
    var preview = document.getElementById(previewId);
    var file = event.target.files[0];
    if (file) { preview.src = URL.createObjectURL(file); preview.style.display = 'block'; }
}

// ── Client-side filter ────────────────────────────────────────
var ckActiveFilter = '';
function ckSetFilter(f) {
    ckActiveFilter = f;
    ['All','Aktif','Nonaktif'].forEach(function(x) {
        document.getElementById('ckF' + x).classList.remove('active');
    });
    var map = { '': 'All', 'aktif': 'Aktif', 'nonaktif': 'Nonaktif' };
    document.getElementById('ckF' + map[f]).classList.add('active');
    ckFilter();
}
function ckFilter() {
    var q = document.getElementById('ckSearch').value.toLowerCase().trim();
    document.querySelectorAll('tr.ck-cr').forEach(function(row) {
        var id = row.id.replace('ckRow', '');
        var svcRow = document.getElementById('ckSvc' + id);
        var ok = (!q || row.dataset.search.includes(q)) && (!ckActiveFilter || row.dataset.status === ckActiveFilter);
        row.style.display = ok ? '' : 'none';
        if (svcRow) {
            if (!ok) { svcRow.style.display = 'none'; }
            else      { svcRow.style.display = svcRow.classList.contains('ck-open') ? 'table-row' : 'none'; }
        }
    });
}
</script>
@endpush

@endsection
