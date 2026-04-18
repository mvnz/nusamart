@extends('layouts.admin')

@section('title', 'Jadwal Periode Promo - Admin Panel')

@section('content')
<style>
/* ── Wrap ──────────────────────────────────────────── */
.ps-wrap { max-width:1100px; margin:0 auto; padding:4px 0 48px; }

/* ── Page header ───────────────────────────────────── */
.ps-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.ps-page-title  { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.ps-page-title i { color:#0369a1; font-size:20px; }
.ps-back-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:background .15s; font-family:inherit; }
.ps-back-btn:hover { background:#e5e7eb; color:#1e1f29; }

/* ── Stats ─────────────────────────────────────────── */
.ps-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:600px){ .ps-stats{ grid-template-columns:repeat(2,1fr); } }
.ps-stat { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:20px; display:flex; align-items:center; gap:14px; }
.ps-si { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; }
.ps-si.blue  { background:linear-gradient(135deg,#bfdbfe,#eff6ff); color:#1d4ed8; }
.ps-si.green { background:linear-gradient(135deg,#bbf7d0,#dcfce7); color:#15803d; }
.ps-si.grey  { background:linear-gradient(135deg,#e5e7eb,#f3f4f6); color:#6b7280; }
.ps-sv { font-size:26px; font-weight:800; color:#1e1f29; line-height:1; }
.ps-sl { font-size:12px; color:#8d8d8d; margin-top:3px; font-weight:500; }

/* ── Main card ─────────────────────────────────────── */
.ps-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }

/* ── Toolbar ───────────────────────────────────────── */
.ps-toolbar { display:flex; align-items:center; gap:12px; padding:18px 22px; border-bottom:1px solid #f2f2f5; flex-wrap:wrap; }
.ps-search { display:flex; align-items:center; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden; transition:border .2s; background:#f9fafb; flex:1; min-width:180px; max-width:280px; }
.ps-search:focus-within { border-color:#0369a1; background:#fff; }
.ps-search i { padding:0 12px; color:#c0c0c0; font-size:13px; }
.ps-search input { flex:1; border:none; outline:none; padding:10px 0; font-size:13px; background:transparent; font-family:inherit; }
.ps-filters { display:flex; gap:6px; flex-wrap:wrap; }
.ps-fbtn { padding:8px 16px; border:1.5px solid #e5e7eb; border-radius:20px; background:#fff; font-size:12px; font-weight:700; color:#666; cursor:pointer; font-family:inherit; transition:all .2s; display:inline-flex; align-items:center; gap:5px; white-space:nowrap; }
.ps-fbtn:hover { border-color:#0369a1; color:#0369a1; }
.ps-fbtn.active { background:#0369a1; border-color:#0369a1; color:#fff; }
.ps-addbtn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; background:#D10024; color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .18s,transform .1s; margin-left:auto; white-space:nowrap; }
.ps-addbtn:hover { background:#a8001e; }
.ps-addbtn:active { transform:scale(.97); }

/* ── Alerts ────────────────────────────────────────── */
.ps-alert { display:flex; align-items:flex-start; gap:8px; padding:12px 22px; font-size:13px; }
.ps-alert.success { background:#d1fae5; border-bottom:1px solid #6ee7b7; color:#065f46; }
.ps-alert.error   { background:#fee2e2; border-bottom:1px solid #fca5a5; color:#991b1b; }

/* ── Table ─────────────────────────────────────────── */
.ps-tbl-wrap { overflow-x:auto; }
.ps-tbl { width:100%; border-collapse:collapse; font-size:13px; }
.ps-tbl th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:11px 16px; text-align:left; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.ps-tbl td { padding:13px 16px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.ps-tbl tr:hover td { background:#fafbfc; }

/* ── Time badge ────────────────────────────────────── */
.ps-time-badge {
    display:inline-flex; align-items:center; gap:8px;
    background:linear-gradient(135deg,#1d4ed8,#3b82f6);
    color:#fff; border-radius:10px; padding:8px 14px;
    font-size:13px; font-weight:800; letter-spacing:.3px; white-space:nowrap;
}
.ps-time-badge.inactive { background:linear-gradient(135deg,#9ca3af,#d1d5db); }
.ps-time-badge i { font-size:12px; opacity:.8; }

/* ── Duration pill ─────────────────────────────────── */
.ps-dur { display:inline-flex; align-items:center; gap:5px; background:#f0f9ff; border:1px solid #bae6fd; color:#0369a1; border-radius:20px; padding:3px 10px; font-size:11px; font-weight:700; }

/* ── Status badge ──────────────────────────────────── */
.ps-badge { display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:20px; font-size:11px; font-weight:700; }
.ps-badge.aktif    { background:#d1fae5; color:#065f46; }
.ps-badge.nonaktif { background:#f3f4f6; color:#6b7280; }

/* ── Order pill ────────────────────────────────────── */
.ps-order { display:inline-flex; align-items:center; justify-content:center; width:26px; height:26px; background:#f0f1f5; border-radius:8px; font-size:12px; font-weight:700; color:#5b21b6; }

/* ── Action buttons ────────────────────────────────── */
.ps-actions { display:flex; gap:6px; align-items:center; }
.ps-btn { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border:none; border-radius:7px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; white-space:nowrap; }
.ps-btn.edit  { background:#e0f2fe; color:#0369a1; }
.ps-btn.edit:hover  { background:#bae6fd; }
.ps-btn.ton   { background:#d1fae5; color:#065f46; }
.ps-btn.ton:hover   { background:#a7f3d0; }
.ps-btn.toff  { background:#fef3c7; color:#92400e; }
.ps-btn.toff:hover  { background:#fde68a; }
.ps-btn.del   { background:#fee2e2; color:#991b1b; }
.ps-btn.del:hover   { background:#fecaca; }

/* ── Empty state ───────────────────────────────────── */
.ps-empty { text-align:center; padding:64px 24px; }
.ps-empty-icon { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#bfdbfe,#eff6ff); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.ps-empty-icon i { font-size:28px; color:#1d4ed8; }
.ps-empty h4 { font-size:15px; font-weight:700; color:#374151; margin:0 0 6px; }
.ps-empty p  { font-size:13px; color:#9ca3af; margin:0; }

/* ── Modal overlay ─────────────────────────────────── */
.cm-overlay { display:none; position:fixed; inset:0; background:rgba(10,12,20,.55); z-index:9000; justify-content:center; align-items:center; padding:20px; }
.cm-overlay.open { display:flex; }
.cm-modal { background:#fff; border-radius:18px; width:460px; max-width:100%; max-height:90vh; overflow-y:auto; box-shadow:0 24px 64px rgba(0,0,0,.28); animation:cmIn .22s ease; }
@keyframes cmIn { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:translateY(0)} }
.cm-modal::-webkit-scrollbar { width:4px; }
.cm-modal::-webkit-scrollbar-thumb { background:#e5e7eb; border-radius:2px; }
.cm-header { padding:18px 24px 16px; background:linear-gradient(135deg,#1a1f2e 0%,#2d3347 100%); border-radius:18px 18px 0 0; display:flex; align-items:center; justify-content:space-between; }
.cm-title { font-size:15px; font-weight:800; color:#fff; display:flex; align-items:center; gap:8px; }
.cm-title i { color:rgba(255,255,255,.5); font-size:13px; }
.cm-close { background:rgba(255,255,255,.12); border:none; font-size:18px; color:#fff; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:8px; transition:background .15s; line-height:1; }
.cm-close:hover { background:rgba(255,255,255,.25); }
.cm-body { padding:20px 24px 24px; }
.cm-field { margin-bottom:16px; }
.cm-field label { display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:6px; }
.cm-field input { width:100%; padding:10px 12px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; outline:none; box-sizing:border-box; transition:border .2s; }
.cm-field input:focus { border-color:#0369a1; box-shadow:0 0 0 3px rgba(3,105,161,.08); }
.cm-field .hint { font-size:11px; color:#aaa; margin-top:4px; }
.cm-row2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.cm-footer { display:flex; justify-content:flex-end; gap:10px; margin-top:20px; }
.btn-cm-save   { padding:10px 22px; background:#D10024; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; }
.btn-cm-save:hover { background:#a8001e; }
.btn-cm-cancel { padding:10px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; }
.btn-cm-cancel:hover { background:#e5e7eb; }
.cm-del { width:360px; }
.cm-del-icon { text-align:center; padding:8px 0 16px; }
.cm-del-icon i { font-size:44px; color:#ef4444; }
.del-text { text-align:center; font-size:14px; color:#333; line-height:1.6; margin-bottom:6px; }
.del-sub  { text-align:center; font-size:12px; color:#aaa; }
</style>

<div class="ps-wrap">

    <div class="ps-page-header">
        <h1 class="ps-page-title"><i class="fa fa-clock-o"></i> Jadwal Periode Promo</h1>
        <a href="{{ route('admin.promos') }}" class="ps-back-btn"><i class="fa fa-arrow-left"></i> Monitor Promo</a>
    </div>

    {{-- Stats --}}
    @php
        $totalSlots    = $slots->count();
        $activeSlots   = $slots->where('is_active', true)->count();
        $inactiveSlots = $slots->where('is_active', false)->count();
    @endphp
    <div class="ps-stats">
        <div class="ps-stat">
            <div class="ps-si blue"><i class="fa fa-clock-o"></i></div>
            <div><div class="ps-sv">{{ $totalSlots }}</div><div class="ps-sl">Total Periode</div></div>
        </div>
        <div class="ps-stat">
            <div class="ps-si green"><i class="fa fa-check-circle"></i></div>
            <div><div class="ps-sv">{{ $activeSlots }}</div><div class="ps-sl">Aktif</div></div>
        </div>
        <div class="ps-stat">
            <div class="ps-si grey"><i class="fa fa-ban"></i></div>
            <div><div class="ps-sv">{{ $inactiveSlots }}</div><div class="ps-sl">Nonaktif</div></div>
        </div>
    </div>

    <div class="ps-card">

        {{-- Toolbar --}}
        <div class="ps-toolbar">
            <div class="ps-search">
                <i class="fa fa-search"></i>
                <input type="text" id="psSearch" placeholder="Cari nama periode..." oninput="psFilter()">
            </div>
            <div class="ps-filters">
                <button type="button" onclick="psSetFilter('')"          id="psFAll"      class="ps-fbtn active">Semua</button>
                <button type="button" onclick="psSetFilter('aktif')"     id="psFAktif"    class="ps-fbtn"><i class="fa fa-check-circle" style="font-size:10px"></i> Aktif</button>
                <button type="button" onclick="psSetFilter('nonaktif')"  id="psFNonaktif" class="ps-fbtn"><i class="fa fa-ban" style="font-size:10px"></i> Nonaktif</button>
            </div>
            <button type="button" class="ps-addbtn" onclick="openAddModal()">
                <i class="fa fa-plus"></i> Tambah Periode
            </button>
        </div>

        @if(session('success'))
            <div class="ps-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="ps-alert error">
                <i class="fa fa-exclamation-triangle" style="flex-shrink:0;margin-top:1px;"></i>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
        @endif

        <div class="ps-tbl-wrap">
            @if($slots->isEmpty())
                <div class="ps-empty">
                    <div class="ps-empty-icon"><i class="fa fa-clock-o"></i></div>
                    <h4>Belum Ada Periode Promo</h4>
                    <p>Klik <strong>Tambah Periode</strong> untuk menambahkan jadwal promo pertama.</p>
                </div>
            @else
            <table class="ps-tbl">
                <thead>
                    <tr>
                        <th style="width:36px">#</th>
                        <th>Nama Periode</th>
                        <th>Jam Promo</th>
                        <th>Durasi</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="psTbody">
                    @foreach($slots as $i => $slot)
                    @php
                        $start   = \Carbon\Carbon::createFromTimeString($slot->start_time);
                        $end     = \Carbon\Carbon::createFromTimeString($slot->end_time);
                        $diff    = $start->diff($end);
                        $durText = ($diff->h > 0 ? $diff->h . ' j ' : '') . ($diff->i > 0 ? $diff->i . ' m' : '');
                        $durText = trim($durText) ?: '0 m';
                    @endphp
                    <tr data-search="{{ strtolower($slot->name) }}" data-status="{{ $slot->is_active ? 'aktif' : 'nonaktif' }}">
                        <td style="color:#ccc;font-size:12px;font-weight:600;">{{ $i + 1 }}</td>
                        <td>
                            <div style="font-size:14px;font-weight:700;color:#1e1f29;">{{ $slot->name }}</div>
                        </td>
                        <td>
                            <span class="ps-time-badge {{ $slot->is_active ? '' : 'inactive' }}">
                                <i class="fa fa-clock-o"></i>
                                {{ substr($slot->start_time,0,5) }} – {{ substr($slot->end_time,0,5) }}
                            </span>
                        </td>
                        <td><span class="ps-dur"><i class="fa fa-hourglass-half"></i> {{ $durText }}</span></td>
                        <td><span class="ps-order">{{ $slot->sort_order }}</span></td>
                        <td>
                            <span class="ps-badge {{ $slot->is_active ? 'aktif' : 'nonaktif' }}">
                                <i class="fa fa-circle" style="font-size:7px;"></i>
                                {{ $slot->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="ps-actions">
                                <button class="ps-btn edit"
                                    onclick="openEditModal({{ $slot->id }}, '{{ addslashes($slot->name) }}', '{{ substr($slot->start_time,0,5) }}', '{{ substr($slot->end_time,0,5) }}', {{ $slot->sort_order }})">
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.promo-slots.toggle', $slot) }}" style="display:inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="ps-btn {{ $slot->is_active ? 'toff' : 'ton' }}">
                                        <i class="fa fa-power-off"></i>
                                        {{ $slot->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <button class="ps-btn del" onclick="openDeleteModal({{ $slot->id }}, '{{ addslashes($slot->name) }}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

    </div>

    {{-- Info notice --}}
    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:15px 18px;margin-top:20px;font-size:12px;color:#1e40af;display:flex;gap:10px;align-items:flex-start;">
        <i class="fa fa-info-circle" style="flex-shrink:0;margin-top:1px;font-size:15px;"></i>
        <div><strong>Cara kerja:</strong> Daftar periode ini akan menjadi pilihan jadwal cepat saat penjual membuat promo flash sale. Urutan tampil — angka terkecil tampil paling atas.</div>
    </div>

</div>{{-- /.ps-wrap --}}


{{-- ════ ADD MODAL ════ --}}
<div class="cm-overlay" id="addModal">
    <div class="cm-modal">
        <div class="cm-header">
            <span class="cm-title"><i class="fa fa-clock-o"></i> Tambah Periode Baru</span>
            <button class="cm-close" onclick="closeModal('addModal')">&times;</button>
        </div>
        <div class="cm-body">
            <form method="POST" action="{{ route('admin.promo-slots.store') }}">
                @csrf
                <div class="cm-field">
                    <label>Nama Periode <span style="color:#D10024">*</span></label>
                    <input type="text" name="name" id="addName" placeholder="Contoh: Flash Sale Pagi" required maxlength="100" value="{{ old('name') }}">
                </div>
                <div class="cm-row2">
                    <div class="cm-field">
                        <label>Jam Mulai <span style="color:#D10024">*</span></label>
                        <input type="time" name="start_time" required value="{{ old('start_time') }}">
                    </div>
                    <div class="cm-field">
                        <label>Jam Selesai <span style="color:#D10024">*</span></label>
                        <input type="time" name="end_time" required value="{{ old('end_time') }}">
                    </div>
                </div>
                <div class="cm-field">
                    <label>Urutan Tampil</label>
                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', 0) }}">
                    <div class="hint">Angka lebih kecil tampil lebih atas. Default 0.</div>
                </div>
                <div class="cm-footer">
                    <button type="button" class="btn-cm-cancel" onclick="closeModal('addModal')">Batal</button>
                    <button type="submit" class="btn-cm-save"><i class="fa fa-plus"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ════ EDIT MODAL ════ --}}
<div class="cm-overlay" id="editModal">
    <div class="cm-modal">
        <div class="cm-header">
            <span class="cm-title"><i class="fa fa-pencil"></i> Edit Periode Promo</span>
            <button class="cm-close" onclick="closeModal('editModal')">&times;</button>
        </div>
        <div class="cm-body">
            <form method="POST" id="editSlotForm">
                @csrf @method('PUT')
                <div class="cm-field">
                    <label>Nama Periode <span style="color:#D10024">*</span></label>
                    <input type="text" name="name" id="editName" required maxlength="100">
                </div>
                <div class="cm-row2">
                    <div class="cm-field">
                        <label>Jam Mulai <span style="color:#D10024">*</span></label>
                        <input type="time" name="start_time" id="editStart" required>
                    </div>
                    <div class="cm-field">
                        <label>Jam Selesai <span style="color:#D10024">*</span></label>
                        <input type="time" name="end_time" id="editEnd" required>
                    </div>
                </div>
                <div class="cm-field">
                    <label>Urutan Tampil</label>
                    <input type="number" name="sort_order" id="editOrder" min="0">
                    <div class="hint">Angka lebih kecil tampil lebih atas.</div>
                </div>
                <div class="cm-footer">
                    <button type="button" class="btn-cm-cancel" onclick="closeModal('editModal')">Batal</button>
                    <button type="submit" class="btn-cm-save"><i class="fa fa-check"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ════ DELETE MODAL ════ --}}
<div class="cm-overlay" id="deleteModal">
    <div class="cm-modal cm-del">
        <div class="cm-header">
            <span class="cm-title"><i class="fa fa-trash"></i> Hapus Periode</span>
            <button class="cm-close" onclick="closeModal('deleteModal')">&times;</button>
        </div>
        <div class="cm-body">
            <div class="cm-del-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <div class="del-text">Hapus periode <strong id="delSlotName"></strong>?</div>
            <div class="del-sub">Tindakan ini tidak dapat dibatalkan.</div>
            <form method="POST" id="deleteSlotForm" style="margin-top:20px;">
                @csrf @method('DELETE')
                <div class="cm-footer">
                    <button type="button" class="btn-cm-cancel" onclick="closeModal('deleteModal')">Batal</button>
                    <button type="submit" class="btn-cm-save" style="background:#ef4444;">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ── Modal helpers ──────────────────────────────────────
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
// Close on backdrop click
document.querySelectorAll('.cm-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) {
        if (e.target === el) closeModal(el.id);
    });
});
// Close on Esc
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') document.querySelectorAll('.cm-overlay.open').forEach(function(el){ closeModal(el.id); });
});

// ── Add ────────────────────────────────────────────────
function openAddModal() {
    openModal('addModal');
    setTimeout(function(){ document.getElementById('addName').focus(); }, 120);
}

// ── Edit ───────────────────────────────────────────────
function openEditModal(id, name, start, end, order) {
    document.getElementById('editSlotForm').action = '{{ url("admin/promo-slots") }}/' + id;
    document.getElementById('editName').value  = name;
    document.getElementById('editStart').value = start;
    document.getElementById('editEnd').value   = end;
    document.getElementById('editOrder').value = order;
    openModal('editModal');
    setTimeout(function(){ document.getElementById('editName').focus(); }, 120);
}

// ── Delete ─────────────────────────────────────────────
function openDeleteModal(id, name) {
    document.getElementById('deleteSlotForm').action = '{{ url("admin/promo-slots") }}/' + id;
    document.getElementById('delSlotName').textContent = name;
    openModal('deleteModal');
}

// ── Search & filter ────────────────────────────────────
var psCurrentFilter = '';
function psSetFilter(f) {
    psCurrentFilter = f;
    document.querySelectorAll('.ps-fbtn').forEach(function(b){ b.classList.remove('active'); });
    var map = { '': 'psFAll', 'aktif': 'psFAktif', 'nonaktif': 'psFNonaktif' };
    document.getElementById(map[f]).classList.add('active');
    psFilter();
}
function psFilter() {
    var q = document.getElementById('psSearch').value.toLowerCase();
    document.querySelectorAll('#psTbody tr').forEach(function(row) {
        var nameMatch   = !q || row.dataset.search.includes(q);
        var statusMatch = !psCurrentFilter || row.dataset.status === psCurrentFilter;
        row.style.display = (nameMatch && statusMatch) ? '' : 'none';
    });
}

// Re-open add modal after validation error
@if($errors->any() && old('name'))
document.addEventListener('DOMContentLoaded', function(){ openAddModal(); });
@endif
</script>

@endsection
