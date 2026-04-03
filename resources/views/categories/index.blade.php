@extends('layouts.app')

@section('title', 'Manajemen Kategori - NusaMart')

@section('content')
<style>
    background: linear-gradient(135deg,#D10024,#ff6b6b);
    color: #fff; border: none; padding: 9px 18px;
    border-radius: 8px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
    transition: opacity .2s; white-space: nowrap; text-decoration: none;
}
.btn-cat-add:hover { opacity: .88; color: #fff; }
.btn-back {
    background: #f5f5f5; color: #555; border: none; padding: 9px 16px;
    border-radius: 8px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
    transition: background .2s; white-space: nowrap; text-decoration: none;
}
.btn-back:hover { background: #e0e0e0; color: #333; }
.btn-cat-action { border:none; cursor:pointer; font-size:11px; font-weight:600; padding:5px 12px; border-radius:20px; transition:all .2s; text-transform:uppercase; letter-spacing:.5px; }
.btn-cat-edit { background:#e3f2fd; color:#2196f3; }
.btn-cat-edit:hover { background:#2196f3; color:#fff; }
.btn-cat-delete { background:#fce4ec; color:#D10024; }
.btn-cat-delete:hover { background:#D10024; color:#fff; }
.badge-product-count { background:#f5f5f5; color:#555; font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px; }
.modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.5); z-index:9999; justify-content:center; align-items:center; }
.modal-overlay.active { display:flex; }
.modal-box { background:#fff; border-radius:12px; width:420px; max-width:90vw; position:relative; box-shadow:0 20px 60px rgba(0,0,0,.3); animation:modalIn .25s ease; }
@keyframes modalIn { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
.modal-header { padding:20px 24px 14px; border-bottom:1px solid #f0f0f0; display:flex; justify-content:space-between; align-items:center; }
.modal-header h4 { margin:0; font-size:16px; font-weight:700; color:#1e1f29; }
.modal-close { background:none; border:none; font-size:22px; color:#aaa; cursor:pointer; line-height:1; }
.modal-close:hover { color:#D10024; }
.modal-body { padding:20px 24px 24px; }
.form-group { margin-bottom:16px; }
.form-group label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
.form-group input { width:100%; padding:9px 12px; border:1.5px solid #e0e0e0; border-radius:8px; font-size:14px; transition:border .2s; box-sizing:border-box; }
.form-group input:focus { outline:none; border-color:#D10024; }
.btn-submit { background:#D10024; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; width:100%; transition:background .2s; }
.btn-submit:hover { background:#b0001e; }
th[data-sort-col] { cursor:pointer; user-select:none; white-space:nowrap; }
th[data-sort-col]:hover { background:rgba(209,0,36,.06); }
</style>

<!-- Table -->
<section class="orders-section" style="padding-top:24px">
    <div class="container">
        <div class="orders-card">
            <div class="card-header">
                <h3><i class="fa fa-tags"></i> Daftar Kategori</h3>
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
                    <input type="text" id="searchInput" placeholder="Cari kategori..."
                        style="padding:8px 14px;border:1.5px solid #e0e0e0;border-radius:8px;font-size:13px;outline:none;width:200px;transition:border .2s"
                        value="{{ request('search') }}"
                        onfocus="this.style.borderColor='#D10024'" onblur="this.style.borderColor='#e0e0e0'"
                        onkeydown="if(event.key==='Enter'){searchCategories()}">
                    <button onclick="searchCategories()" style="padding:8px 14px;background:#D10024;color:#fff;border:none;border-radius:8px;font-size:13px;cursor:pointer"><i class="fa fa-search"></i></button>
                    <button class="btn-cat-add" onclick="openAddModal()">
                        <i class="fa fa-plus"></i> Tambah Kategori
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn-back">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            @if(session('success'))
            <div style="margin:16px 20px 0;padding:12px 16px;background:#e8f5e9;border-left:4px solid #27ae60;border-radius:8px;color:#27ae60;font-size:13px;font-weight:600">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div style="margin:16px 20px 0;padding:12px 16px;background:#fce4ec;border-left:4px solid #D10024;border-radius:8px;color:#D10024;font-size:13px;font-weight:600">
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
            </div>
            @endif

            <div class="table-responsive">
                <table style="width:100%;border-collapse:collapse" id="categoryTable">
                    <thead>
                        <tr style="background:#f9f9f9;border-bottom:2px solid #f0f0f0">
                            <th style="padding:14px 20px;text-align:left;font-size:12px;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.5px">#</th>
                            <th style="padding:14px 20px;text-align:left;font-size:12px;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.5px" data-sort-col>Nama Kategori</th>
                            <th style="padding:14px 20px;text-align:center;font-size:12px;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.5px">Jumlah Produk</th>
                            <th style="padding:14px 20px;text-align:center;font-size:12px;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.5px">Dibuat</th>
                            <th style="padding:14px 20px;text-align:center;font-size:12px;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.5px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr class="cat-row" style="border-bottom:1px solid #f5f5f5;transition:background .15s" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''" data-name="{{ strtolower($category->name) }}">
                            <td style="padding:14px 20px;font-size:13px;color:#bbb;font-weight:600">{{ $categories->firstItem() + $loop->index }}</td>
                            <td style="padding:14px 20px">
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#D10024,#ff6b6b);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                        <i class="fa fa-tag" style="color:#fff;font-size:14px"></i>
                                    </div>
                                    <span style="font-size:14px;font-weight:700;color:#1e1f29">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td style="padding:14px 20px;text-align:center">
                                <span class="badge-product-count">{{ $category->products_count }} produk</span>
                            </td>
                            <td style="padding:14px 20px;text-align:center;font-size:13px;color:#8d8d8d">
                                {{ $category->created_at->format('d M Y') }}
                            </td>
                            <td style="padding:14px 20px;text-align:center">
                                <button class="btn-cat-action btn-cat-edit" onclick='openEditModal({{ $category->id }}, "{{ addslashes($category->name) }}")'>
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                                @if($category->products_count === 0)
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:inline" onsubmit="return confirm('Hapus kategori {{ addslashes($category->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-cat-action btn-cat-delete">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>
                                @else
                                <button class="btn-cat-action btn-cat-delete" disabled style="opacity:.4;cursor:not-allowed" title="Tidak bisa dihapus, masih ada produk">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding:48px;text-align:center;color:#aaa">
                                <i class="fa fa-tags" style="font-size:40px;display:block;margin-bottom:12px;color:#e0e0e0"></i>
                                <div style="font-size:14px;font-weight:600;color:#bbb">Belum ada kategori. Tambahkan kategori pertama!</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($categories->hasPages())
            <div style="padding:16px 20px;display:flex;justify-content:center">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Modal Tambah -->
<div class="modal-overlay" id="addModal">
    <div class="modal-box">
        <div class="modal-header">
            <h4><i class="fa fa-plus-circle" style="color:#D10024;margin-right:8px"></i>Tambah Kategori</h4>
            <button class="modal-close" onclick="closeModal('addModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" placeholder="Contoh: Elektronik" required autofocus>
                    @error('name')<span style="color:#D10024;font-size:12px">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-submit"><i class="fa fa-save"></i> Simpan</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <div class="modal-header">
            <h4><i class="fa fa-pencil" style="color:#2196f3;margin-right:8px"></i>Edit Kategori</h4>
            <button class="modal-close" onclick="closeModal('editModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="" id="editForm">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                <button type="submit" class="btn-submit" style="background:#2196f3"><i class="fa fa-save"></i> Perbarui</button>
            </form>
        </div>
    </div>
</div>

<script>
function openAddModal() { document.getElementById('addModal').classList.add('active'); }
function openEditModal(id, name) {
    document.getElementById('editName').value = name;
    document.getElementById('editForm').action = '/admin/categories/' + id;
    document.getElementById('editModal').classList.add('active');
}
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) { if (e.target === overlay) overlay.classList.remove('active'); });
});
function filterTable() {
    // search is now server-side
}
function searchCategories() {
    var val = document.getElementById('searchInput').value;
    var url = new URL(window.location.href);
    url.searchParams.set('search', val);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
@if($errors->has('name'))
document.getElementById('addModal').classList.add('active');
@endif
</script>
@endsection
