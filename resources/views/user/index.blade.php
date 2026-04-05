@extends('layouts.app')

@section('title', 'Manajemen Pengguna - NusaMart Admin')

@section('content')
<style>
/* ── Wrap ─────────────────────── */
.um-wrap { max-width:1140px; margin:0 auto; padding:28px 16px 48px; }

/* ── Page header ─────────────── */
.um-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.um-page-title { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; }
.um-page-title i { color:#D10024; font-size:20px; }
.um-back-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:background .15s; font-family:inherit; }
.um-back-btn:hover { background:#e5e7eb; color:#1e1f29; }

/* ── Stats ───────────────────── */
.um-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:700px){ .um-stats{ grid-template-columns:repeat(2,1fr); } }
.um-stat { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:20px; display:flex; align-items:center; gap:14px; }
.um-stat-icon { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; }
.um-stat-icon.red    { background:linear-gradient(135deg,#ffd6d6,#ffefef); color:#D10024; }
.um-stat-icon.green  { background:linear-gradient(135deg,#c8f7d6,#edfff3); color:#1a9e50; }
.um-stat-icon.blue   { background:linear-gradient(135deg,#c9e9ff,#edf6ff); color:#1565c0; }
.um-stat-icon.purple { background:linear-gradient(135deg,#e0d4fa,#f3eeff); color:#6d28d9; }
.um-stat-val { font-size:26px; font-weight:800; color:#1e1f29; line-height:1; }
.um-stat-lbl { font-size:12px; color:#8d8d8d; margin-top:3px; font-weight:500; }

/* ── Main card ───────────────── */
.um-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }

/* ── Toolbar ─────────────────── */
.um-toolbar { display:flex; align-items:center; gap:12px; padding:18px 22px; border-bottom:1px solid #f2f2f5; flex-wrap:wrap; }
.um-search { display:flex; align-items:center; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden; transition:border .2s; flex:1; min-width:180px; max-width:300px; background:#f9fafb; }
.um-search:focus-within { border-color:#D10024; background:#fff; }
.um-search i { padding:0 12px; color:#bbb; font-size:13px; }
.um-search input { flex:1; border:none; outline:none; padding:10px 0; font-size:13px; background:transparent; font-family:inherit; }
.um-filters { display:flex; gap:6px; flex-wrap:wrap; }
.um-filter-btn { padding:8px 16px; border:1.5px solid #e5e7eb; border-radius:20px; background:#fff; font-size:12px; font-weight:700; color:#666; cursor:pointer; font-family:inherit; transition:all .2s; display:flex; align-items:center; gap:5px; white-space:nowrap; }
.um-filter-btn:hover { border-color:#D10024; color:#D10024; }
.um-filter-btn.active { background:#D10024; border-color:#D10024; color:#fff; }
.um-search-count { font-size:12px; color:#aaa; margin-left:auto; white-space:nowrap; }

/* ── Alert ───────────────────── */
.um-alert { margin:12px 22px 0; padding:11px 16px; border-radius:9px; font-size:13px; display:flex; align-items:center; gap:8px; }
.um-alert.success { background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; }
.um-alert.error   { background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; }

/* ── Table ───────────────────── */
.um-table-wrap { overflow-x:auto; }
.um-table { width:100%; border-collapse:collapse; font-size:13px; }
.um-table th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:12px 16px; text-align:left; border-bottom:1px solid #f0f0f0; white-space:nowrap; cursor:pointer; user-select:none; }
.um-table th:hover { background:#f1f2f7; color:#D10024; }
.um-table th:last-child { cursor:default; }
.um-table th:last-child:hover { background:#f8f9fb; color:#8d8d8d; }
.um-table th .si { font-size:10px; color:#ccc; margin-left:4px; display:inline-block; vertical-align:middle; transition:color .15s; }
.um-table th:hover .si { color:#D10024; }
.um-table th .si.asc, .um-table th .si.desc { color:#D10024; }
.um-table td { padding:14px 16px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.um-table tbody tr:last-child td { border-bottom:none; }
.um-table tbody tr:hover td { background:#fafbfc; }

/* ── User cell ───────────────── */
.um-user-cell { display:flex; align-items:center; gap:11px; }
.um-avatar { width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; flex-shrink:0; color:#fff; }
.um-avatar.c0 { background:linear-gradient(135deg,#fc5c65,#fd9644); }
.um-avatar.c1 { background:linear-gradient(135deg,#a55eea,#7950f2); }
.um-avatar.c2 { background:linear-gradient(135deg,#20bf6b,#0fb9b1); }
.um-avatar.c3 { background:linear-gradient(135deg,#2d98da,#4b7bec); }
.um-avatar.c4 { background:linear-gradient(135deg,#f7b731,#fa8231); }
.um-avatar.photo { padding:0; overflow:hidden; }
.um-avatar.photo img { width:100%; height:100%; object-fit:cover; }
.um-user-name { font-size:13px; font-weight:700; color:#1e1f29; }
.um-user-uname { font-size:11px; color:#aaa; margin-top:1px; }

/* ── Badges ──────────────────── */
.um-badge { display:inline-block; padding:3px 11px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; }
.um-badge.pembeli  { background:#dcfce7; color:#166534; }
.um-badge.penjual  { background:#dbeafe; color:#1e40af; }
.um-badge.admin    { background:#fce7f3; color:#9d174d; }
.um-badge.aktif    { background:#d1fae5; color:#065f46; }
.um-badge.nonaktif { background:#fee2e2; color:#991b1b; }

/* ── Action buttons ──────────── */
.um-actions { display:flex; gap:6px; align-items:center; }
.um-btn { display:inline-flex; align-items:center; gap:5px; padding:6px 13px; border:none; border-radius:7px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s, transform .1s; white-space:nowrap; }
.um-btn:active { transform:scale(.97); }
.um-btn.detail     { background:#e3f2fd; color:#1565c0; }
.um-btn.detail:hover { background:#bbdefb; }
.um-btn.deactivate { background:#fee2e2; color:#991b1b; }
.um-btn.deactivate:hover { background:#fecaca; }
.um-btn.activate   { background:#dcfce7; color:#166534; }
.um-btn.activate:hover { background:#bbf7d0; }

/* ── Pagination ──────────────── */
.um-pagination { display:flex; align-items:center; justify-content:space-between; padding:14px 22px; border-top:1px solid #f2f2f5; flex-wrap:wrap; gap:8px; }
.um-pg-info { font-size:12px; color:#aaa; }
.um-pg-btns { display:flex; gap:4px; align-items:center; flex-wrap:wrap; }
.um-pg-btn { padding:5px 12px; border-radius:7px; font-size:12px; cursor:pointer; border:1.5px solid #e5e7eb; background:#fff; color:#444; font-weight:500; transition:all .15s; }
.um-pg-btn:hover { border-color:#D10024; color:#D10024; }
.um-pg-btn.active { background:#D10024; border-color:#D10024; color:#fff; font-weight:700; }
.um-pg-btn:disabled { color:#ccc; border-color:#eee; cursor:default; background:#fafafa; }
.um-pg-dots { padding:5px 4px; font-size:13px; color:#aaa; }

/* ── Modal ───────────────────── */
.um-modal-overlay { display:none; position:fixed; inset:0; background:rgba(15,15,20,.55); z-index:9999; justify-content:center; align-items:center; padding:20px; }
.um-modal-overlay.active { display:flex; }
.um-modal { background:#fff; border-radius:18px; width:440px; max-width:100%; max-height:90vh; overflow-y:auto; box-shadow:0 24px 64px rgba(0,0,0,.25); animation:umSlide .22s ease; }
@keyframes umSlide { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
.um-modal::-webkit-scrollbar { width:4px; }
.um-modal::-webkit-scrollbar-thumb { background:#e5e7eb; border-radius:2px; }
.um-modal-top { position:relative; padding:28px 24px 20px; text-align:center; background:linear-gradient(160deg,#1a1f2e 0%,#2d3347 100%); border-radius:18px 18px 0 0; }
.um-modal-close { position:absolute; top:14px; right:16px; background:rgba(255,255,255,.12); border:none; width:30px; height:30px; border-radius:8px; font-size:18px; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .15s; }
.um-modal-close:hover { background:rgba(255,255,255,.25); }
.um-modal-av { width:78px; height:78px; border-radius:50%; margin:0 auto 12px; border:3px solid rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:800; color:#fff; overflow:hidden; }
.um-modal-av img { width:100%; height:100%; object-fit:cover; }
.um-modal-name { font-size:17px; font-weight:800; color:#fff; margin-bottom:3px; }
.um-modal-uname { font-size:12px; color:rgba(255,255,255,.5); margin-bottom:10px; }
.um-modal-badges { display:flex; justify-content:center; gap:7px; flex-wrap:wrap; }
.um-modal-body { padding:20px 24px 26px; }
.um-modal-section { margin-bottom:18px; }
.um-modal-section-title { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#aaa; margin-bottom:8px; display:flex; align-items:center; gap:6px; }
.um-modal-section-title i { color:#D10024; font-size:12px; }
.um-modal-row { display:flex; justify-content:space-between; align-items:flex-start; padding:8px 0; border-bottom:1px solid #f5f5f7; font-size:13px; }
.um-modal-row:last-child { border-bottom:none; }
.um-modal-label { color:#8d8d8d; font-weight:500; flex-shrink:0; min-width:110px; }
.um-modal-val { color:#1e1f29; font-weight:600; text-align:right; word-break:break-word; max-width:60%; }
</style>

<div class="um-wrap">

    <div class="um-page-header">
        <h1 class="um-page-title"><i class="fa fa-users"></i> Manajemen Pengguna</h1>
        <a href="{{ route('dashboard') }}" class="um-back-btn"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="um-stats">
        <div class="um-stat">
            <div class="um-stat-icon red"><i class="fa fa-users"></i></div>
            <div><div class="um-stat-val">{{ $totalUsers }}</div><div class="um-stat-lbl">Total Pengguna</div></div>
        </div>
        <div class="um-stat">
            <div class="um-stat-icon green"><i class="fa fa-shopping-bag"></i></div>
            <div><div class="um-stat-val">{{ $totalBuyers }}</div><div class="um-stat-lbl">Pembeli</div></div>
        </div>
        <div class="um-stat">
            <div class="um-stat-icon blue"><i class="fa fa-building-o"></i></div>
            <div><div class="um-stat-val">{{ $totalSellers }}</div><div class="um-stat-lbl">Penjual</div></div>
        </div>
        <div class="um-stat">
            <div class="um-stat-icon purple"><i class="fa fa-shield"></i></div>
            <div><div class="um-stat-val">{{ $totalAdmins }}</div><div class="um-stat-lbl">Admin</div></div>
        </div>
    </div>

    <div class="um-card">

        <div class="um-toolbar">
            <div class="um-search">
                <i class="fa fa-search"></i>
                <input type="text" id="userSearch" placeholder="Cari nama atau username..." oninput="applyFilters()">
            </div>
            <div class="um-filters">
                <button type="button" onclick="setRole('')"        id="filterAll"     class="um-filter-btn active">Semua</button>
                <button type="button" onclick="setRole('pembeli')" id="filterPembeli" class="um-filter-btn"><i class="fa fa-shopping-bag" style="font-size:10px"></i> Pembeli</button>
                <button type="button" onclick="setRole('penjual')" id="filterPenjual" class="um-filter-btn"><i class="fa fa-building-o"  style="font-size:10px"></i> Penjual</button>
                <button type="button" onclick="setRole('admin')"   id="filterAdmin"   class="um-filter-btn"><i class="fa fa-shield"      style="font-size:10px"></i> Admin</button>
            </div>
            <span class="um-search-count" id="userSearchCount"></span>
        </div>

        @if(session('success'))
            <div class="um-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="um-alert error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        <div class="um-table-wrap">
            <table class="um-table">
                <thead>
                    <tr>
                        <th onclick="sortTable('name')">Pengguna <span class="si" id="sort-name">&#x21C5;</span></th>
                        <th onclick="sortTable('email')">Email <span class="si" id="sort-email">&#x21C5;</span></th>
                        <th onclick="sortTable('phone')">Telepon <span class="si" id="sort-phone">&#x21C5;</span></th>
                        <th onclick="sortTable('role')">Role <span class="si" id="sort-role">&#x21C5;</span></th>
                        <th onclick="sortTable('status')">Status <span class="si" id="sort-status">&#x21C5;</span></th>
                        <th onclick="sortTable('date')">Terdaftar <span class="si" id="sort-date">&#x21C5;</span></th>
                        <th style="cursor:default">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr data-search="{{ strtolower($user->name . ' ' . $user->username) }}"
                        data-role="{{ $user->role }}"
                        data-sort-name="{{ strtolower($user->name) }}"
                        data-sort-email="{{ strtolower($user->email) }}"
                        data-sort-phone="{{ strtolower($user->phone ?? '') }}"
                        data-sort-role="{{ $user->role }}"
                        data-sort-status="{{ $user->is_active ? '1' : '0' }}"
                        data-sort-date="{{ $user->created_at->format('YmdHis') }}">
                        <td>
                            <div class="um-user-cell">
                                @if($user->photo)
                                    <div class="um-avatar photo">
                                        <img src="{{ asset('uploads/'.$user->photo) }}" alt="{{ $user->name }}">
                                    </div>
                                @else
                                    <div class="um-avatar c{{ $index % 5 }}">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                @endif
                                <div>
                                    <div class="um-user-name">{{ $user->name }}</div>
                                    <div class="um-user-uname">{{ '@' . $user->username }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color:#555;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $user->email }}">{{ $user->email }}</td>
                        <td style="color:#555">{{ $user->phone ?? '-' }}</td>
                        <td><span class="um-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                        <td><span class="um-badge {{ $user->is_active ? 'aktif' : 'nonaktif' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td style="color:#888;font-size:12px">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="um-actions">
                                <button type="button" class="um-btn detail" onclick="openUserModal({{ $user->id }})">
                                    <i class="fa fa-eye"></i> Detail
                                </button>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST"
                                          onsubmit="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} pengguna {{ addslashes($user->name) }}?')">
                                        @csrf @method('PATCH')
                                        @if($user->is_active)
                                            <button type="submit" class="um-btn deactivate"><i class="fa fa-ban"></i> Nonaktifkan</button>
                                        @else
                                            <button type="submit" class="um-btn activate"><i class="fa fa-check"></i> Aktifkan</button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="um-pagination" id="paginationBar" style="display:none">
            <span class="um-pg-info" id="paginationInfo"></span>
            <div class="um-pg-btns" id="paginationBtns"></div>
        </div>

    </div>
</div>

{{-- MODAL --}}
<div class="um-modal-overlay" id="userModal" onclick="if(event.target===this)closeUserModal()">
    <div class="um-modal">
        <div class="um-modal-top">
            <button class="um-modal-close" onclick="closeUserModal()">&times;</button>
            <div class="um-modal-av" id="modalAvatar"></div>
            <div class="um-modal-name" id="modalName"></div>
            <div class="um-modal-uname" id="modalUsername"></div>
            <div class="um-modal-badges" id="modalBadges"></div>
        </div>
        <div class="um-modal-body">
            <div class="um-modal-section">
                <div class="um-modal-section-title"><i class="fa fa-id-card-o"></i> Informasi Akun</div>
                <div class="um-modal-row"><span class="um-modal-label">Email</span><span class="um-modal-val" id="modalEmail"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">Telepon</span><span class="um-modal-val" id="modalPhone"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">Tanggal Lahir</span><span class="um-modal-val" id="modalTanggalLahir"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">Jenis Kelamin</span><span class="um-modal-val" id="modalJenisKelamin"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">Terdaftar</span><span class="um-modal-val" id="modalDate"></span></div>
            </div>
            <div class="um-modal-section">
                <div class="um-modal-section-title"><i class="fa fa-map-marker"></i> Alamat</div>
                <div class="um-modal-row"><span class="um-modal-label">Provinsi</span><span class="um-modal-val" id="modalPropinsi"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">Kota / Kab</span><span class="um-modal-val" id="modalKota"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">Kecamatan</span><span class="um-modal-val" id="modalKecamatan"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">Kelurahan</span><span class="um-modal-val" id="modalKelurahan"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">RT / RW</span><span class="um-modal-val" id="modalRtRw"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">Alamat Lengkap</span><span class="um-modal-val" id="modalAlamat"></span></div>
                <div class="um-modal-row"><span class="um-modal-label">Kode Pos</span><span class="um-modal-val" id="modalKodepos"></span></div>
            </div>
        </div>
    </div>
</div>

@php
    $usersJson = $users->mapWithKeys(function($u, $i) {
        return [$u->id => [
            'id'        => $u->id,
            'name'      => $u->name,
            'username'  => $u->username,
            'email'     => $u->email,
            'phone'     => $u->phone ?? '-',
            'tanggal_lahir' => $u->tanggal_lahir ? \Carbon\Carbon::parse($u->tanggal_lahir)->format('d M Y') : '-',
            'jenis_kelamin' => $u->jenis_kelamin ? ucfirst($u->jenis_kelamin) : '-',
            'role'      => ucfirst($u->role),
            'is_active' => $u->is_active,
            'alamat'    => $u->alamat ?? '-',
            'kota'      => $u->kota ?? '-',
            'propinsi'  => $u->propinsi ?? '-',
            'kecamatan' => $u->kecamatan ?? '-',
            'kelurahan' => $u->kelurahan ?? '-',
            'rt'        => $u->rt ?? '-',
            'rw'        => $u->rw ?? '-',
            'kodepos'   => $u->kodepos ?? '-',
            'photo'     => $u->photo ? asset('uploads/' . $u->photo) : null,
            'color'     => $i % 5,
            'date'      => $u->created_at->format('d M Y'),
        ]];
    });
@endphp

@push('scripts')
<script>
var usersData = {!! $usersJson->toJson() !!};
var COLORS = [
    'linear-gradient(135deg,#fc5c65,#fd9644)',
    'linear-gradient(135deg,#a55eea,#7950f2)',
    'linear-gradient(135deg,#20bf6b,#0fb9b1)',
    'linear-gradient(135deg,#2d98da,#4b7bec)',
    'linear-gradient(135deg,#f7b731,#fa8231)'
];

function openUserModal(id) {
    var u = usersData[id];
    if (!u) return;
    var av = document.getElementById('modalAvatar');
    if (u.photo) {
        av.innerHTML = '<img src="' + u.photo + '" alt="">';
        av.style.background = '#333';
    } else {
        av.innerHTML = u.name.charAt(0).toUpperCase();
        av.style.background = COLORS[u.color] || COLORS[0];
    }
    document.getElementById('modalName').textContent     = u.name;
    document.getElementById('modalUsername').textContent = '@' + u.username;
    var roleCls = u.role.toLowerCase();
    document.getElementById('modalBadges').innerHTML =
        '<span class="um-badge ' + roleCls + '">' + u.role + '</span>' +
        '<span class="um-badge ' + (u.is_active ? 'aktif' : 'nonaktif') + '">' + (u.is_active ? 'Aktif' : 'Nonaktif') + '</span>';
    document.getElementById('modalEmail').textContent         = u.email;
    document.getElementById('modalPhone').textContent         = u.phone;
    document.getElementById('modalTanggalLahir').textContent  = u.tanggal_lahir;
    document.getElementById('modalJenisKelamin').textContent  = u.jenis_kelamin;
    document.getElementById('modalDate').textContent          = u.date;
    document.getElementById('modalPropinsi').textContent  = u.propinsi;
    document.getElementById('modalKota').textContent      = u.kota;
    document.getElementById('modalKecamatan').textContent = u.kecamatan;
    document.getElementById('modalKelurahan').textContent = u.kelurahan;
    document.getElementById('modalRtRw').textContent      = 'RT ' + u.rt + ' / RW ' + u.rw;
    document.getElementById('modalAlamat').textContent    = u.alamat;
    document.getElementById('modalKodepos').textContent   = u.kodepos;
    var overlay = document.getElementById('userModal');
    overlay.style.display = 'flex';
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeUserModal() {
    var overlay = document.getElementById('userModal');
    overlay.classList.remove('active');
    overlay.style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeUserModal(); });

var activeRole  = '';
var PAGE_SIZE   = 10;
var currentPage = 1;

function setRole(role) {
    activeRole = role;
    ['All','Pembeli','Penjual','Admin'].forEach(function(r) {
        document.getElementById('filter' + r).classList.remove('active');
    });
    var map = {'':'All','pembeli':'Pembeli','penjual':'Penjual','admin':'Admin'};
    document.getElementById('filter' + map[role]).classList.add('active');
    currentPage = 1;
    applyFilters();
}

function applyFilters() {
    var q    = document.getElementById('userSearch').value.toLowerCase().trim();
    var rows = Array.from(document.querySelectorAll('.um-table tbody tr[data-search]'));
    var matched = rows.filter(function(r) {
        return (!q || r.dataset.search.includes(q)) && (!activeRole || r.dataset.role === activeRole);
    });
    rows.forEach(function(r) { r.style.display = 'none'; });
    var total    = matched.length;
    var lastPage = Math.max(1, Math.ceil(total / PAGE_SIZE));
    if (currentPage > lastPage) currentPage = lastPage;
    var start = (currentPage - 1) * PAGE_SIZE;
    matched.slice(start, start + PAGE_SIZE).forEach(function(r) { r.style.display = ''; });
    document.getElementById('userSearchCount').textContent =
        (q || activeRole) ? (total + ' dari ' + rows.length + ' pengguna') : '';
    renderPagination(total, lastPage);
}

function renderPagination(total, lastPage) {
    var bar  = document.getElementById('paginationBar');
    var info = document.getElementById('paginationInfo');
    var btns = document.getElementById('paginationBtns');
    if (total === 0 || lastPage <= 1) { bar.style.display = 'none'; return; }
    bar.style.display = 'flex';
    var start = (currentPage - 1) * PAGE_SIZE + 1;
    var end   = Math.min(currentPage * PAGE_SIZE, total);
    info.textContent = 'Menampilkan ' + start + '\u2013' + end + ' dari ' + total + ' pengguna';
    btns.innerHTML = '';
    function addBtn(label, page, active, disabled) {
        var b = document.createElement('button');
        b.innerHTML = label;
        b.className = 'um-pg-btn' + (active ? ' active' : '');
        if (disabled) { b.disabled = true; }
        else if (!active) { b.onclick = function() { currentPage = page; applyFilters(); }; }
        btns.appendChild(b);
    }
    addBtn('&#8249;', currentPage - 1, false, currentPage === 1);
    for (var p = 1; p <= lastPage; p++) {
        if (p === 1 || p === lastPage || Math.abs(p - currentPage) <= 1) {
            addBtn(p, p, p === currentPage, false);
        } else if (p === currentPage - 2 || p === currentPage + 2) {
            var d = document.createElement('span'); d.className = 'um-pg-dots'; d.textContent = '\u2026';
            btns.appendChild(d);
        }
    }
    addBtn('&#8250;', currentPage + 1, false, currentPage === lastPage);
}

var sortState = { col: null, dir: 'asc' };
function sortTable(col) {
    if (sortState.col === col) { sortState.dir = sortState.dir === 'asc' ? 'desc' : 'asc'; }
    else { sortState.col = col; sortState.dir = 'asc'; }
    document.querySelectorAll('.um-table th .si').forEach(function(el) { el.innerHTML = '&#x21C5;'; el.className = 'si'; });
    var icon = document.getElementById('sort-' + col);
    if (icon) { icon.innerHTML = sortState.dir === 'asc' ? '&#x2191;' : '&#x2193;'; icon.className = 'si ' + sortState.dir; }
    var tbody = document.querySelector('.um-table tbody');
    var rows  = Array.from(tbody.querySelectorAll('tr'));
    var key   = 'sort' + col.charAt(0).toUpperCase() + col.slice(1);
    rows.sort(function(a, b) {
        var av = (a.dataset[key] || '').toLowerCase();
        var bv = (b.dataset[key] || '').toLowerCase();
        return av < bv ? (sortState.dir === 'asc' ? -1 : 1) : av > bv ? (sortState.dir === 'asc' ? 1 : -1) : 0;
    });
    rows.forEach(function(r) { tbody.appendChild(r); });
    currentPage = 1;
    applyFilters();
}

applyFilters();
</script>
@endpush

@endsection
