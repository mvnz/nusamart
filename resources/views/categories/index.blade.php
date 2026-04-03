@extends('layouts.app')

@section('title', 'Manajemen Kategori - NusaMart')

@section('content')
<style>
.cat-page { padding: 28px 0 40px; }
.cat-hero { background: linear-gradient(135deg, #1e1f29 0%, #2d2e3e 100%); border-radius: 16px; padding: 28px 32px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
.cat-hero-left h2 { margin: 0 0 4px; font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -.3px; }
.cat-hero-left p { margin: 0; font-size: 13px; color: rgba(255,255,255,.55); }
.cat-hero-stat { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); border-radius: 12px; padding: 14px 24px; text-align: center; }
.cat-hero-stat .stat-num { font-size: 28px; font-weight: 800; color: #fff; line-height: 1; }
.cat-hero-stat .stat-label { font-size: 11px; color: rgba(255,255,255,.5); margin-top: 4px; text-transform: uppercase; letter-spacing: .5px; }
.cat-toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
.cat-search-wrap { display: flex; align-items: center; gap: 8px; }
.cat-search-wrap input { padding: 9px 14px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 13px; outline: none; width: 220px; background: #fff; transition: all .2s; }
.cat-search-wrap input:focus { border-color: #D10024; box-shadow: 0 0 0 3px rgba(209,0,36,.08); }
.btn-search { padding: 9px 14px; background: #D10024; color: #fff; border: none; border-radius: 10px; font-size: 13px; cursor: pointer; transition: background .2s; }
.btn-search:hover { background: #b0001e; }
.btn-add { padding: 9px 18px; background: linear-gradient(135deg, #D10024, #ff4f4f); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: opacity .2s; box-shadow: 0 4px 12px rgba(209,0,36,.3); text-decoration: none; white-space: nowrap; }
.btn-add:hover { opacity: .88; color: #fff; }
.btn-back-link { padding: 9px 16px; background: #f4f4f6; color: #555; border: none; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: background .2s; text-decoration: none; white-space: nowrap; }
.btn-back-link:hover { background: #e8e8ec; color: #333; }
.cat-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,.06); overflow: hidden; }
.cat-table { width: 100%; border-collapse: collapse; }
.cat-table thead tr { background: #fafafa; border-bottom: 2px solid #f0f0f0; }
.cat-table thead th { padding: 13px 20px; font-size: 11px; color: #999; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; text-align: left; }
.cat-table thead th.center { text-align: center; }
.cat-table tbody tr { border-bottom: 1px solid #f5f5f7; transition: background .15s; }
.cat-table tbody tr:hover { background: #fef8f9; }
.cat-table tbody tr:last-child { border-bottom: none; }
.cat-table td { padding: 14px 20px; font-size: 13px; color: #444; vertical-align: middle; }
.cat-table td.center { text-align: center; }
.cat-num { font-size: 12px; color: #ccc; font-weight: 700; }
.cat-name-cell { display: flex; align-items: center; gap: 12px; }
.cat-icon { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #D10024, #ff6b6b); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(209,0,36,.25); }
.cat-icon i { color: #fff; font-size: 15px; }
.cat-name { font-size: 14px; font-weight: 700; color: #1e1f29; }
.badge-count { background: #f0f0f5; color: #666; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px; }
.badge-count.has-items { background: #e8f5e9; color: #27ae60; }
.cat-date { font-size: 12px; color: #aaa; font-weight: 500; }
.btn-edit { border: none; cursor: pointer; font-size: 11px; font-weight: 700; padding: 6px 13px; border-radius: 8px; transition: all .2s; background: #e8f4fd; color: #1a85d3; letter-spacing: .3px; }
.btn-edit:hover { background: #1a85d3; color: #fff; }
.btn-del { border: none; cursor: pointer; font-size: 11px; font-weight: 700; padding: 6px 13px; border-radius: 8px; transition: all .2s; background: #fde8ec; color: #D10024; letter-spacing: .3px; }
.btn-del:hover { background: #D10024; color: #fff; }
.btn-del:disabled { opacity: .35; cursor: not-allowed; }
.cat-empty { padding: 60px 20px; text-align: center; }
.cat-empty-icon { width: 72px; height: 72px; border-radius: 20px; background: linear-gradient(135deg, #f5f5f5, #ebebeb); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
.cat-empty-icon i { font-size: 30px; color: #ccc; }
.cat-empty h5 { margin: 0 0 6px; font-size: 15px; font-weight: 700; color: #aaa; }
.cat-empty p { margin: 0; font-size: 13px; color: #ccc; }
.modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.5); z-index: 9999; justify-content: center; align-items: center; backdrop-filter: blur(2px); }
.modal-overlay.active { display: flex; }
.modal-box { background: #fff; border-radius: 16px; width: 440px; max-width: 92vw; position: relative; box-shadow: 0 24px 64px rgba(0,0,0,.2); animation: modalIn .25s ease; }
@keyframes modalIn { from{opacity:0;transform:translateY(-16px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }
.modal-header { padding: 22px 24px 16px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f0f0f0; }
.modal-header h4 { margin: 0; font-size: 16px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 8px; }
.modal-header .modal-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
.modal-close { background: #f5f5f5; border: none; width: 30px; height: 30px; border-radius: 8px; font-size: 18px; color: #888; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .2s; }
.modal-close:hover { background: #fde8ec; color: #D10024; }
.modal-body { padding: 22px 24px 26px; }
.form-group { margin-bottom: 18px; }
.form-group label { display: block; font-size: 12px; font-weight: 700; color: #888; margin-bottom: 7px; text-transform: uppercase; letter-spacing: .5px; }
.form-group input { width: 100%; padding: 10px 13px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 14px; transition: all .2s; box-sizing: border-box; outline: none; }
.form-group input:focus { border-color: #D10024; box-shadow: 0 0 0 3px rgba(209,0,36,.08); }
.btn-submit { border: none; padding: 11px 24px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; width: 100%; transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-submit-red { background: linear-gradient(135deg, #D10024, #ff4f4f); color: #fff; box-shadow: 0 4px 12px rgba(209,0,36,.3); }
.btn-submit-red:hover { opacity: .9; }
.btn-submit-blue { background: linear-gradient(135deg, #1a85d3, #42a5f5); color: #fff; box-shadow: 0 4px 12px rgba(26,133,211,.3); }
.btn-submit-blue:hover { opacity: .9; }
.alert-success { margin-bottom: 20px; padding: 12px 16px; background: #e8f5e9; border-left: 4px solid #27ae60; border-radius: 10px; color: #27ae60; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.alert-error { margin-bottom: 20px; padding: 12px 16px; background: #fde8ec; border-left: 4px solid #D10024; border-radius: 10px; color: #D10024; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.table-responsive { overflow-x: auto; }
</style>

<div class="cat-page">
<div class="container">

    {{-- Hero Header --}}
    <div class="cat-hero">
        <div class="cat-hero-left">
            <h2><i class="fa fa-tags" style="color:#ff6b6b;margin-right:10px"></i>Manajemen Kategori</h2>
            <p>Kelola semua kategori produk di NusaMart</p>
        </div>
        <div class="cat-hero-stat">
            <div class="stat-num">{{ $categories->total() }}</div>
            <div class="stat-label">Total Kategori</div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session(''success''))
    <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session(''success'') }}</div>
    @endif
    @if(session(''error''))
    <div class="alert-error"><i class="fa fa-exclamation-circle"></i> {{ session(''error'') }}</div>
    @endif

    {{-- Toolbar --}}
    <div class="cat-toolbar">
        <div class="cat-search-wrap">
            <input type="text" id="searchInput" placeholder="Cari kategori..."
                value="{{ request(''search'') }}"
                onkeydown="if(event.key===''Enter''){searchCategories()}">
            <button class="btn-search" onclick="searchCategories()"><i class="fa fa-search"></i></button>
        </div>
        <div style="display:flex;gap:10px;align-items:center">
            <button class="btn-add" onclick="openAddModal()">
                <i class="fa fa-plus"></i> Tambah Kategori
            </button>
            <a href="{{ route(''dashboard'') }}" class="btn-back-link">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="cat-card">
        <div class="table-responsive">
            <table class="cat-table" id="categoryTable">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama Kategori</th>
                        <th class="center">Jumlah Produk</th>
                        <th class="center">Dibuat</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr data-name="{{ strtolower($category->name) }}">
                        <td><span class="cat-num">{{ $categories->firstItem() + $loop->index }}</span></td>
                        <td>
                            <div class="cat-name-cell">
                                <div class="cat-icon"><i class="fa fa-tag"></i></div>
                                <span class="cat-name">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="center">
                            <span class="badge-count {{ $category->products_count > 0 ? ''has-items'' : '''' }}">
                                <i class="fa fa-cube" style="font-size:10px"></i>
                                {{ $category->products_count }} produk
                            </span>
                        </td>
                        <td class="center"><span class="cat-date">{{ $category->created_at->format(''d M Y'') }}</span></td>
                        <td class="center">
                            <div style="display:inline-flex;gap:6px">
                                <button class="btn-edit" onclick=''openEditModal({{ $category->id }}, "{{ addslashes($category->name) }}")''>
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                                @if($category->products_count === 0)
                                <form method="POST" action="{{ route(''admin.categories.destroy'', $category) }}" style="display:inline" onsubmit="return confirm(''Hapus kategori {{ addslashes($category->name) }}?'')">
                                    @csrf @method(''DELETE'')
                                    <button type="submit" class="btn-del"><i class="fa fa-trash"></i> Hapus</button>
                                </form>
                                @else
                                <button class="btn-del" disabled title="Tidak bisa dihapus, masih ada produk"><i class="fa fa-trash"></i> Hapus</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="cat-empty">
                                <div class="cat-empty-icon"><i class="fa fa-tags"></i></div>
                                <h5>Belum ada kategori</h5>
                                <p>Klik "Tambah Kategori" untuk membuat kategori pertama</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div style="padding:16px 24px;border-top:1px solid #f0f0f0;display:flex;justify-content:center">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

</div>
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="addModal">
    <div class="modal-box">
        <div class="modal-header">
            <h4>
                <span class="modal-icon" style="background:#fde8ec"><i class="fa fa-plus" style="color:#D10024;font-size:14px"></i></span>
                Tambah Kategori
            </h4>
            <button class="modal-close" onclick="closeModal(''addModal'')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route(''admin.categories.store'') }}">
                @csrf
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" placeholder="Contoh: Elektronik" required autofocus>
                    @error(''name'')<div style="color:#D10024;font-size:12px;margin-top:4px"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn-submit btn-submit-red"><i class="fa fa-save"></i> Simpan Kategori</button>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <div class="modal-header">
            <h4>
                <span class="modal-icon" style="background:#e8f4fd"><i class="fa fa-pencil" style="color:#1a85d3;font-size:14px"></i></span>
                Edit Kategori
            </h4>
            <button class="modal-close" onclick="closeModal(''editModal'')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="" id="editForm">
                @csrf @method(''PUT'')
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                <button type="submit" class="btn-submit btn-submit-blue"><i class="fa fa-save"></i> Perbarui Kategori</button>
            </form>
        </div>
    </div>
</div>

<script>
function openAddModal() { document.getElementById(''addModal'').classList.add(''active''); }
function openEditModal(id, name) {
    document.getElementById(''editName'').value = name;
    document.getElementById(''editForm'').action = ''/admin/categories/'' + id;
    document.getElementById(''editModal'').classList.add(''active'');
}
function closeModal(id) { document.getElementById(id).classList.remove(''active''); }
document.querySelectorAll(''.modal-overlay'').forEach(function(overlay) {
    overlay.addEventListener(''click'', function(e) { if (e.target === overlay) overlay.classList.remove(''active''); });
});
document.addEventListener(''keydown'', function(e) { if (e.key === ''Escape'') { document.querySelectorAll(''.modal-overlay.active'').forEach(function(m) { m.classList.remove(''active''); }); } });
function searchCategories() {
    var val = document.getElementById(''searchInput'').value;
    var url = new URL(window.location.href);
    url.searchParams.set(''search'', val);
    url.searchParams.delete(''page'');
    window.location.href = url.toString();
}
@if($errors->has(''name''))
document.getElementById(''addModal'').classList.add(''active'');
@endif
</script>
@endsection
