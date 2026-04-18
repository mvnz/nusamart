@extends('layouts.admin')

@section('title', 'Voucher - Admin Panel')

@section('content')
<style>
.vc-wrap { max-width:1100px; margin:0 auto; padding:4px 0 48px; }

/* Page header */
.vc-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.vc-page-title  { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.vc-page-title i { color:#7c3aed; font-size:20px; }

/* Stats */
.vc-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:700px){ .vc-stats{ grid-template-columns:repeat(2,1fr); } }
.vc-stat { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:20px; display:flex; align-items:center; gap:14px; }
.vc-si { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; }
.vc-si.purple { background:linear-gradient(135deg,#ddd6fe,#ede9fe); color:#7c3aed; }
.vc-si.green  { background:linear-gradient(135deg,#c8f7d6,#edfff3); color:#1a9e50; }
.vc-si.yellow { background:linear-gradient(135deg,#fef3c7,#fffbeb); color:#d97706; }
.vc-si.grey   { background:linear-gradient(135deg,#e5e7eb,#f3f4f6); color:#6b7280; }
.vc-sv { font-size:26px; font-weight:800; color:#1e1f29; line-height:1; }
.vc-sl { font-size:12px; color:#8d8d8d; margin-top:3px; font-weight:500; }

/* Main card */
.vc-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }

/* Toolbar */
.vc-toolbar { display:flex; align-items:center; gap:12px; padding:18px 22px; border-bottom:1px solid #f2f2f5; flex-wrap:wrap; }
.vc-search { display:flex; align-items:center; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden; transition:border .2s; background:#f9fafb; flex:1; min-width:180px; max-width:280px; }
.vc-search:focus-within { border-color:#7c3aed; background:#fff; }
.vc-search i { padding:0 12px; color:#c0c0c0; font-size:13px; }
.vc-search input { flex:1; border:none; outline:none; padding:10px 0; font-size:13px; background:transparent; font-family:inherit; }
.vc-filters { display:flex; gap:6px; flex-wrap:wrap; }
.vc-fbtn { padding:8px 16px; border:1.5px solid #e5e7eb; border-radius:20px; background:#fff; font-size:12px; font-weight:700; color:#666; cursor:pointer; font-family:inherit; transition:all .2s; display:inline-flex; align-items:center; gap:5px; white-space:nowrap; }
.vc-fbtn:hover { border-color:#7c3aed; color:#7c3aed; }
.vc-fbtn.active { background:#7c3aed; border-color:#7c3aed; color:#fff; }
.vc-addbtn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; background:#D10024; color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .18s,transform .1s; margin-left:auto; white-space:nowrap; }
.vc-addbtn:hover { background:#a8001e; }
.vc-addbtn:active { transform:scale(.97); }

/* Alert */
.vc-alert { display:flex; align-items:center; gap:8px; padding:12px 22px; font-size:13px; }
.vc-alert.success { background:#d1fae5; border-bottom:1px solid #6ee7b7; color:#065f46; }
.vc-alert.error   { background:#fee2e2; border-bottom:1px solid #fca5a5; color:#991b1b; }

/* Table */
.vc-table-wrap { overflow-x:auto; }
.vc-table { width:100%; border-collapse:collapse; font-size:13px; }
.vc-table th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:11px 16px; text-align:left; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.vc-table td { padding:13px 16px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.vc-row:hover td { background:#fafbfc; }

/* Code chip */
.vc-code { display:inline-block; background:#ede9fe; color:#5b21b6; font-size:12px; font-weight:800; padding:5px 12px; border-radius:8px; letter-spacing:1px; font-family:monospace; }

/* Discount badge */
.vc-disc { display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:800; }
.vc-disc.pct  { color:#D10024; }
.vc-disc.fixed { color:#0369a1; }
.vc-disc-badge { padding:3px 9px; border-radius:6px; font-size:12px; font-weight:700; }
.vc-disc-badge.pct   { background:#fff0f0; color:#D10024; }
.vc-disc-badge.fixed { background:#eff6ff; color:#0369a1; }

/* Progress bar for quota */
.vc-quota-wrap { min-width:100px; }
.vc-quota-bar { height:5px; background:#f0f0f0; border-radius:3px; margin-top:5px; overflow:hidden; }
.vc-quota-fill { height:100%; border-radius:3px; background:linear-gradient(90deg,#7c3aed,#a78bfa); transition:width .3s; }

/* Status badge */
.vc-badge { display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:700; padding:4px 11px; border-radius:20px; white-space:nowrap; }
.vc-badge i { font-size:8px; }
.vc-badge.active    { background:#d1fae5; color:#065f46; }
.vc-badge.scheduled { background:#fef3c7; color:#92400e; }
.vc-badge.expired   { background:#f3f4f6; color:#6b7280; }
.vc-badge.inactive  { background:#fee2e2; color:#991b1b; }
.vc-badge.quota_full { background:#ede9fe; color:#5b21b6; }

/* Actions */
.vc-actions { display:flex; gap:6px; align-items:center; }
.vc-btn { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border:none; border-radius:7px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; white-space:nowrap; }
.vc-btn.edit  { background:#e3f2fd; color:#1565c0; }
.vc-btn.edit:hover  { background:#bbdefb; }
.vc-btn.ton   { background:#d1fae5; color:#065f46; }
.vc-btn.ton:hover   { background:#a7f3d0; }
.vc-btn.toff  { background:#fef3c7; color:#92400e; }
.vc-btn.toff:hover  { background:#fde68a; }
.vc-btn.del   { background:#fee2e2; color:#991b1b; }
.vc-btn.del:hover   { background:#fecaca; }

/* Empty */
.vc-empty { text-align:center; padding:64px 24px; }
.vc-empty-icon { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#ddd6fe,#ede9fe); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.vc-empty-icon i { font-size:28px; color:#7c3aed; }
.vc-empty h4 { font-size:15px; font-weight:700; color:#374151; margin:0 0 6px; }
.vc-empty p  { font-size:13px; color:#9ca3af; margin:0; }

/* ==== MODAL ==== */
.vc-overlay { display:none; position:fixed; inset:0; background:rgba(10,12,20,.55); z-index:9000; justify-content:center; align-items:center; padding:20px; }
.vc-overlay.open { display:flex; }
.vc-modal { background:#fff; border-radius:18px; width:520px; max-width:100%; max-height:90vh; overflow-y:auto; box-shadow:0 24px 64px rgba(0,0,0,.28); animation:vcSlideIn .22s ease; }
@keyframes vcSlideIn { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
.vc-modal::-webkit-scrollbar { width:4px; }
.vc-modal::-webkit-scrollbar-thumb { background:#e5e7eb; border-radius:2px; }
.vc-mheader { padding:18px 24px 16px; background:linear-gradient(135deg,#1a1f2e 0%,#2d3347 100%); border-radius:18px 18px 0 0; display:flex; align-items:center; justify-content:space-between; }
.vc-mtitle { font-size:15px; font-weight:800; color:#fff; display:flex; align-items:center; gap:8px; }
.vc-mtitle i { color:rgba(255,255,255,.55); }
.vc-mclose { background:rgba(255,255,255,.12); border:none; font-size:18px; color:#fff; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:8px; transition:background .15s; line-height:1; }
.vc-mclose:hover { background:rgba(255,255,255,.25); }
.vc-mbody { padding:20px 24px 24px; }
.vc-mfield { margin-bottom:16px; }
.vc-mfield label { display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:7px; }
.vc-mfield input, .vc-mfield select, .vc-mfield textarea { width:100%; padding:10px 12px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; outline:none; box-sizing:border-box; transition:border .2s; }
.vc-mfield input:focus, .vc-mfield select:focus, .vc-mfield textarea:focus { border-color:#7c3aed; box-shadow:0 0 0 3px rgba(124,58,237,.08); }
.vc-mfield textarea { resize:vertical; min-height:72px; }
.vc-mfield .hint { font-size:11px; color:#aaa; margin-top:4px; }
.vc-mfooter { display:flex; justify-content:flex-end; gap:10px; padding-top:4px; }
.vc-two-col { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.vc-three-col { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; }
.vc-disc-preview { background:#f5f3ff; border:1.5px solid #ddd6fe; border-radius:8px; padding:10px 14px; font-size:12px; color:#5b21b6; margin-top:8px; display:none; }
.vc-sec-label { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.6px; color:#aaa; margin-bottom:12px; margin-top:4px; padding-bottom:6px; border-bottom:1px solid #f0f0f0; }

/* Confirm delete */
.vc-del-modal { width:340px; }
.vc-del-icon  { text-align:center; padding:8px 0 16px; font-size:44px; color:#ef4444; }
.vc-del-text  { text-align:center; font-size:14px; color:#333; line-height:1.6; margin-bottom:6px; }
.vc-del-sub   { text-align:center; font-size:12px; color:#aaa; }

/* Shared modal buttons */
.btn-mok    { padding:10px 22px; background:#D10024; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; }
.btn-mok:hover { background:#a8001e; }
.btn-mok.purple { background:#7c3aed; }
.btn-mok.purple:hover { background:#6d28d9; }
.btn-mok.danger { background:#ef4444; }
.btn-mok.danger:hover { background:#dc2626; }
.btn-mcancel { padding:10px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; }
.btn-mcancel:hover { background:#e5e7eb; }
</style>

<div class="vc-wrap">

    <div class="vc-page-header">
        <h1 class="vc-page-title"><i class="fa fa-ticket"></i> Voucher</h1>
    </div>

    {{-- Stats --}}
    <div class="vc-stats">
        <div class="vc-stat">
            <div class="vc-si purple"><i class="fa fa-ticket"></i></div>
            <div><div class="vc-sv">{{ $stats['total'] }}</div><div class="vc-sl">Total Voucher</div></div>
        </div>
        <div class="vc-stat">
            <div class="vc-si green"><i class="fa fa-check-circle"></i></div>
            <div><div class="vc-sv">{{ $stats['active'] }}</div><div class="vc-sl">Aktif</div></div>
        </div>
        <div class="vc-stat">
            <div class="vc-si yellow"><i class="fa fa-clock-o"></i></div>
            <div><div class="vc-sv">{{ $stats['scheduled'] }}</div><div class="vc-sl">Terjadwal</div></div>
        </div>
        <div class="vc-stat">
            <div class="vc-si grey"><i class="fa fa-calendar-times-o"></i></div>
            <div><div class="vc-sv">{{ $stats['expired'] }}</div><div class="vc-sl">Kedaluwarsa</div></div>
        </div>
    </div>

    <div class="vc-card">

        {{-- Toolbar --}}
        <div class="vc-toolbar">
            <div class="vc-search">
                <i class="fa fa-search"></i>
                <input type="text" id="vcSearch" placeholder="Cari kode atau nama voucher..." oninput="vcFilter()">
            </div>
            <div class="vc-filters">
                <button type="button" onclick="vcSetFilter('')"          id="vcFAll"       class="vc-fbtn active">Semua</button>
                <button type="button" onclick="vcSetFilter('active')"    id="vcFActive"    class="vc-fbtn"><i class="fa fa-check-circle" style="font-size:10px"></i> Aktif</button>
                <button type="button" onclick="vcSetFilter('scheduled')" id="vcFScheduled" class="vc-fbtn"><i class="fa fa-clock-o" style="font-size:10px"></i> Terjadwal</button>
                <button type="button" onclick="vcSetFilter('expired')"   id="vcFExpired"   class="vc-fbtn"><i class="fa fa-calendar-times-o" style="font-size:10px"></i> Kedaluwarsa</button>
                <button type="button" onclick="vcSetFilter('inactive')"  id="vcFInactive"  class="vc-fbtn"><i class="fa fa-ban" style="font-size:10px"></i> Nonaktif</button>
            </div>
            <button type="button" class="vc-addbtn" onclick="openAddModal()">
                <i class="fa fa-plus"></i> Buat Voucher
            </button>
        </div>

        @if(session('success'))
            <div class="vc-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="vc-alert error"><i class="fa fa-exclamation-triangle"></i> {{ $errors->first() }}</div>
        @endif

        @if($vouchers->count() > 0)
        <div class="vc-table-wrap">
            <table class="vc-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Diskon</th>
                        <th>Min. Pembelian</th>
                        <th>Kuota</th>
                        <th>Berlaku</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="vcTableBody">
                @foreach($vouchers as $voucher)
                <tr class="vc-row"
                    data-search="{{ strtolower($voucher->code . ' ' . $voucher->name) }}"
                    data-status="{{ $voucher->status }}">
                    <td>
                        <span class="vc-code">{{ $voucher->code }}</span>
                    </td>
                    <td>
                        <div style="font-weight:700;color:#1e1f29;font-size:13px;">{{ $voucher->name }}</div>
                        @if($voucher->description)
                            <div style="font-size:11px;color:#aaa;margin-top:2px;">{{ Str::limit($voucher->description, 50) }}</div>
                        @endif
                    </td>
                    <td>
                        @if($voucher->discount_type === 'percentage')
                            <span class="vc-disc-badge pct">{{ $voucher->discount_value }}%</span>
                            @if($voucher->max_discount)
                                <div style="font-size:10px;color:#aaa;margin-top:3px;">maks Rp {{ number_format($voucher->max_discount,0,',','.') }}</div>
                            @endif
                        @else
                            <span class="vc-disc-badge fixed">Rp {{ number_format($voucher->discount_value,0,',','.') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($voucher->min_purchase > 0)
                            <span style="font-size:12px;color:#555;">Rp {{ number_format($voucher->min_purchase,0,',','.') }}</span>
                        @else
                            <span style="color:#aaa;font-size:12px;">Tidak ada</span>
                        @endif
                    </td>
                    <td>
                        @if($voucher->quota > 0)
                            <div class="vc-quota-wrap">
                                <div style="font-size:12px;font-weight:600;color:#1e1f29;">{{ $voucher->used_count }}/{{ $voucher->quota }}</div>
                                <div class="vc-quota-bar">
                                    <div class="vc-quota-fill" style="width:{{ min(100, ($voucher->used_count/$voucher->quota)*100) }}%"></div>
                                </div>
                            </div>
                        @else
                            <span style="color:#aaa;font-size:12px;">Unlimited</span>
                            @if($voucher->used_count > 0)<div style="font-size:11px;color:#aaa;">{{ $voucher->used_count }}x dipakai</div>@endif
                        @endif
                    </td>
                    <td>
                        <div style="font-size:12px;color:#555;">
                            @if($voucher->start_date)
                                {{ $voucher->start_date->format('d/m/Y') }}
                            @else
                                <span style="color:#aaa;">-</span>
                            @endif
                            &ndash;
                            @if($voucher->end_date)
                                {{ $voucher->end_date->format('d/m/Y') }}
                            @else
                                <span style="color:#aaa;">Selamanya</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        @php
                            $statusMap = [
                                'active'     => ['active',    'fa-check-circle', 'Aktif'],
                                'scheduled'  => ['scheduled', 'fa-clock-o',      'Terjadwal'],
                                'expired'    => ['expired',   'fa-calendar-times-o', 'Kedaluwarsa'],
                                'inactive'   => ['inactive',  'fa-ban',          'Nonaktif'],
                                'quota_full' => ['quota_full','fa-users',        'Kuota Penuh'],
                            ];
                            $s = $statusMap[$voucher->status] ?? ['inactive','fa-ban','Nonaktif'];
                        @endphp
                        <span class="vc-badge {{ $s[0] }}">
                            <i class="fa {{ $s[1] }}" style="font-size:9px;"></i> {{ $s[2] }}
                        </span>
                    </td>
                    <td>
                        <div class="vc-actions">
                            <button type="button" class="vc-btn edit" onclick="openEditModal(
                                {{ $voucher->id }},
                                '{{ addslashes($voucher->code) }}',
                                '{{ addslashes($voucher->name) }}',
                                '{{ addslashes($voucher->description ?? '') }}',
                                '{{ $voucher->discount_type }}',
                                '{{ $voucher->discount_value }}',
                                '{{ $voucher->max_discount ?? '' }}',
                                '{{ $voucher->min_purchase }}',
                                '{{ $voucher->quota }}',
                                '{{ $voucher->start_date ? $voucher->start_date->format('Y-m-d') : '' }}',
                                '{{ $voucher->end_date   ? $voucher->end_date->format('Y-m-d')   : '' }}'
                            )"><i class="fa fa-pencil"></i> Edit</button>

                            <form method="POST" action="{{ route('admin.vouchers.toggle', $voucher) }}" style="margin:0;">
                                @csrf @method('PATCH')
                                <button type="submit" class="vc-btn {{ $voucher->is_active ? 'toff' : 'ton' }}">
                                    <i class="fa fa-power-off"></i>
                                    {{ $voucher->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            <button type="button" class="vc-btn del"
                                    onclick="openDeleteModal({{ $voucher->id }}, '{{ addslashes($voucher->code) }}')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($vouchers->hasPages())
            <div style="padding:16px 22px;">
                {{ $vouchers->links() }}
            </div>
        @endif

        @else
        <div class="vc-empty">
            <div class="vc-empty-icon"><i class="fa fa-ticket"></i></div>
            <h4>Belum ada voucher</h4>
            <p>Klik <strong>Buat Voucher</strong> untuk membuat voucher diskon baru.</p>
        </div>
        @endif

    </div>{{-- /vc-card --}}

</div>{{-- /vc-wrap --}}


{{-- ==================================================================== --}}
{{--  MODAL: Buat Voucher                                                  --}}
{{-- ==================================================================== --}}
<div class="vc-overlay" id="modalAdd">
    <div class="vc-modal">
        <div class="vc-mheader">
            <span class="vc-mtitle"><i class="fa fa-ticket"></i> Buat Voucher Baru</span>
            <button type="button" class="vc-mclose" onclick="closeVcModal('modalAdd')">&times;</button>
        </div>
        <div class="vc-mbody">
            <form method="POST" action="{{ route('admin.vouchers.store') }}">
                @csrf

                <div class="vc-sec-label">Identitas Voucher</div>
                <div class="vc-two-col" style="margin-bottom:16px;">
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Kode Voucher <span style="color:#D10024">*</span></label>
                        <input type="text" name="code" id="addCode" placeholder="Contoh: LEBARAN20" maxlength="50"
                               required oninput="this.value=this.value.toUpperCase()" style="font-family:monospace;font-weight:700;letter-spacing:1px;">
                        <div class="hint">Hanya huruf, angka, dan tanda hubung</div>
                    </div>
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Nama Voucher <span style="color:#D10024">*</span></label>
                        <input type="text" name="name" id="addName" placeholder="Contoh: Promo Lebaran" maxlength="150" required>
                    </div>
                </div>
                <div class="vc-mfield">
                    <label>Deskripsi</label>
                    <textarea name="description" id="addDesc" rows="2" placeholder="Keterangan singkat voucher (opsional)"></textarea>
                </div>

                <div class="vc-sec-label">Nilai Diskon</div>
                <div class="vc-two-col" style="margin-bottom:16px;">
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Tipe Diskon <span style="color:#D10024">*</span></label>
                        <select name="discount_type" id="addDiscType" onchange="toggleAddMaxDiscount()">
                            <option value="percentage">Persentase (%)</option>
                            <option value="fixed">Nominal (Rp)</option>
                        </select>
                    </div>
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Nilai Diskon <span style="color:#D10024">*</span></label>
                        <input type="number" name="discount_value" id="addDiscVal" placeholder="Contoh: 20" min="0.01" step="0.01" required oninput="updateAddPreview()">
                    </div>
                </div>
                <div class="vc-mfield" id="addMaxDiscField">
                    <label>Maksimal Diskon (Rp)</label>
                    <input type="number" name="max_discount" id="addMaxDisc" placeholder="Misal: 50000 (kosongkan jika tidak ada batas)" min="0" oninput="updateAddPreview()">
                    <div class="hint">Berlaku untuk tipe persentase saja</div>
                </div>
                <div class="vc-disc-preview" id="addPreview"></div>

                <div class="vc-sec-label" style="margin-top:16px;">Syarat & Kuota</div>
                <div class="vc-two-col" style="margin-bottom:16px;">
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Minimum Pembelian (Rp)</label>
                        <input type="number" name="min_purchase" id="addMinPurch" placeholder="0 = tidak ada syarat" min="0">
                    </div>
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Kuota Pemakaian</label>
                        <input type="number" name="quota" id="addQuota" placeholder="0 = tidak terbatas" min="0">
                    </div>
                </div>

                <div class="vc-sec-label">Periode</div>
                <div class="vc-two-col">
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" id="addStart">
                    </div>
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Tanggal Berakhir</label>
                        <input type="date" name="end_date" id="addEnd">
                        <div class="hint">Kosongkan agar berlaku selamanya</div>
                    </div>
                </div>

                <div class="vc-mfooter" style="margin-top:20px;">
                    <button type="button" class="btn-mcancel" onclick="closeVcModal('modalAdd')">Batal</button>
                    <button type="submit" class="btn-mok purple"><i class="fa fa-check"></i> Buat Voucher</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ==================================================================== --}}
{{--  MODAL: Edit Voucher                                                  --}}
{{-- ==================================================================== --}}
<div class="vc-overlay" id="modalEdit">
    <div class="vc-modal">
        <div class="vc-mheader">
            <span class="vc-mtitle"><i class="fa fa-pencil"></i> Edit Voucher</span>
            <button type="button" class="vc-mclose" onclick="closeVcModal('modalEdit')">&times;</button>
        </div>
        <div class="vc-mbody">
            <form method="POST" id="editForm" action="">
                @csrf @method('PUT')

                <div class="vc-sec-label">Identitas Voucher</div>
                <div class="vc-two-col" style="margin-bottom:16px;">
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Kode Voucher <span style="color:#D10024">*</span></label>
                        <input type="text" name="code" id="editCode" maxlength="50" required
                               oninput="this.value=this.value.toUpperCase()" style="font-family:monospace;font-weight:700;letter-spacing:1px;">
                    </div>
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Nama Voucher <span style="color:#D10024">*</span></label>
                        <input type="text" name="name" id="editName" maxlength="150" required>
                    </div>
                </div>
                <div class="vc-mfield">
                    <label>Deskripsi</label>
                    <textarea name="description" id="editDesc" rows="2"></textarea>
                </div>

                <div class="vc-sec-label">Nilai Diskon</div>
                <div class="vc-two-col" style="margin-bottom:16px;">
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Tipe Diskon <span style="color:#D10024">*</span></label>
                        <select name="discount_type" id="editDiscType" onchange="toggleEditMaxDiscount()">
                            <option value="percentage">Persentase (%)</option>
                            <option value="fixed">Nominal (Rp)</option>
                        </select>
                    </div>
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Nilai Diskon <span style="color:#D10024">*</span></label>
                        <input type="number" name="discount_value" id="editDiscVal" min="0.01" step="0.01" required>
                    </div>
                </div>
                <div class="vc-mfield" id="editMaxDiscField">
                    <label>Maksimal Diskon (Rp)</label>
                    <input type="number" name="max_discount" id="editMaxDisc" min="0">
                    <div class="hint">Berlaku untuk tipe persentase saja</div>
                </div>

                <div class="vc-sec-label" style="margin-top:16px;">Syarat & Kuota</div>
                <div class="vc-two-col" style="margin-bottom:16px;">
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Minimum Pembelian (Rp)</label>
                        <input type="number" name="min_purchase" id="editMinPurch" min="0">
                    </div>
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Kuota Pemakaian</label>
                        <input type="number" name="quota" id="editQuota" min="0">
                    </div>
                </div>

                <div class="vc-sec-label">Periode</div>
                <div class="vc-two-col">
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" id="editStart">
                    </div>
                    <div class="vc-mfield" style="margin-bottom:0;">
                        <label>Tanggal Berakhir</label>
                        <input type="date" name="end_date" id="editEnd">
                    </div>
                </div>

                <div class="vc-mfooter" style="margin-top:20px;">
                    <button type="button" class="btn-mcancel" onclick="closeVcModal('modalEdit')">Batal</button>
                    <button type="submit" class="btn-mok purple"><i class="fa fa-check"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ==================================================================== --}}
{{--  MODAL: Konfirmasi Hapus                                              --}}
{{-- ==================================================================== --}}
<div class="vc-overlay" id="modalDelete">
    <div class="vc-modal vc-del-modal">
        <div class="vc-mheader">
            <span class="vc-mtitle"><i class="fa fa-trash"></i> Hapus Voucher</span>
            <button type="button" class="vc-mclose" onclick="closeVcModal('modalDelete')">&times;</button>
        </div>
        <div class="vc-mbody">
            <div class="vc-del-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <div class="vc-del-text">Hapus voucher <strong id="delCode"></strong>?</div>
            <div class="vc-del-sub">Tindakan ini tidak dapat dibatalkan.</div>
            <form method="POST" id="deleteForm" action="" style="margin-top:20px;">
                @csrf @method('DELETE')
                <div class="vc-mfooter">
                    <button type="button" class="btn-mcancel" onclick="closeVcModal('modalDelete')">Batal</button>
                    <button type="submit" class="btn-mok danger"><i class="fa fa-trash"></i> Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ============ Modal ============
function openAddModal() {
    ['addCode','addName','addDesc','addDiscVal','addMaxDisc','addMinPurch','addQuota','addStart','addEnd']
        .forEach(function(id){ var el=document.getElementById(id); if(el) el.value=''; });
    document.getElementById('addDiscType').value = 'percentage';
    toggleAddMaxDiscount();
    document.getElementById('addPreview').style.display = 'none';
    document.getElementById('modalAdd').classList.add('open');
    setTimeout(function(){ document.getElementById('addCode').focus(); }, 100);
}

function openEditModal(id, code, name, desc, dtype, dval, maxDisc, minPurch, quota, start, end) {
    document.getElementById('editForm').action = '/admin/vouchers/' + id;
    document.getElementById('editCode').value     = code;
    document.getElementById('editName').value     = name;
    document.getElementById('editDesc').value     = desc;
    document.getElementById('editDiscType').value = dtype;
    document.getElementById('editDiscVal').value  = dval;
    document.getElementById('editMaxDisc').value  = maxDisc;
    document.getElementById('editMinPurch').value = minPurch;
    document.getElementById('editQuota').value    = quota;
    document.getElementById('editStart').value    = start;
    document.getElementById('editEnd').value      = end;
    toggleEditMaxDiscount();
    document.getElementById('modalEdit').classList.add('open');
}

function openDeleteModal(id, code) {
    document.getElementById('deleteForm').action = '/admin/vouchers/' + id;
    document.getElementById('delCode').textContent = code;
    document.getElementById('modalDelete').classList.add('open');
}

function closeVcModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.vc-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) { if (e.target === el) closeVcModal(el.id); });
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') ['modalAdd','modalEdit','modalDelete'].forEach(closeVcModal);
});

// ============ Toggle max_discount field ============
function toggleAddMaxDiscount() {
    var show = document.getElementById('addDiscType').value === 'percentage';
    document.getElementById('addMaxDiscField').style.display = show ? 'block' : 'none';
    updateAddPreview();
}
function toggleEditMaxDiscount() {
    var show = document.getElementById('editDiscType').value === 'percentage';
    document.getElementById('editMaxDiscField').style.display = show ? 'block' : 'none';
}

// ============ Discount preview ============
function updateAddPreview() {
    var dtype  = document.getElementById('addDiscType').value;
    var dval   = parseFloat(document.getElementById('addDiscVal').value) || 0;
    var maxD   = parseFloat(document.getElementById('addMaxDisc').value) || 0;
    var p      = document.getElementById('addPreview');
    if (!dval) { p.style.display = 'none'; return; }
    var text = '';
    if (dtype === 'percentage') {
        text = 'Diskon ' + dval + '%';
        if (maxD > 0) text += ', maksimal Rp ' + maxD.toLocaleString('id-ID');
    } else {
        text = 'Potongan Rp ' + dval.toLocaleString('id-ID');
    }
    p.textContent = text;
    p.style.display = 'block';
}

// ============ Table filter ============
var vcCurrentFilter = '';
function vcSetFilter(f) {
    vcCurrentFilter = f;
    document.querySelectorAll('.vc-fbtn').forEach(function(b){ b.classList.remove('active'); });
    var map = {'':'vcFAll','active':'vcFActive','scheduled':'vcFScheduled','expired':'vcFExpired','inactive':'vcFInactive'};
    if (map[f]) document.getElementById(map[f]).classList.add('active');
    vcFilter();
}
function vcFilter() {
    var q = document.getElementById('vcSearch').value.toLowerCase();
    var rows = document.querySelectorAll('#vcTableBody .vc-row');
    rows.forEach(function(row) {
        var searchMatch  = !q || row.dataset.search.includes(q);
        var statusMatch  = !vcCurrentFilter || row.dataset.status === vcCurrentFilter;
        row.style.display = (searchMatch && statusMatch) ? '' : 'none';
    });
}

// ============ Auto-open on validation error ============
@if($errors->any() && !old('_method'))
document.addEventListener('DOMContentLoaded', function(){ openAddModal(); });
@endif
</script>

@endsection
