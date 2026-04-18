@extends('layouts.admin')

@section('title', 'Jadwal Periode Promo - Admin Panel')

@section('content')
<style>
.ps-wrap { max-width:1100px; margin:0 auto; padding:4px 0 48px; }

/* Page header */
.ps-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.ps-page-title  { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.ps-page-title i { color:#0369a1; font-size:20px; }
.ps-back-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:background .15s; font-family:inherit; }
.ps-back-btn:hover { background:#e5e7eb; color:#1e1f29; }

/* Stats */
.ps-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:600px){ .ps-stats{ grid-template-columns:repeat(2,1fr); } }
.ps-stat { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:20px; display:flex; align-items:center; gap:14px; }
.ps-si { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; }
.ps-si.blue  { background:linear-gradient(135deg,#c9e9ff,#edf6ff); color:#0369a1; }
.ps-si.green { background:linear-gradient(135deg,#c8f7d6,#edfff3); color:#1a9e50; }
.ps-si.grey  { background:linear-gradient(135deg,#e5e7eb,#f3f4f6); color:#6b7280; }
.ps-sv { font-size:26px; font-weight:800; color:#1e1f29; line-height:1; }
.ps-sl { font-size:12px; color:#8d8d8d; margin-top:3px; font-weight:500; }

/* Main card */
.ps-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }

/* Toolbar */
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

/* Alerts */
.ps-alert { display:flex; align-items:center; gap:8px; padding:12px 22px; font-size:13px; }
.ps-alert.success { background:#d1fae5; border-bottom:1px solid #6ee7b7; color:#065f46; }
.ps-alert.error   { background:#fee2e2; border-bottom:1px solid #fca5a5; color:#991b1b; }

/* Table */
.ps-table-wrap { overflow-x:auto; }
.ps-table { width:100%; border-collapse:collapse; font-size:13px; }
.ps-table th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:11px 16px; text-align:left; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.ps-table td { padding:14px 16px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.ps-row:hover td { background:#fafbfc; }

/* Time badge */
.ps-time-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:linear-gradient(135deg,#0369a1,#0284c7); color:#fff;
    padding:7px 14px; border-radius:10px; font-size:13px; font-weight:800; white-space:nowrap;
}
.ps-time-badge i { font-size:11px; opacity:.8; }
.ps-row.inactive .ps-time-badge { background:linear-gradient(135deg,#9ca3af,#d1d5db); }

/* Period name */
.ps-pname { font-size:13px; font-weight:700; color:#1e1f29; }
.ps-pdur  { font-size:11px; color:#aaa; margin-top:3px; display:flex; align-items:center; gap:4px; }

/* Badges */
.ps-badge { display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:700; padding:4px 11px; border-radius:20px; }
.ps-badge.active   { background:#d1fae5; color:#065f46; }
.ps-badge.inactive { background:#f3f4f6; color:#6b7280; }
.ps-badge i { font-size:8px; }

/* Order chip */
.ps-order { display:inline-block; background:#eff6ff; color:#1d4ed8; font-size:11px; font-weight:700; padding:3px 10px; border-radius:8px; }

/* Actions */
.ps-actions { display:flex; gap:6px; align-items:center; }
.ps-btn { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border:none; border-radius:7px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; white-space:nowrap; }
.ps-btn.edit  { background:#e3f2fd; color:#1565c0; }
.ps-btn.edit:hover  { background:#bbdefb; }
.ps-btn.ton   { background:#d1fae5; color:#065f46; }
.ps-btn.ton:hover   { background:#a7f3d0; }
.ps-btn.toff  { background:#fef3c7; color:#92400e; }
.ps-btn.toff:hover  { background:#fde68a; }
.ps-btn.del   { background:#fee2e2; color:#991b1b; }
.ps-btn.del:hover   { background:#fecaca; }

/* Empty */
.ps-empty { text-align:center; padding:64px 24px; }
.ps-empty-icon { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#c9e9ff,#edf6ff); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.ps-empty-icon i { font-size:28px; color:#0369a1; }
.ps-empty h4 { font-size:15px; font-weight:700; color:#374151; margin:0 0 6px; }
.ps-empty p  { font-size:13px; color:#9ca3af; margin:0; }

/* ==== MODAL ==== */
.ps-overlay { display:none; position:fixed; inset:0; background:rgba(10,12,20,.55); z-index:9000; justify-content:center; align-items:center; padding:20px; }
.ps-overlay.open { display:flex; }
.ps-modal { background:#fff; border-radius:18px; width:460px; max-width:100%; max-height:90vh; overflow-y:auto; box-shadow:0 24px 64px rgba(0,0,0,.28); animation:psSlideIn .22s ease; }
@keyframes psSlideIn { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
.ps-modal::-webkit-scrollbar { width:4px; }
.ps-modal::-webkit-scrollbar-thumb { background:#e5e7eb; border-radius:2px; }
.ps-mheader { padding:18px 24px 16px; background:linear-gradient(135deg,#1a1f2e 0%,#2d3347 100%); border-radius:18px 18px 0 0; display:flex; align-items:center; justify-content:space-between; }
.ps-mtitle { font-size:15px; font-weight:800; color:#fff; display:flex; align-items:center; gap:8px; }
.ps-mtitle i { color:rgba(255,255,255,.55); }
.ps-mclose { background:rgba(255,255,255,.12); border:none; font-size:18px; color:#fff; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:8px; transition:background .15s; line-height:1; }
.ps-mclose:hover { background:rgba(255,255,255,.25); }
.ps-mbody { padding:20px 24px 24px; }
.ps-mfield { margin-bottom:16px; }
.ps-mfield label { display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:7px; }
.ps-mfield input { width:100%; padding:10px 12px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; outline:none; box-sizing:border-box; transition:border .2s; }
.ps-mfield input:focus { border-color:#0369a1; box-shadow:0 0 0 3px rgba(3,105,161,.08); }
.ps-mfield .hint { font-size:11px; color:#aaa; margin-top:4px; }
.ps-mfooter { display:flex; justify-content:flex-end; gap:10px; padding-top:4px; }
.ps-time-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.ps-preview { background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 14px; margin-top:8px; font-size:13px; color:#1d4ed8; display:none; }

/* Confirm delete modal */
.ps-del-modal { width:340px; }
.ps-del-icon  { text-align:center; padding:8px 0 16px; font-size:44px; color:#ef4444; }
.ps-del-text  { text-align:center; font-size:14px; color:#333; line-height:1.6; margin-bottom:6px; }
.ps-del-sub   { text-align:center; font-size:12px; color:#aaa; }

/* Shared button classes for modal footers */
.btn-mok    { padding:10px 22px; background:#D10024; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; }
.btn-mok:hover { background:#a8001e; }
.btn-mok.blue { background:#0369a1; }
.btn-mok.blue:hover { background:#075985; }
.btn-mok.danger { background:#ef4444; }
.btn-mok.danger:hover { background:#dc2626; }
.btn-mcancel { padding:10px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; }
.btn-mcancel:hover { background:#e5e7eb; }

/* Info box */
.ps-infobox { background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:14px 16px; margin-top:20px; font-size:12px; color:#1d4ed8; display:flex; gap:10px; }
</style>

<div class="ps-wrap">

    {{-- Page Header --}}
    <div class="ps-page-header">
        <h1 class="ps-page-title"><i class="fa fa-clock-o"></i> Jadwal Periode Promo</h1>
        <a href="{{ route('admin.promos') }}" class="ps-back-btn"><i class="fa fa-arrow-left"></i> Monitor Promo</a>
    </div>

    {{-- Stats --}}
    @php
        $total    = $slots->count();
        $activeN  = $slots->where('is_active', true)->count();
        $inactiveN = $slots->where('is_active', false)->count();
    @endphp
    <div class="ps-stats">
        <div class="ps-stat">
            <div class="ps-si blue"><i class="fa fa-clock-o"></i></div>
            <div><div class="ps-sv">{{ $total }}</div><div class="ps-sl">Total Periode</div></div>
        </div>
        <div class="ps-stat">
            <div class="ps-si green"><i class="fa fa-check-circle"></i></div>
            <div><div class="ps-sv">{{ $activeN }}</div><div class="ps-sl">Aktif</div></div>
        </div>
        <div class="ps-stat">
            <div class="ps-si grey"><i class="fa fa-ban"></i></div>
            <div><div class="ps-sv">{{ $inactiveN }}</div><div class="ps-sl">Nonaktif</div></div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="ps-card">

        {{-- Toolbar --}}
        <div class="ps-toolbar">
            <div class="ps-search">
                <i class="fa fa-search"></i>
                <input type="text" id="psSearch" placeholder="Cari nama periode..." oninput="psFilter()">
            </div>
            <div class="ps-filters">
                <button type="button" onclick="psSetFilter('')"        id="psFAll"    class="ps-fbtn active">Semua</button>
                <button type="button" onclick="psSetFilter('active')"  id="psFAktif"  class="ps-fbtn"><i class="fa fa-check-circle" style="font-size:10px"></i> Aktif</button>
                <button type="button" onclick="psSetFilter('inactive')" id="psFNon"   class="ps-fbtn"><i class="fa fa-ban" style="font-size:10px"></i> Nonaktif</button>
            </div>
            <button type="button" class="ps-addbtn" onclick="openAddModal()">
                <i class="fa fa-plus"></i> Tambah Periode
            </button>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="ps-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="ps-alert error"><i class="fa fa-exclamation-triangle"></i> {{ $errors->first() }}</div>
        @endif

        {{-- Table --}}
        @if($slots->count() > 0)
        <div class="ps-table-wrap">
            <table class="ps-table">
                <thead>
                    <tr>
                        <th>Jam Periode</th>
                        <th>Nama Periode</th>
                        <th>Durasi</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="psTableBody">
                @foreach($slots as $slot)
                @php
                    $start = \Carbon\Carbon::createFromTimeString($slot->start_time);
                    $end   = \Carbon\Carbon::createFromTimeString($slot->end_time);
                    $dur   = $start->diff($end);
                    $durText = ($dur->h > 0 ? $dur->h . ' jam ' : '') . ($dur->i > 0 ? $dur->i . ' menit' : ($dur->h > 0 ? '' : '< 1 menit'));
                @endphp
                <tr class="ps-row {{ $slot->is_active ? '' : 'inactive' }}"
                    data-name="{{ strtolower($slot->name) }}"
                    data-status="{{ $slot->is_active ? 'active' : 'inactive' }}">
                    <td>
                        <div class="ps-time-badge">
                            <i class="fa fa-clock-o"></i>
                            {{ substr($slot->start_time,0,5) }} &ndash; {{ substr($slot->end_time,0,5) }}
                        </div>
                    </td>
                    <td>
                        <div class="ps-pname">{{ $slot->name }}</div>
                    </td>
                    <td>
                        <div class="ps-pdur">
                            <i class="fa fa-hourglass-half" style="color:#aaa;"></i>
                            {{ $durText }}
                        </div>
                    </td>
                    <td><span class="ps-order">{{ $slot->sort_order }}</span></td>
                    <td>
                        <span class="ps-badge {{ $slot->is_active ? 'active' : 'inactive' }}">
                            <i class="fa fa-circle"></i>
                            {{ $slot->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="ps-actions">
                            <button type="button" class="ps-btn edit"
                                    onclick="openEditModal({{ $slot->id }}, '{{ addslashes($slot->name) }}', '{{ substr($slot->start_time,0,5) }}', '{{ substr($slot->end_time,0,5) }}', {{ $slot->sort_order }})">
                                <i class="fa fa-pencil"></i> Edit
                            </button>
                            <form method="POST" action="{{ route('admin.promo-slots.toggle', $slot) }}" style="margin:0;">
                                @csrf @method('PATCH')
                                <button type="submit" class="ps-btn {{ $slot->is_active ? 'toff' : 'ton' }}">
                                    <i class="fa fa-power-off"></i>
                                    {{ $slot->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <button type="button" class="ps-btn del"
                                    onclick="openDeleteModal({{ $slot->id }}, '{{ addslashes($slot->name) }}')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="ps-empty">
            <div class="ps-empty-icon"><i class="fa fa-clock-o"></i></div>
            <h4>Belum ada periode promo</h4>
            <p>Klik tombol <strong>Tambah Periode</strong> di atas untuk membuat jadwal baru.</p>
        </div>
        @endif

    </div>{{-- /ps-card --}}

    {{-- Info box --}}
    <div class="ps-infobox">
        <i class="fa fa-info-circle" style="flex-shrink:0;margin-top:1px;font-size:15px;"></i>
        <div>
            <strong>Cara kerja periode promo:</strong>
            Daftar periode ini tersimpan sebagai referensi jadwal flash sale di platform.
            Admin dapat mengatur kapan saja promo bisa berlangsung agar lebih terstruktur.
        </div>
    </div>

</div>{{-- /ps-wrap --}}


{{-- ================================================================ --}}
{{--  MODAL: Tambah Periode                                            --}}
{{-- ================================================================ --}}
<div class="ps-overlay" id="modalAdd">
    <div class="ps-modal">
        <div class="ps-mheader">
            <span class="ps-mtitle"><i class="fa fa-clock-o"></i> Tambah Periode Promo</span>
            <button type="button" class="ps-mclose" onclick="closeModal('modalAdd')">&times;</button>
        </div>
        <div class="ps-mbody">
            <form method="POST" action="{{ route('admin.promo-slots.store') }}">
                @csrf
                <div class="ps-mfield">
                    <label>Nama Periode <span style="color:#D10024">*</span></label>
                    <input type="text" name="name" id="addName" placeholder="Contoh: Flash Sale Pagi" maxlength="100" required oninput="updateAddPreview()">
                    <div class="hint">Beri nama yang mudah dikenali penjual</div>
                </div>
                <div class="ps-mfield">
                    <label>Jam Periode <span style="color:#D10024">*</span></label>
                    <div class="ps-time-row">
                        <div>
                            <label style="font-size:11px;color:#aaa;margin-bottom:4px;display:block;">Mulai</label>
                            <input type="time" name="start_time" id="addStart" required oninput="updateAddPreview()">
                        </div>
                        <div>
                            <label style="font-size:11px;color:#aaa;margin-bottom:4px;display:block;">Selesai</label>
                            <input type="time" name="end_time" id="addEnd" required oninput="updateAddPreview()">
                        </div>
                    </div>
                    <div class="ps-preview" id="addPreview">
                        <i class="fa fa-clock-o"></i> <span id="addPreviewText"></span>
                    </div>
                </div>
                <div class="ps-mfield" style="margin-bottom:0">
                    <label>Urutan Tampil</label>
                    <input type="number" name="sort_order" id="addOrder" min="0" value="0" placeholder="0 = paling atas">
                    <div class="hint">Angka lebih kecil tampil lebih atas</div>
                </div>
                <div class="ps-mfooter" style="margin-top:20px;">
                    <button type="button" class="btn-mcancel" onclick="closeModal('modalAdd')">Batal</button>
                    <button type="submit" class="btn-mok blue"><i class="fa fa-plus"></i> Tambah Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================================ --}}
{{--  MODAL: Edit Periode                                              --}}
{{-- ================================================================ --}}
<div class="ps-overlay" id="modalEdit">
    <div class="ps-modal">
        <div class="ps-mheader">
            <span class="ps-mtitle"><i class="fa fa-pencil"></i> Edit Periode Promo</span>
            <button type="button" class="ps-mclose" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <div class="ps-mbody">
            <form method="POST" id="editForm" action="">
                @csrf @method('PUT')
                <div class="ps-mfield">
                    <label>Nama Periode <span style="color:#D10024">*</span></label>
                    <input type="text" name="name" id="editName" maxlength="100" required oninput="updateEditPreview()">
                </div>
                <div class="ps-mfield">
                    <label>Jam Periode <span style="color:#D10024">*</span></label>
                    <div class="ps-time-row">
                        <div>
                            <label style="font-size:11px;color:#aaa;margin-bottom:4px;display:block;">Mulai</label>
                            <input type="time" name="start_time" id="editStart" required oninput="updateEditPreview()">
                        </div>
                        <div>
                            <label style="font-size:11px;color:#aaa;margin-bottom:4px;display:block;">Selesai</label>
                            <input type="time" name="end_time" id="editEnd" required oninput="updateEditPreview()">
                        </div>
                    </div>
                    <div class="ps-preview" id="editPreview">
                        <i class="fa fa-clock-o"></i> <span id="editPreviewText"></span>
                    </div>
                </div>
                <div class="ps-mfield" style="margin-bottom:0">
                    <label>Urutan Tampil</label>
                    <input type="number" name="sort_order" id="editOrder" min="0">
                    <div class="hint">Angka lebih kecil tampil lebih atas</div>
                </div>
                <div class="ps-mfooter" style="margin-top:20px;">
                    <button type="button" class="btn-mcancel" onclick="closeModal('modalEdit')">Batal</button>
                    <button type="submit" class="btn-mok blue"><i class="fa fa-check"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================================ --}}
{{--  MODAL: Konfirmasi Hapus                                          --}}
{{-- ================================================================ --}}
<div class="ps-overlay" id="modalDelete">
    <div class="ps-modal ps-del-modal">
        <div class="ps-mheader">
            <span class="ps-mtitle"><i class="fa fa-trash"></i> Hapus Periode</span>
            <button type="button" class="ps-mclose" onclick="closeModal('modalDelete')">&times;</button>
        </div>
        <div class="ps-mbody">
            <div class="ps-del-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <div class="ps-del-text">Hapus periode <strong id="delName"></strong>?</div>
            <div class="ps-del-sub">Tindakan ini tidak dapat dibatalkan.</div>
            <form method="POST" id="deleteForm" action="" style="margin-top:20px;">
                @csrf @method('DELETE')
                <div class="ps-mfooter">
                    <button type="button" class="btn-mcancel" onclick="closeModal('modalDelete')">Batal</button>
                    <button type="submit" class="btn-mok danger"><i class="fa fa-trash"></i> Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ============================================================
// Modal helpers
// ============================================================
function openAddModal() {
    document.getElementById('addName').value  = '';
    document.getElementById('addStart').value = '';
    document.getElementById('addEnd').value   = '';
    document.getElementById('addOrder').value = '0';
    document.getElementById('addPreview').style.display = 'none';
    document.getElementById('modalAdd').classList.add('open');
    setTimeout(function(){ document.getElementById('addName').focus(); }, 100);
}

function openEditModal(id, name, start, end, order) {
    document.getElementById('editForm').action = '/admin/promo-slots/' + id;
    document.getElementById('editName').value  = name;
    document.getElementById('editStart').value = start;
    document.getElementById('editEnd').value   = end;
    document.getElementById('editOrder').value = order;
    updateEditPreview();
    document.getElementById('modalEdit').classList.add('open');
    setTimeout(function(){ document.getElementById('editName').focus(); }, 100);
}

function openDeleteModal(id, name) {
    document.getElementById('deleteForm').action = '/admin/promo-slots/' + id;
    document.getElementById('delName').textContent = name;
    document.getElementById('modalDelete').classList.add('open');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}

// Close on overlay click
document.querySelectorAll('.ps-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) {
        if (e.target === el) closeModal(el.id);
    });
});

// Close on Esc
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        ['modalAdd','modalEdit','modalDelete'].forEach(closeModal);
    }
});

// ============================================================
// Time preview in modal
// ============================================================
function updateAddPreview() {
    var name  = document.getElementById('addName').value.trim();
    var start = document.getElementById('addStart').value;
    var end   = document.getElementById('addEnd').value;
    var el    = document.getElementById('addPreview');
    if (start && end && start < end) {
        el.style.display = 'block';
        document.getElementById('addPreviewText').textContent =
            (name || 'Periode') + ': ' + start + ' – ' + end;
    } else {
        el.style.display = 'none';
    }
}

function updateEditPreview() {
    var name  = document.getElementById('editName').value.trim();
    var start = document.getElementById('editStart').value;
    var end   = document.getElementById('editEnd').value;
    var el    = document.getElementById('editPreview');
    if (start && end && start < end) {
        el.style.display = 'block';
        document.getElementById('editPreviewText').textContent =
            (name || 'Periode') + ': ' + start + ' – ' + end;
    } else {
        el.style.display = 'none';
    }
}

// ============================================================
// Table filter & search
// ============================================================
var psCurrentFilter = '';

function psSetFilter(filter) {
    psCurrentFilter = filter;
    document.querySelectorAll('.ps-fbtn').forEach(function(b) { b.classList.remove('active'); });
    var map = { '': 'psFAll', 'active': 'psFAktif', 'inactive': 'psFNon' };
    if (map[filter]) document.getElementById(map[filter]).classList.add('active');
    psFilter();
}

function psFilter() {
    var q = document.getElementById('psSearch').value.toLowerCase();
    var rows = document.querySelectorAll('#psTableBody .ps-row');
    var visible = 0;
    rows.forEach(function(row) {
        var nameMatch   = !q || row.dataset.name.includes(q);
        var statusMatch = !psCurrentFilter || row.dataset.status === psCurrentFilter;
        var show = nameMatch && statusMatch;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
}

// ============================================================
// Auto-open add modal if there are validation errors
// ============================================================
@if($errors->any() && !old('_method'))
document.addEventListener('DOMContentLoaded', function() { openAddModal(); });
@endif
</script>

@endsection
