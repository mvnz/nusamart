@extends('layouts.admin')

@section('title', 'Monitor Promo - Admin Panel')

@section('content')
<style>
.mp-wrap { max-width:1100px; margin:0 auto; padding:4px 0 48px; }

/* Page header */
.mp-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.mp-page-title  { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.mp-page-title i { color:#e67e22; font-size:20px; }

/* Stats */
.mp-stats { display:grid; grid-template-columns:repeat(5,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:800px){ .mp-stats{ grid-template-columns:repeat(2,1fr); } }
.mp-stat { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:18px; display:flex; align-items:center; gap:13px; cursor:pointer; transition:box-shadow .2s,transform .15s; }
.mp-stat:hover { box-shadow:0 4px 18px rgba(0,0,0,.1); transform:translateY(-1px); }
.mp-stat.sel  { box-shadow:0 0 0 2px #D10024, 0 4px 18px rgba(209,0,36,.12); }
.mp-si { width:46px; height:46px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.mp-si.grey   { background:linear-gradient(135deg,#e5e7eb,#f3f4f6); color:#6b7280; }
.mp-si.green  { background:linear-gradient(135deg,#c8f7d6,#edfff3); color:#1a9e50; }
.mp-si.yellow { background:linear-gradient(135deg,#fef3c7,#fffbeb); color:#d97706; }
.mp-si.red2   { background:linear-gradient(135deg,#ffd6d6,#ffefef); color:#D10024; }
.mp-si.slate  { background:linear-gradient(135deg,#e2e8f0,#f1f5f9); color:#475569; }
.mp-sv { font-size:26px; font-weight:800; color:#1e1f29; line-height:1; }
.mp-sl { font-size:11.5px; color:#8d8d8d; margin-top:3px; font-weight:500; }

/* Main card */
.mp-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:visible; }

/* Toolbar */
.mp-toolbar { display:flex; align-items:center; gap:12px; padding:18px 22px; border-bottom:1px solid #f2f2f5; flex-wrap:wrap; }
.mp-search { display:flex; align-items:center; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden; transition:border .2s; background:#f9fafb; flex:1; min-width:180px; max-width:260px; }
.mp-search:focus-within { border-color:#e67e22; background:#fff; }
.mp-search i { padding:0 11px; color:#c0c0c0; font-size:13px; }
.mp-search input { flex:1; border:none; outline:none; padding:10px 0; font-size:13px; background:transparent; font-family:inherit; }
.mp-seller-sel { padding:10px 13px; border:1.5px solid #e5e7eb; border-radius:10px; font-size:13px; font-family:inherit; outline:none; cursor:pointer; background:#f9fafb; color:#555; transition:border .2s; }
.mp-seller-sel:focus { border-color:#e67e22; background:#fff; }
.mp-filters { display:flex; gap:6px; flex-wrap:wrap; }
.mp-fbtn { padding:7px 14px; border:1.5px solid #e5e7eb; border-radius:20px; background:#fff; font-size:12px; font-weight:700; color:#666; cursor:pointer; font-family:inherit; transition:all .2s; display:inline-flex; align-items:center; gap:5px; white-space:nowrap; }
.mp-fbtn:hover { border-color:#e67e22; color:#e67e22; }
.mp-fbtn.active { background:#e67e22; border-color:#e67e22; color:#fff; }

/* Alert */
.mp-alert { display:flex; align-items:center; gap:8px; padding:12px 22px; font-size:13px; border-bottom:1px solid transparent; }
.mp-alert.success { background:#d1fae5; border-color:#6ee7b7; color:#065f46; }
.mp-alert.error   { background:#fee2e2; border-color:#fca5a5; color:#991b1b; }

/* Table */
.mp-table-wrap { overflow-x:auto; border-radius:0 0 16px 16px; }
.mp-table { width:100%; border-collapse:collapse; font-size:13px; }
.mp-table th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:11px 16px; text-align:left; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.mp-table td { padding:12px 16px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.mp-row:hover td { background:#fafbfc; }

/* Product cell */
.mp-prod { display:flex; align-items:center; gap:10px; }
.mp-prod-img { width:44px; height:44px; border-radius:9px; object-fit:cover; background:#f3f4f6; flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:16px; border:1px solid #f0f0f0; }
.mp-prod-name { font-weight:700; color:#1e1f29; font-size:13px; line-height:1.3; max-width:160px; }
.mp-prod-id { font-size:10px; color:#bbb; margin-top:2px; }

/* Seller cell */
.mp-seller-avatar { width:30px; height:30px; border-radius:50%; background:linear-gradient(135deg,#fde68a,#fbbf24); color:#92400e; font-size:12px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.mp-seller-name { font-weight:700; color:#1e1f29; font-size:12.5px; }
.mp-seller-email { font-size:10.5px; color:#aaa; }

/* Price cell */
.mp-price-new  { font-size:14px; font-weight:800; color:#D10024; }
.mp-price-orig { font-size:11px; color:#bbb; text-decoration:line-through; margin-top:1px; }
.mp-disc-badge { display:inline-block; background:#fff0f0; color:#D10024; font-size:11px; font-weight:800; padding:2px 8px; border-radius:6px; margin-top:3px; }

/* Quota bar */
.mp-quota-wrap { min-width:90px; }
.mp-quota-bar { height:5px; background:#f0f0f0; border-radius:3px; margin-top:4px; overflow:hidden; }
.mp-quota-fill { height:100%; border-radius:3px; background:linear-gradient(90deg,#e67e22,#f5a623); }
.mp-quota-text { font-size:12px; font-weight:600; color:#444; }

/* Period */
.mp-period { font-size:12px; color:#555; line-height:1.6; }
.mp-countdown { display:inline-flex; align-items:center; gap:4px; font-size:10.5px; font-weight:700; padding:2px 8px; border-radius:10px; margin-top:3px; }
.mp-countdown.running { background:#d1fae5; color:#065f46; }
.mp-countdown.soon    { background:#fef3c7; color:#92400e; }
.mp-countdown.past    { background:#f3f4f6; color:#6b7280; }

/* Status badge */
.mp-badge { display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:700; padding:4px 11px; border-radius:20px; white-space:nowrap; }
.mp-badge.active    { background:#d1fae5; color:#065f46; }
.mp-badge.scheduled { background:#fef3c7; color:#92400e; }
.mp-badge.expired   { background:#f3f4f6; color:#6b7280; }
.mp-badge.inactive  { background:#fee2e2; color:#991b1b; }

/* Actions */
.mp-actions { display:flex; gap:5px; flex-wrap:nowrap; }
.mp-btn { display:inline-flex; align-items:center; gap:4px; padding:6px 11px; border:none; border-radius:7px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; white-space:nowrap; text-decoration:none; }
.mp-btn.view  { background:#e3f2fd; color:#1565c0; }
.mp-btn.view:hover  { background:#bbdefb; }
.mp-btn.ton   { background:#d1fae5; color:#065f46; }
.mp-btn.ton:hover   { background:#a7f3d0; }
.mp-btn.toff  { background:#fef3c7; color:#92400e; }
.mp-btn.toff:hover  { background:#fde68a; }
.mp-btn.del   { background:#fee2e2; color:#991b1b; }
.mp-btn.del:hover   { background:#fecaca; }

/* Empty */
.mp-empty { text-align:center; padding:64px 24px; }
.mp-empty-icon { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#fde68a,#fffbeb); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.mp-empty-icon i { font-size:28px; color:#e67e22; }
.mp-empty h4 { font-size:15px; font-weight:700; color:#374151; margin:0 0 6px; }
.mp-empty p  { font-size:13px; color:#9ca3af; margin:0; }

/* ==== MODALS ==== */
.mp-overlay { display:none; position:fixed; inset:0; background:rgba(10,12,20,.55); z-index:9000; justify-content:center; align-items:center; padding:20px; }
.mp-overlay.open { display:flex; }
.mp-modal { background:#fff; border-radius:18px; width:400px; max-width:100%; box-shadow:0 24px 64px rgba(0,0,0,.28); animation:mpSlideIn .2s ease; overflow:hidden; }
@keyframes mpSlideIn { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:translateY(0)} }
.mp-mheader { padding:18px 24px 16px; background:linear-gradient(135deg,#1a1f2e 0%,#2d3347 100%); display:flex; align-items:center; justify-content:space-between; }
.mp-mtitle { font-size:15px; font-weight:800; color:#fff; display:flex; align-items:center; gap:8px; }
.mp-mtitle i { color:rgba(255,255,255,.5); }
.mp-mclose { background:rgba(255,255,255,.12); border:none; font-size:18px; color:#fff; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:8px; line-height:1; }
.mp-mclose:hover { background:rgba(255,255,255,.25); }
.mp-mbody { padding:24px; }
.mp-micon  { text-align:center; font-size:44px; margin-bottom:14px; }
.mp-mtext  { text-align:center; font-size:14px; color:#333; line-height:1.6; margin-bottom:6px; }
.mp-msub   { text-align:center; font-size:12px; color:#aaa; }
.mp-mfooter { display:flex; justify-content:flex-end; gap:10px; margin-top:24px; }
.btn-mok    { padding:10px 22px; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; }
.btn-mok.orange { background:#e67e22; color:#fff; }
.btn-mok.orange:hover { background:#cf6d17; }
.btn-mok.danger { background:#ef4444; color:#fff; }
.btn-mok.danger:hover { background:#dc2626; }
.btn-mcancel { padding:10px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; }
.btn-mcancel:hover { background:#e5e7eb; }
</style>

<div class="mp-wrap">

    <div class="mp-page-header">
        <h1 class="mp-page-title"><i class="fa fa-bullhorn"></i> Monitoring Promo</h1>
        <div style="font-size:13px;color:#aaa;">Kelola dan monitor semua promo yang dibuat penjual</div>
    </div>

    {{-- Stats cards (clickable filter) --}}
    <div class="mp-stats">
        <div class="mp-stat {{ !request('status') ? 'sel' : '' }}" onclick="mpGoFilter('')">
            <div class="mp-si grey"><i class="fa fa-list"></i></div>
            <div><div class="mp-sv">{{ $stats['total'] }}</div><div class="mp-sl">Total Promo</div></div>
        </div>
        <div class="mp-stat {{ request('status')==='active' ? 'sel' : '' }}" onclick="mpGoFilter('active')">
            <div class="mp-si green"><i class="fa fa-check-circle"></i></div>
            <div><div class="mp-sv">{{ $stats['active'] }}</div><div class="mp-sl">Aktif</div></div>
        </div>
        <div class="mp-stat {{ request('status')==='scheduled' ? 'sel' : '' }}" onclick="mpGoFilter('scheduled')">
            <div class="mp-si yellow"><i class="fa fa-clock-o"></i></div>
            <div><div class="mp-sv">{{ $stats['scheduled'] }}</div><div class="mp-sl">Terjadwal</div></div>
        </div>
        <div class="mp-stat {{ request('status')==='expired' ? 'sel' : '' }}" onclick="mpGoFilter('expired')">
            <div class="mp-si slate"><i class="fa fa-calendar-times-o"></i></div>
            <div><div class="mp-sv">{{ $stats['expired'] }}</div><div class="mp-sl">Berakhir</div></div>
        </div>
        <div class="mp-stat {{ request('status')==='inactive' ? 'sel' : '' }}" onclick="mpGoFilter('inactive')">
            <div class="mp-si red2"><i class="fa fa-ban"></i></div>
            <div><div class="mp-sv">{{ $stats['inactive'] }}</div><div class="mp-sl">Nonaktif</div></div>
        </div>
    </div>

    <div class="mp-card">

        {{-- Toolbar --}}
        <form method="GET" id="mpFilterForm">
            <input type="hidden" name="status" id="mpStatusHidden" value="{{ request('status') }}">
            <div class="mp-toolbar">
                <div class="mp-search">
                    <i class="fa fa-search"></i>
                    <input type="text" name="search" placeholder="Cari produk atau penjual..." value="{{ request('search') }}"
                           oninput="clearTimeout(mpSearchTimer); mpSearchTimer=setTimeout(()=>{document.getElementById('mpFilterForm').submit()},500)">
                </div>
                <select name="seller_id" class="mp-seller-sel" onchange="document.getElementById('mpFilterForm').submit()">
                    <option value="">Semua Penjual</option>
                    @foreach($sellers as $seller)
                        <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                            {{ $seller->name }}
                        </option>
                    @endforeach
                </select>
                <div class="mp-filters">
                    <button type="button" onclick="mpSetFilter('')"          class="mp-fbtn {{ !request('status') ? 'active' : '' }}">Semua</button>
                    <button type="button" onclick="mpSetFilter('active')"    class="mp-fbtn {{ request('status')==='active' ? 'active' : '' }}"><i class="fa fa-check-circle" style="font-size:10px"></i> Aktif</button>
                    <button type="button" onclick="mpSetFilter('scheduled')" class="mp-fbtn {{ request('status')==='scheduled' ? 'active' : '' }}"><i class="fa fa-clock-o" style="font-size:10px"></i> Terjadwal</button>
                    <button type="button" onclick="mpSetFilter('expired')"   class="mp-fbtn {{ request('status')==='expired' ? 'active' : '' }}"><i class="fa fa-calendar-times-o" style="font-size:10px"></i> Berakhir</button>
                    <button type="button" onclick="mpSetFilter('inactive')"  class="mp-fbtn {{ request('status')==='inactive' ? 'active' : '' }}"><i class="fa fa-ban" style="font-size:10px"></i> Nonaktif</button>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="mp-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mp-alert error"><i class="fa fa-exclamation-triangle"></i> {{ session('error') }}</div>
        @endif

        @if($promos->count() > 0)
        <div class="mp-table-wrap">
            <table class="mp-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Penjual</th>
                        <th>Harga & Diskon</th>
                        <th>Periode</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($promos as $promo)
                @php
                    $status = $promo->isActive() ? 'active' : ($promo->isScheduled() ? 'scheduled' : ($promo->isExpired() ? 'expired' : 'inactive'));
                    $daysLeft = now()->diffInDays($promo->end_date, false);
                    $daysStart = now()->diffInDays($promo->start_date, false);
                    $sellerInitial = strtoupper(substr($promo->seller->name, 0, 1));
                @endphp
                <tr class="mp-row">
                    <td>
                        <div class="mp-prod">
                            @if($promo->product->image)
                                <img src="{{ asset('storage/' . $promo->product->image) }}" alt="" class="mp-prod-img">
                            @else
                                <div class="mp-prod-img"><i class="fa fa-image"></i></div>
                            @endif
                            <div>
                                <div class="mp-prod-name">{{ Str::limit($promo->product->name, 40) }}</div>
                                <div class="mp-prod-id">#{{ $promo->product->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div class="mp-seller-avatar">{{ $sellerInitial }}</div>
                            <div>
                                <div class="mp-seller-name">{{ $promo->seller->name }}</div>
                                <div class="mp-seller-email">{{ $promo->seller->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="mp-price-new">Rp {{ number_format($promo->promo_price, 0, ',', '.') }}</div>
                        <div class="mp-price-orig">Rp {{ number_format($promo->original_price, 0, ',', '.') }}</div>
                        <span class="mp-disc-badge">-{{ $promo->getDiscountPercentage() }}%</span>
                    </td>
                    <td>
                        <div class="mp-period">
                            {{ $promo->start_date->format('d/m/Y') }} &ndash; {{ $promo->end_date->format('d/m/Y') }}
                        </div>
                        @if($status === 'active' && $daysLeft >= 0)
                            <span class="mp-countdown running"><i class="fa fa-circle" style="font-size:7px"></i> {{ $daysLeft }} hari lagi</span>
                        @elseif($status === 'scheduled' && $daysStart >= 0)
                            <span class="mp-countdown soon"><i class="fa fa-clock-o" style="font-size:9px"></i> mulai {{ $daysStart }} hari lagi</span>
                        @elseif($status === 'expired')
                            <span class="mp-countdown past"><i class="fa fa-times" style="font-size:9px"></i> sudah berakhir</span>
                        @endif
                    </td>
                    <td>
                        @if($promo->quota > 0)
                            <div class="mp-quota-wrap">
                                <div class="mp-quota-text">{{ $promo->used_quota }}/{{ $promo->quota }}</div>
                                <div class="mp-quota-bar">
                                    <div class="mp-quota-fill" style="width:{{ min(100, ($promo->used_quota/$promo->quota)*100) }}%"></div>
                                </div>
                            </div>
                        @else
                            <span style="color:#aaa;font-size:12px;">Unlimited</span>
                            @if($promo->used_quota > 0)<div style="font-size:10.5px;color:#bbb;">{{ $promo->used_quota }}x dipakai</div>@endif
                        @endif
                    </td>
                    <td>
                        @if($status === 'active')
                            <span class="mp-badge active"><i class="fa fa-circle" style="font-size:7px"></i> Aktif</span>
                        @elseif($status === 'scheduled')
                            <span class="mp-badge scheduled"><i class="fa fa-clock-o" style="font-size:9px"></i> Terjadwal</span>
                        @elseif($status === 'expired')
                            <span class="mp-badge expired"><i class="fa fa-times" style="font-size:9px"></i> Berakhir</span>
                        @else
                            <span class="mp-badge inactive"><i class="fa fa-ban" style="font-size:9px"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="mp-actions">
                            <a href="{{ route('admin.promos.show', $promo->id) }}" class="mp-btn view">
                                <i class="fa fa-eye"></i> Lihat
                            </a>
                            @if($promo->is_active)
                                <button type="button" class="mp-btn toff"
                                        onclick="mpOpenDeactivate({{ $promo->id }}, '{{ addslashes($promo->product->name) }}')">
                                    <i class="fa fa-power-off"></i> Matikan
                                </button>
                            @else
                                <form method="POST" action="{{ route('admin.promos.activate', $promo->id) }}" style="margin:0">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="mp-btn ton">
                                        <i class="fa fa-check"></i> Aktifkan
                                    </button>
                                </form>
                            @endif
                            <button type="button" class="mp-btn del"
                                    onclick="mpOpenDelete({{ $promo->id }}, '{{ addslashes($promo->product->name) }}')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($promos->hasPages())
            <div style="padding:16px 22px;">
                {{ $promos->links() }}
            </div>
        @endif

        @else
        <div class="mp-empty">
            <div class="mp-empty-icon"><i class="fa fa-inbox"></i></div>
            <h4>Tidak ada promo ditemukan</h4>
            <p>Coba ubah filter atau kata kunci pencarian.</p>
        </div>
        @endif

    </div>{{-- /mp-card --}}

</div>{{-- /mp-wrap --}}


{{-- Modal: Nonaktifkan --}}
<div class="mp-overlay" id="mpModalDeactivate">
    <div class="mp-modal">
        <div class="mp-mheader">
            <span class="mp-mtitle"><i class="fa fa-power-off"></i> Nonaktifkan Promo</span>
            <button type="button" class="mp-mclose" onclick="mpCloseModal('mpModalDeactivate')">&times;</button>
        </div>
        <div class="mp-mbody">
            <div class="mp-micon" style="color:#d97706;">⚠️</div>
            <div class="mp-mtext">Nonaktifkan promo <strong id="mpDeactivateName"></strong>?</div>
            <div class="mp-msub">Promo tidak akan tampil di halaman produk. Penjual dapat mengaktifkannya kembali.</div>
            <form method="POST" id="mpDeactivateForm" action="">
                @csrf @method('PATCH')
                <div class="mp-mfooter">
                    <button type="button" class="btn-mcancel" onclick="mpCloseModal('mpModalDeactivate')">Batal</button>
                    <button type="submit" class="btn-mok orange"><i class="fa fa-power-off"></i> Ya, Nonaktifkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal: Hapus --}}
<div class="mp-overlay" id="mpModalDelete">
    <div class="mp-modal">
        <div class="mp-mheader">
            <span class="mp-mtitle"><i class="fa fa-trash"></i> Hapus Promo</span>
            <button type="button" class="mp-mclose" onclick="mpCloseModal('mpModalDelete')">&times;</button>
        </div>
        <div class="mp-mbody">
            <div class="mp-micon" style="color:#ef4444;"><i class="fa fa-exclamation-triangle"></i></div>
            <div class="mp-mtext">Hapus promo <strong id="mpDeleteName"></strong>?</div>
            <div class="mp-msub">Tindakan ini permanen dan tidak dapat dibatalkan.</div>
            <form method="POST" id="mpDeleteForm" action="">
                @csrf @method('DELETE')
                <div class="mp-mfooter">
                    <button type="button" class="btn-mcancel" onclick="mpCloseModal('mpModalDelete')">Batal</button>
                    <button type="submit" class="btn-mok danger"><i class="fa fa-trash"></i> Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var mpSearchTimer;

function mpSetFilter(val) {
    document.getElementById('mpStatusHidden').value = val;
    document.getElementById('mpFilterForm').submit();
}
function mpGoFilter(val) {
    document.getElementById('mpStatusHidden').value = val;
    document.getElementById('mpFilterForm').submit();
}
function mpOpenDeactivate(id, name) {
    document.getElementById('mpDeactivateForm').action = '/admin/promos/' + id + '/nonaktif';
    document.getElementById('mpDeactivateName').textContent = name;
    document.getElementById('mpModalDeactivate').classList.add('open');
}
function mpOpenDelete(id, name) {
    document.getElementById('mpDeleteForm').action = '/admin/promos/' + id;
    document.getElementById('mpDeleteName').textContent = name;
    document.getElementById('mpModalDelete').classList.add('open');
}
function mpCloseModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.mp-overlay').forEach(function(el) {
    el.addEventListener('click', function(e){ if(e.target===el) mpCloseModal(el.id); });
});
document.addEventListener('keydown', function(e){
    if(e.key==='Escape') ['mpModalDeactivate','mpModalDelete'].forEach(mpCloseModal);
});
</script>

@endsection
