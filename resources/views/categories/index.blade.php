@extends('layouts.app')

@section('title', 'Manajemen Kategori - NusaMart Admin')

@section('content')
<style>
.ck-wrap { max-width:1140px; margin:0 auto; padding:28px 16px 48px; }

.ck-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.ck-page-title  { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.ck-page-title i { color:#D10024; font-size:20px; }
.ck-back-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:background .15s; font-family:inherit; }
.ck-back-btn:hover { background:#e5e7eb; color:#1e1f29; }

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

.ck-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }

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

.ck-alert { display:flex; align-items:center; gap:8px; padding:12px 22px; font-size:13px; }
.ck-alert.success { background:#d1fae5; border-bottom:1px solid #6ee7b7; color:#065f46; }
.ck-alert.error   { background:#fee2e2; border-bottom:1px solid #fca5a5; color:#991b1b; }

.ck-table-wrap { overflow-x:auto; }
.ck-table { width:100%; border-collapse:collapse; font-size:13px; }
.ck-table th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:11px 16px; text-align:left; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.ck-table td { padding:13px 16px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.ck-table tbody tr:last-child td { border-bottom:none; }
.ck-table tbody tr:hover td { background:#fafbfc; }

.cat-cc { display:flex; align-items:center; gap:12px; }
.cat-avatar { width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#D10024,#ff6b6b); display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#fff; font-size:17px; font-weight:800; text-transform:uppercase; box-shadow:0 4px 10px rgba(209,0,36,.2); }
.cat-cn { font-size:14px; font-weight:700; color:#1e1f29; }

.ck-badge { display:inline-block; padding:3px 11px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; }
.ck-badge.has      { background:#ede9fe; color:#5b21b6; }
.ck-badge.none     { background:#f3f4f6; color:#9ca3af; }
.ck-badge.aktif    { background:#d1fae5; color:#065f46; }
.ck-badge.nonaktif { background:#fee2e2; color:#991b1b; }

.ck-date { font-size:12px; color:#9ca3af; }

.ck-actions { display:flex; gap:6px; align-items:center; }
.ck-btn { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border:none; border-radius:7px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; white-space:nowrap; }
.ck-btn.edit { background:#e3f2fd; color:#1565c0; }
.ck-btn.edit:hover { background:#bbdefb; }
.ck-btn.del  { background:#fee2e2; color:#991b1b; }
.ck-btn.del:hover  { background:#fecaca; }
.ck-btn.ton  { background:#d1fae5; color:#065f46; }
.ck-btn.ton:hover  { background:#a7f3d0; }

.ck-empty { text-align:center; padding:64px 24px; }
.ck-empty-icon { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#ffd6d6,#ffefef); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.ck-empty-icon i { font-size:28px; color:#D10024; }
.ck-empty h4 { font-size:15px; font-weight:700; color:#374151; margin:0 0 6px; }
.ck-empty p { font-size:13px; color:#9ca3af; margin:0; }

/* Modals */
.cm-overlay { display:none; position:fixed; inset:0; background:rgba(10,12,20,.55); z-index:9000; justify-content:center; align-items:center; padding:20px; }
.cm-overlay.open { display:flex; }
.cm-modal { background:#fff; border-radius:18px; width:440px; max-width:100%; box-shadow:0 24px 64px rgba(0,0,0,.28); animation:cmSlideIn .22s ease; }
@keyframes cmSlideIn { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
.cm-header { padding:18px 24px 16px; background:linear-gradient(135deg,#1a1f2e 0%,#2d3347 100%); border-radius:18px 18px 0 0; display:flex; align-items:center; justify-content:space-between; }
.cm-title { font-size:15px; font-weight:800; color:#fff; display:flex; align-items:center; gap:8px; }
.cm-title i { color:rgba(255,255,255,.55); }
.cm-close { background:rgba(255,255,255,.12); border:none; font-size:18px; color:#fff; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:8px; transition:background .15s; line-height:1; }
.cm-close:hover { background:rgba(255,255,255,.25); }
.cm-body { padding:20px 24px 24px; }
.cm-field { margin-bottom:16px; }
.cm-field label { display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:7px; text-transform:uppercase; letter-spacing:.4px; }
.cm-field input { width:100%; padding:10px 12px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; outline:none; box-sizing:border-box; transition:border .2s; }
.cm-field input:focus { border-color:#D10024; box-shadow:0 0 0 3px rgba(209,0,36,.08); }
.cm-field .cm-err { font-size:11px; color:#D10024; margin-top:4px; }
.cm-footer { display:flex; justify-content:flex-end; gap:10px; padding-top:4px; }
.btn-cm-save { padding:10px 22px; background:#D10024; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; }
.btn-cm-save:hover { background:#a8001e; }
.btn-cm-cancel { padding:10px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; transition:background .15s; }
.btn-cm-cancel:hover { background:#e5e7eb; }
.del-modal { width:400px; }
.del-icon { text-align:center; padding:8px 0 12px; font-size:44px; color:#D10024; }
.del-text { text-align:center; font-size:14px; color:#333; line-height:1.6; margin-bottom:12px; }
.del-sub  { text-align:left; font-size:12px; color:#aaa; }
.del-warn { display:flex; gap:10px; align-items:flex-start; background:#fffbeb; border:1px solid #fde68a; border-radius:10px; padding:12px 14px; color:#78350f; font-size:13px; line-height:1.5; }
.del-warn i { color:#d97706; font-size:16px; flex-shrink:0; margin-top:1px; }
.del-hint { margin-top:10px; text-align:center; font-size:12px; color:#aaa; }
</style>

<div class="ck-wrap">

    <div class="ck-page-header">
        <h1 class="ck-page-title"><i class="fa fa-tags"></i> Manajemen Kategori</h1>
        <a href="{{ route('dashboard') }}" class="ck-back-btn"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>

    {{-- Stats --}}
    <div class="ck-stats">
        <div class="ck-stat">
            <div class="ck-si red"><i class="fa fa-tags"></i></div>
            <div><div class="ck-sv">{{ $stats['total'] }}</div><div class="ck-sl">Total Kategori</div></div>
        </div>
        <div class="ck-stat">
            <div class="ck-si green"><i class="fa fa-check-circle"></i></div>
            <div><div class="ck-sv">{{ $stats['with_products'] }}</div><div class="ck-sl">Digunakan</div></div>
        </div>
        <div class="ck-stat">
            <div class="ck-si grey"><i class="fa fa-ban"></i></div>
            <div><div class="ck-sv">{{ $stats['empty'] }}</div><div class="ck-sl">Kosong</div></div>
        </div>
        <div class="ck-stat">
            <div class="ck-si blue"><i class="fa fa-box"></i></div>
            <div><div class="ck-sv">{{ $stats['total_products'] }}</div><div class="ck-sl">Total Produk</div></div>
        </div>
    </div>

    <div class="ck-card">

        {{-- Toolbar --}}
        <div class="ck-toolbar">
            <form method="GET" action="{{ route('admin.categories') }}" id="searchForm" style="display:contents">
                <div class="ck-search">
                    <i class="fa fa-search"></i>
                    <input type="text" name="search" id="searchInput"
                        value="{{ request('search') }}"
                        placeholder="Cari nama kategori..."
                        onkeydown="if(event.key==='Enter'){document.getElementById('searchForm').submit()}">
                </div>
            </form>
            <div class="ck-filters">
                <a href="{{ route('admin.categories', ['status' => 'active'] + request()->except('status','page')) }}"   class="ck-fbtn {{ $filter === 'active'   ? 'active' : '' }}">Aktif</a>
                <a href="{{ route('admin.categories', ['status' => 'inactive'] + request()->except('status','page')) }}" class="ck-fbtn {{ $filter === 'inactive' ? 'active' : '' }}"><i class="fa fa-ban" style="font-size:10px"></i> Nonaktif</a>
                <a href="{{ route('admin.categories', ['status' => 'all'] + request()->except('status','page')) }}"      class="ck-fbtn {{ $filter === 'all'      ? 'active' : '' }}">Semua</a>
            </div>
            <button type="button" class="ck-addbtn" onclick="openAddModal()">
                <i class="fa fa-plus"></i> Tambah Kategori
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
            @if($categories->isEmpty())
                <div class="ck-empty">
                    <div class="ck-empty-icon"><i class="fa fa-tags"></i></div>
                    <h4>Belum Ada Kategori</h4>
                    <p>Klik <strong>Tambah Kategori</strong> untuk menambahkan kategori pertama.</p>
                </div>
            @else
            <table class="ck-table">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>
                            <div class="cat-cc">
                                <div class="cat-avatar" style="{{ !$category->is_active ? 'background:linear-gradient(135deg,#9ca3af,#d1d5db);box-shadow:none' : '' }}">{{ mb_substr($category->name, 0, 1) }}</div>
                                <div class="cat-cn" style="{{ !$category->is_active ? 'color:#9ca3af' : '' }}">{{ $category->name }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="ck-badge {{ $category->products_count > 0 ? 'has' : 'none' }}">
                                <i class="fa fa-box" style="font-size:10px"></i>
                                {{ $category->products_count }} produk
                            </span>
                        </td>
                        <td>
                            <span class="ck-badge {{ $category->is_active ? 'aktif' : 'nonaktif' }}">
                                {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td><span class="ck-date">{{ $category->created_at->format('d M Y') }}</span></td>
                        <td>
                            <div class="ck-actions">
                                @if($category->is_active)
                                <button class="ck-btn edit" onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->name) }}')">
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                                <button class="ck-btn del" onclick="openDelModal({{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->active_products_count ?? 0 }})">
                                    <i class="fa fa-ban"></i>
                                </button>
                                @else
                                <form method="POST" action="{{ route('admin.categories.toggle', $category) }}" style="display:inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="ck-btn ton">
                                        <i class="fa fa-check-circle"></i> Aktifkan
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($categories->hasPages())
            <div style="padding:16px 22px; border-top:1px solid #f2f2f5; display:flex; justify-content:center;">
                {{ $categories->links() }}
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="cm-overlay" id="addModal">
    <div class="cm-modal">
        <div class="cm-header">
            <div class="cm-title"><i class="fa fa-plus-circle"></i> Tambah Kategori</div>
            <button class="cm-close" onclick="closeModal('addModal')">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="cm-body">
                <div class="cm-field">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Elektronik" autofocus required>
                    @error('name')<div class="cm-err">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="cm-footer">
                <button type="button" class="btn-cm-cancel" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn-cm-save"><i class="fa fa-check"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="cm-overlay" id="editModal">
    <div class="cm-modal">
        <div class="cm-header">
            <div class="cm-title"><i class="fa fa-pencil"></i> Edit Kategori</div>
            <button class="cm-close" onclick="closeModal('editModal')">&times;</button>
        </div>
        <form method="POST" id="editForm" action="">
            @csrf
            @method('PUT')
            <div class="cm-body">
                <div class="cm-field">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" id="editName" placeholder="Nama kategori" required>
                </div>
            </div>
            <div class="cm-footer">
                <button type="button" class="btn-cm-cancel" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn-cm-save"><i class="fa fa-check"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<div class="cm-overlay" id="delModal">
    <div class="cm-modal del-modal">
        <div class="cm-header">
            <div class="cm-title"><i class="fa fa-ban"></i> Nonaktifkan Kategori</div>
            <button class="cm-close" onclick="closeModal('delModal')">&times;</button>
        </div>
        <form method="POST" id="delForm" action="">
            @csrf
            @method('DELETE')
            <div class="cm-body">
                <div class="del-icon"><i class="fa fa-ban"></i></div>
                <div class="del-text">Nonaktifkan kategori <strong id="delName"></strong>?</div>
                <div id="delWarn"></div>
                <div class="del-sub" id="delSub"></div>
            </div>
            <div class="cm-footer">
                <button type="button" class="btn-cm-cancel" onclick="closeModal('delModal')">Batal</button>
                <button type="submit" class="btn-cm-save" id="delConfirmBtn" style="background:#6b7280"><i class="fa fa-ban"></i> Nonaktifkan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() { document.getElementById('addModal').classList.add('open'); }

function openEditModal(id, name) {
    document.getElementById('editName').value = name;
    document.getElementById('editForm').action = '/admin/categories/' + id;
    document.getElementById('editModal').classList.add('open');
}

function openDelModal(id, name, activeProducts) {
    document.getElementById('delName').textContent = name;
    var warnEl = document.getElementById('delWarn');
    var subEl  = document.getElementById('delSub');
    if (activeProducts > 0) {
        warnEl.innerHTML = '<div class="del-warn"><i class="fa fa-exclamation-triangle"></i><div><strong>' + activeProducts + ' produk aktif</strong> ada dalam kategori ini. Produk-produk tersebut tidak akan muncul di toko setelah kategori dinonaktifkan.</div></div>';
        subEl.innerHTML  = '<div class="del-hint">Kategori dapat diaktifkan kembali kapan saja.</div>';
    } else {
        warnEl.innerHTML = '';
        subEl.innerHTML  = '<div class="del-hint">Kategori akan dinonaktifkan dan tidak muncul di toko. Dapat diaktifkan kembali.</div>';
    }
    document.getElementById('delConfirmBtn').disabled = false;
    document.getElementById('delConfirmBtn').style.opacity = '1';
    document.getElementById('delForm').action = '/admin/categories/' + id;
    document.getElementById('delModal').classList.add('open');
}

function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.cm-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) { if (e.target === el) closeModal(el.id); });
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') document.querySelectorAll('.cm-overlay.open').forEach(function(el) { closeModal(el.id); });
});

function ckSetFilter(val) {
    var rows = document.querySelectorAll('.ck-table tbody tr');
    rows.forEach(function(r) {
        r.style.display = (!val || r.dataset.filter === val) ? '' : 'none';
    });
    document.querySelectorAll('.ck-fbtn').forEach(function(b) { b.classList.remove('active'); });
    var map = {'': 'ckFAll', 'used': 'ckFUsed', 'empty': 'ckFEmpty'};
    if (map[val]) document.getElementById(map[val]).classList.add('active');
}

@if($errors->has('name') && !old('_method'))
document.getElementById('addModal').classList.add('open');
@endif
</script>
@endsection

