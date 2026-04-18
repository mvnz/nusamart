@extends('layouts.admin')

@section('title', 'Jadwal Promo - Admin Panel')

@section('content')

<style>
.ps-wrap { max-width: 860px; margin: 0 auto; }

/* Header */
.ps-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
.ps-title { font-size: 20px; font-weight: 800; color: #1e1f29; margin: 0; }
.ps-subtitle { font-size: 13px; color: #aaa; margin: 4px 0 0; }

/* Add form card */
.ps-add-card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,.07); margin-bottom: 24px; }
.ps-add-title { font-size: 14px; font-weight: 800; color: #1e1f29; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.ps-form-row { display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 12px; align-items: end; }
@media(max-width:640px) { .ps-form-row { grid-template-columns: 1fr 1fr; } }
.ps-field label { display: block; font-size: 11px; font-weight: 700; color: #888; margin-bottom: 5px; text-transform: uppercase; letter-spacing: .4px; }
.ps-field input { width: 100%; padding: 10px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-family: inherit; box-sizing: border-box; }
.ps-field input:focus { outline: none; border-color: #D10024; box-shadow: 0 0 0 3px rgba(209,0,36,.08); }

/* Slots list */
.ps-list-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.07); overflow: hidden; }
.ps-list-header { padding: 16px 20px; border-bottom: 1.5px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; }
.ps-list-header-title { font-size: 13px; font-weight: 800; color: #1e1f29; }
.ps-list-count { font-size: 12px; color: #aaa; background: #f4f5f7; padding: 3px 10px; border-radius: 20px; }

.ps-slot-row { display: flex; align-items: center; gap: 12px; padding: 14px 20px; border-bottom: 1px solid #f4f5f7; transition: background .15s; }
.ps-slot-row:last-child { border-bottom: none; }
.ps-slot-row:hover { background: #fafbfc; }

/* Drag handle */
.ps-drag { cursor: grab; color: #ccc; font-size: 14px; flex-shrink: 0; }
.ps-drag:active { cursor: grabbing; }

/* Period badge */
.ps-period-badge {
    background: linear-gradient(135deg, #D10024, #ff4466);
    color: #fff; border-radius: 8px; padding: 8px 14px;
    min-width: 120px; text-align: center; flex-shrink: 0;
}
.ps-period-badge .badge-time { font-size: 15px; font-weight: 800; letter-spacing: .5px; }
.ps-period-badge .badge-label { font-size: 10px; opacity: .85; margin-top: 2px; }

/* Inactive badge */
.ps-slot-row.inactive .ps-period-badge { background: #e5e7eb; color: #999; }

/* Slot name */
.ps-slot-name { flex: 1; min-width: 0; }
.ps-slot-name-text { font-size: 14px; font-weight: 700; color: #1e1f29; }
.ps-slot-duration { font-size: 11px; color: #aaa; margin-top: 2px; }

/* Status badge */
.s-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; }
.s-active { background: #d1fae5; color: #065f46; }
.s-inactive { background: #f3f4f6; color: #6b7280; }

/* Actions */
.ps-actions { display: flex; gap: 6px; flex-shrink: 0; }
.btn-icon { width: 32px; height: 32px; border: none; border-radius: 8px; cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center; transition: all .2s; text-decoration: none; }
.btn-edit { background: #dbeafe; color: #1e40af; }
.btn-edit:hover { background: #bfdbfe; }
.btn-toggle-on { background: #fef3c7; color: #92400e; }
.btn-toggle-on:hover { background: #fde68a; }
.btn-toggle-off { background: #d1fae5; color: #065f46; }
.btn-toggle-off:hover { background: #a7f3d0; }
.btn-del { background: #fee2e2; color: #991b1b; }
.btn-del:hover { background: #fecaca; }

/* Edit inline row */
.ps-edit-row { padding: 14px 20px; background: #fffbf0; border-bottom: 1px solid #fde68a; }
.ps-edit-form-row { display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 12px; align-items: end; }

/* Empty */
.ps-empty { text-align: center; padding: 60px 20px; color: #aaa; }
.ps-empty i { font-size: 40px; margin-bottom: 12px; display: block; color: #e5e7eb; }

/* Buttons */
.btn { padding: 10px 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: 7px; font-family: inherit; }
.btn-primary { background: #D10024; color: #fff; }
.btn-primary:hover { background: #a8001e; }
.btn-secondary { background: #f4f5f7; color: #555; border: 1.5px solid #e5e7eb; }
.btn-secondary:hover { background: #e5e7eb; }
.btn-sm { padding: 7px 14px; font-size: 12px; }
.btn-success { background: #059669; color: #fff; }
.btn-success:hover { background: #047857; }
.btn-danger { background: #ef4444; color: #fff; }
.btn-danger:hover { background: #dc2626; }

/* Alert */
.alert { padding: 13px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 10px; font-size: 13px; }
.alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
.alert-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }

/* Back link */
.back-link { font-size: 13px; color: #888; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 20px; }
.back-link:hover { color: #D10024; }
</style>

<div class="ps-wrap">

    <a href="{{ route('admin.promos') }}" class="back-link"><i class="fa fa-arrow-left"></i> Kembali ke Monitor Promo</a>

    <div class="ps-header">
        <div>
            <h1 class="ps-title"><i class="fa fa-clock-o"></i> Jadwal Periode Promo</h1>
            <p class="ps-subtitle">Atur daftar periode waktu promo yang dapat dipakai penjual saat membuat flash sale</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            <i class="fa fa-exclamation-circle" style="flex-shrink:0;margin-top:1px;"></i>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
    @endif

    {{-- ===== ADD FORM ===== --}}
    <div class="ps-add-card">
        <div class="ps-add-title"><i class="fa fa-plus-circle" style="color:#D10024;"></i> Tambah Periode Baru</div>
        <form method="POST" action="{{ route('admin.promo-slots.store') }}">
            @csrf
            <div class="ps-form-row">
                <div class="ps-field">
                    <label>Nama Periode</label>
                    <input type="text" name="name" placeholder="Contoh: Flash Sale Pagi" value="{{ old('name') }}" required maxlength="100">
                </div>
                <div class="ps-field">
                    <label>Jam Mulai</label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" required>
                </div>
                <div class="ps-field">
                    <label>Jam Selesai</label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" required>
                </div>
                <div class="ps-field">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary" style="white-space:nowrap;">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
            <div style="margin-top:10px;">
                <label style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.4px;">Urutan Tampil</label>
                <input type="number" name="sort_order" min="0" value="{{ old('sort_order', 0) }}" style="width:80px;padding:7px 10px;border:1.5px solid #e5e7eb;border-radius:6px;font-size:13px;margin-top:5px;">
                <span style="font-size:12px;color:#aaa;margin-left:6px;">0 = paling atas</span>
            </div>
        </form>
    </div>

    {{-- ===== SLOTS LIST ===== --}}
    <div class="ps-list-card">
        <div class="ps-list-header">
            <span class="ps-list-header-title">Semua Periode</span>
            <span class="ps-list-count">{{ $slots->count() }} periode</span>
        </div>

        @forelse($slots as $slot)
            {{-- Normal view row --}}
            <div class="ps-slot-row {{ $slot->is_active ? '' : 'inactive' }}" id="row-{{ $slot->id }}">
                <div class="ps-drag"><i class="fa fa-bars"></i></div>

                <div class="ps-period-badge">
                    <div class="badge-time">{{ $slot->time_range }}</div>
                    <div class="badge-label">{{ $slot->is_active ? 'Aktif' : 'Nonaktif' }}</div>
                </div>

                <div class="ps-slot-name">
                    <div class="ps-slot-name-text">{{ $slot->name }}</div>
                    @php
                        $start = \Carbon\Carbon::createFromTimeString($slot->start_time);
                        $end   = \Carbon\Carbon::createFromTimeString($slot->end_time);
                        $dur   = $start->diff($end);
                        $durText = ($dur->h > 0 ? $dur->h . ' jam ' : '') . ($dur->i > 0 ? $dur->i . ' menit' : '');
                    @endphp
                    <div class="ps-slot-duration"><i class="fa fa-hourglass-half"></i> Durasi {{ $durText }}</div>
                </div>

                <span class="s-badge {{ $slot->is_active ? 's-active' : 's-inactive' }}">
                    <i class="fa fa-circle" style="font-size:8px;"></i>
                    {{ $slot->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>

                <div class="ps-actions">
                    {{-- Edit button (toggles inline form) --}}
                    <button type="button" class="btn-icon btn-edit" title="Edit" onclick="toggleEdit({{ $slot->id }})">
                        <i class="fa fa-pencil"></i>
                    </button>
                    {{-- Toggle active --}}
                    <form method="POST" action="{{ route('admin.promo-slots.toggle', $slot) }}" style="margin:0;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-icon {{ $slot->is_active ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                title="{{ $slot->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                            <i class="fa fa-power-off"></i>
                        </button>
                    </form>
                    {{-- Delete --}}
                    <form method="POST" action="{{ route('admin.promo-slots.destroy', $slot) }}" style="margin:0;"
                          onsubmit="return confirm('Hapus periode {{ addslashes($slot->name) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon btn-del" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Inline edit row (hidden) --}}
            <div class="ps-edit-row" id="edit-{{ $slot->id }}" style="display:none;">
                <form method="POST" action="{{ route('admin.promo-slots.update', $slot) }}">
                    @csrf @method('PUT')
                    <div class="ps-edit-form-row">
                        <div class="ps-field">
                            <label>Nama Periode</label>
                            <input type="text" name="name" value="{{ $slot->name }}" required maxlength="100">
                        </div>
                        <div class="ps-field">
                            <label>Jam Mulai</label>
                            <input type="time" name="start_time" value="{{ substr($slot->start_time,0,5) }}" required>
                        </div>
                        <div class="ps-field">
                            <label>Jam Selesai</label>
                            <input type="time" name="end_time" value="{{ substr($slot->end_time,0,5) }}" required>
                        </div>
                        <div class="ps-field" style="display:flex;gap:6px;">
                            <div>
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Simpan</button>
                            </div>
                            <div>
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit({{ $slot->id }})"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:10px;display:flex;align-items:center;gap:10px;">
                        <label style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.4px;">Urutan:</label>
                        <input type="number" name="sort_order" min="0" value="{{ $slot->sort_order }}" style="width:70px;padding:6px 8px;border:1.5px solid #e5e7eb;border-radius:6px;font-size:13px;">
                    </div>
                </form>
            </div>
        @empty
            <div class="ps-empty">
                <i class="fa fa-clock-o"></i>
                <div style="font-size:15px;font-weight:700;color:#555;margin-bottom:6px;">Belum ada periode promo</div>
                <div style="font-size:13px;">Tambahkan periode di atas untuk mulai mengatur jadwal flash sale</div>
            </div>
        @endforelse
    </div>

    {{-- Info box --}}
    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:16px 18px;margin-top:20px;font-size:12px;color:#1e40af;display:flex;gap:10px;">
        <i class="fa fa-info-circle" style="flex-shrink:0;margin-top:1px;font-size:15px;"></i>
        <div>
            <strong>Cara kerja periode promo:</strong> Daftar periode ini akan tampil sebagai pilihan cepat saat penjual membuat promo. Penjual bisa pilih periode yang sudah ada atau isi manual jam custom-nya sendiri.
        </div>
    </div>

</div>

<script>
function toggleEdit(id) {
    var editRow = document.getElementById('edit-' + id);
    var isHidden = editRow.style.display === 'none';
    // Hide all other edit rows
    document.querySelectorAll('[id^="edit-"]').forEach(function(el) { el.style.display = 'none'; });
    editRow.style.display = isHidden ? 'block' : 'none';
    if (isHidden) editRow.querySelector('input[type="text"]').focus();
}
</script>

@endsection
