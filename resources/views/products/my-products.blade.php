@extends('layouts.seller')

@section('title', 'Produk Saya - Seller Center NusaMart')

@section('breadcrumb')Produk / <strong>Daftar Produk</strong>@endsection

@section('content')

@push('styles')
<style>
/* â”€â”€â”€ Container â”€â”€â”€ */
.my-products-container { max-width:100%; }

/* â”€â”€â”€ Header â”€â”€â”€ */
.my-products-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:18px; }

/* â”€â”€â”€ Filter bar card â”€â”€â”€ */
.mp-filter-card { display:flex; gap:10px; align-items:center; flex-wrap:wrap; background:#fff; border-radius:12px; padding:14px 18px; box-shadow:0 2px 8px rgba(0,0,0,.05); margin-bottom:18px; }
.mp-search { display:flex; align-items:center; flex:1; min-width:180px; border:1.5px solid #e5e7eb; border-radius:8px; overflow:hidden; transition:border .2s; }
.mp-search:focus-within { border-color:#D10024; }
.mp-search i { padding:0 10px; color:#aaa; font-size:14px; }
.search-input { flex:1; border:none; outline:none; padding:9px 0; font-size:13px; background:transparent; font-family:inherit; }
.filter-status { padding:9px 14px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; outline:none; cursor:pointer; background:#fff; min-width:140px; transition:border .2s; font-family:inherit; }
.filter-status:focus { border-color:#D10024; }
.view-toggle { display:flex; gap:6px; }
.view-btn { padding:8px 12px; border:1.5px solid #e5e7eb; background:#fff; border-radius:8px; cursor:pointer; font-size:12px; font-weight:700; color:#666; transition:all .2s; font-family:inherit; display:flex; align-items:center; gap:5px; }
.view-btn.active { background:#D10024; color:#fff; border-color:#D10024; }

/* â”€â”€â”€ Product grid â”€â”€â”€ */
.products-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:16px; margin-bottom:24px; }

/* â”€â”€â”€ Product card â”€â”€â”€ */
.product-card { background:#fff; border:none; border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.06); transition:box-shadow .2s, transform .15s; }
.product-card:hover { box-shadow:0 6px 20px rgba(0,0,0,.1); transform:translateY(-2px); }
.product-image-wrapper { position:relative; width:100%; height:190px; background:#f4f5f7; overflow:hidden; }
.product-image { width:100%; height:100%; object-fit:cover; }
.product-status-badge { position:absolute; top:10px; right:10px; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; background:#d1fae5; color:#065f46; }
.product-status-badge.pending { background:#fee2e2; color:#991b1b; }
.product-info { padding:14px; }
.product-name { font-size:13px; font-weight:700; color:#1e1f29; margin:0 0 4px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.product-category { font-size:11px; color:#aaa; margin:0 0 8px; text-transform:uppercase; letter-spacing:.5px; }
.product-price { font-size:15px; font-weight:800; color:#D10024; margin-bottom:6px; }
.product-stock { font-size:12px; color:#666; margin-bottom:12px; }
.product-actions { display:flex; flex-direction:column; gap:6px; }
.action-group { display:flex; gap:8px; }
.action-btn { flex:1; padding:8px 10px; border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; transition:background .15s; display:flex; align-items:center; justify-content:center; gap:5px; font-family:inherit; text-decoration:none; }
.action-btn-primary { background:#dbeafe; color:#1e40af; }
.action-btn-primary:hover { background:#bfdbfe; color:#1e40af; }
.action-btn-danger { background:#fee2e2; color:#991b1b; }
.action-btn-danger:hover { background:#fecaca; }

/* â”€â”€â”€ List view â”€â”€â”€ */
.products-list { display:flex; flex-direction:column; gap:10px; }
.product-card.list-view { display:flex; align-items:center; gap:14px; }
.product-card.list-view .product-image-wrapper { width:90px; height:90px; min-width:90px; border-radius:8px; }
.product-card.list-view .product-info { flex:1; padding:10px 0; }

/* â”€â”€â”€ Empty state â”€â”€â”€ */
.empty-state { text-align:center; padding:60px 20px; background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.05); }
.empty-state-icon { font-size:48px; color:#e5e7eb; margin-bottom:14px; }
.empty-state-text { color:#aaa; font-size:13px; margin:0; }

/* â”€â”€â”€ Modals â”€â”€â”€ */
.modal { display:none; position:fixed; z-index:2000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,.55); animation:mpFadeIn .25s; }
.modal.show, .modal.active { display:flex; align-items:center; justify-content:center; }
@keyframes mpFadeIn { from{opacity:0} to{opacity:1} }
@keyframes mpSlideDown { from{transform:translateY(-40px);opacity:0} to{transform:translateY(0);opacity:1} }
.modal-content { background:#fff; padding:28px; border-radius:14px; width:90%; max-width:560px; max-height:90vh; overflow-y:auto; box-shadow:0 12px 40px rgba(0,0,0,.2); animation:mpSlideDown .3s; }
#addProductModal .modal-content { max-width:620px; }
.modal-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; padding-bottom:14px; border-bottom:1px solid #f0f0f0; }
.modal-header h2 { margin:0; font-size:17px; font-weight:800; color:#1e1f29; }
.modal-close { background:none; border:none; font-size:24px; cursor:pointer; color:#aaa; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:6px; transition:background .15s; }
.modal-close:hover { background:#f4f5f7; color:#333; }
.modal-footer { display:flex; gap:10px; margin-top:20px; padding-top:16px; border-top:1px solid #f0f0f0; }

/* â”€â”€â”€ Form â”€â”€â”€ */
.form-group { margin-bottom:14px; }
.form-label { display:block; margin-bottom:5px; font-size:12px; font-weight:700; color:#555; }
.form-control { width:100%; padding:10px 12px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; box-sizing:border-box; transition:border .2s; }
.form-control:focus { outline:none; border-color:#D10024; box-shadow:0 0 0 3px rgba(209,0,36,.08); }
.form-control-checkbox { width:auto; margin-right:8px; accent-color:#D10024; }
.checkbox-label { display:flex; align-items:center; font-size:13px; color:#444; cursor:pointer; }

/* â”€â”€â”€ Photo section â”€â”€â”€ */
.photo-section { background:#f8f9fb; padding:14px; border-radius:10px; margin-bottom:16px; }
.current-photo { width:100%; height:140px; background:#e9ecef; border-radius:8px; overflow:hidden; display:flex; align-items:center; justify-content:center; margin-bottom:10px; }
.current-photo img { width:100%; height:100%; object-fit:cover; }
.photo-actions-group { display:flex; gap:8px; }

/* â”€â”€â”€ Buttons â”€â”€â”€ */
.btn { padding:10px 16px; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; gap:6px; font-family:inherit; }
.btn-upload { background:#3b82f6; color:#fff; flex:1; }
.btn-upload:hover { background:#2563eb; }
.btn-delete-photo { background:#fee2e2; color:#991b1b; flex:1; }
.btn-delete-photo:hover { background:#fecaca; }
.btn-danger { background:#D10024; color:#fff; flex:1; }
.btn-danger:hover { background:#a8001e; }
.btn-secondary { background:#f4f5f7; color:#555; flex:1; border:1.5px solid #e5e7eb; }
.btn-secondary:hover { background:#e5e7eb; }
.btn-primary { background:#D10024; color:#fff; flex:1; }
.btn-primary:hover { background:#a8001e; }

/* â”€â”€â”€ Notifications â”€â”€â”€ */
#notificationContainer { position:fixed; top:20px; right:20px; z-index:9999; max-width:380px; }
.notification { padding:14px 18px; margin-bottom:10px; border-radius:10px; display:flex; align-items:center; gap:10px; box-shadow:0 4px 14px rgba(0,0,0,.12); animation:notifIn .3s; font-size:13px; }
@keyframes notifIn { from{transform:translateX(400px);opacity:0} to{transform:translateX(0);opacity:1} }
@keyframes notifOut { to{transform:translateX(400px);opacity:0} }
.notification.success { background:#d1fae5; color:#065f46; border-left:4px solid #10b981; }
.notification.error { background:#fee2e2; color:#991b1b; border-left:4px solid #ef4444; }
.notification.warning { background:#fef3c7; color:#92400e; border-left:4px solid #f59e0b; }
.notification.info { background:#dbeafe; color:#1e40af; border-left:4px solid #3b82f6; }
.notification.remove { animation:notifOut .3s forwards; }
.notification-icon { flex-shrink:0; font-size:16px; }
.notification-content { flex:1; }
.notification-close { flex-shrink:0; background:none; border:none; font-size:18px; cursor:pointer; color:inherit; opacity:.6; }
.notification-close:hover { opacity:1; }

/* â”€â”€â”€ Confirmation â”€â”€â”€ */
.confirmation-overlay { position:fixed; inset:0; background:rgba(0,0,0,.5); display:flex; align-items:center; justify-content:center; z-index:9998; animation:mpFadeIn .3s; }
.confirmation-modal { background:#fff; border-radius:12px; padding:24px; max-width:360px; width:90%; box-shadow:0 10px 40px rgba(0,0,0,.2); animation:mpSlideDown .3s; }
.confirmation-modal h3 { margin:0 0 10px; font-size:16px; color:#1e1f29; }
.confirmation-modal p { margin:0 0 20px; font-size:13px; color:#666; line-height:1.5; }
.confirmation-buttons { display:flex; gap:8px; justify-content:flex-end; }
.confirmation-btn { padding:9px 16px; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; }
.confirmation-btn-cancel { background:#f4f5f7; color:#555; }
.confirmation-btn-cancel:hover { background:#e5e7eb; }
.confirmation-btn-confirm { background:#D10024; color:#fff; }
.confirmation-btn-confirm:hover { background:#a8001e; }

/* â”€â”€â”€ Pagination â”€â”€â”€ */
.pagination { display:flex; justify-content:center; gap:5px; margin-top:20px; flex-wrap:wrap; }
.pagination a, .pagination span { font-size:12px !important; padding:6px 10px !important; }

/* â”€â”€â”€ Wizard â”€â”€â”€ */
.wizard-stepper { display:flex; justify-content:space-between; margin-bottom:28px; position:relative; }
.wizard-stepper::before { content:''; position:absolute; top:18px; left:0; right:0; height:2px; background:#e5e7eb; z-index:1; }
.wizard-step { flex:1; text-align:center; position:relative; z-index:2; }
.wizard-step-circle { width:36px; height:36px; border-radius:50%; background:#e5e7eb; color:#aaa; display:flex; align-items:center; justify-content:center; margin:0 auto 8px; font-weight:700; font-size:13px; transition:all .3s; }
.wizard-step.active .wizard-step-circle { background:#D10024; color:#fff; }
.wizard-step.completed .wizard-step-circle { background:#10b981; color:#fff; }
.wizard-step-label { font-size:11px; font-weight:700; color:#aaa; }
.wizard-step.active .wizard-step-label { color:#D10024; }
.wizard-step.completed .wizard-step-label { color:#10b981; }
.wizard-content { display:none; }
.wizard-content.active { display:block; }
.wizard-buttons { display:flex; gap:10px; justify-content:flex-end; margin-top:24px; padding-top:16px; border-top:1px solid #f0f0f0; }
.add-product-btn { padding:10px 20px; background:#D10024; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; transition:background .2s; display:inline-flex; align-items:center; gap:8px; font-family:inherit; }
.add-product-btn:hover { background:#a8001e; box-shadow:0 4px 12px rgba(209,0,36,.25); }
.file-input-hidden { display:none; }

@media(max-width:900px) { .products-grid { grid-template-columns:repeat(auto-fill, minmax(180px, 1fr)); } }
@media(max-width:600px) { .products-grid { grid-template-columns:1fr 1fr; gap:12px; } .my-products-header { flex-direction:column; align-items:flex-start; gap:12px; } .mp-filter-card { flex-direction:column; align-items:stretch; } .modal-content { width:95%; padding:20px; } }
</style>
@endpush

{{-- Page Header --}}
<div class="my-products-header">
    <div>
        <h1 style="margin:0 0 3px;font-size:20px;font-weight:800;color:#1e1f29;">Produk Saya</h1>
        <p style="margin:0;font-size:12px;color:#aaa;">Total: <strong>{{ $products->total() }}</strong> produk</p>
    </div>
    <button class="add-product-btn" onclick="openAddProductWizard()">
        <i class="fa fa-plus"></i> Tambah Produk
    </button>
</div>

{{-- Filter bar --}}
<div class="mp-filter-card">
    <form method="GET" style="display:flex;flex:1;gap:10px;flex-wrap:wrap;margin:0;">
        <div class="mp-search">
            <i class="fa fa-search"></i>
            <input type="text" name="search" class="search-input" placeholder="Cari nama produk..." value="{{ request('search') }}">
        </div>
        <select name="status" class="filter-status" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Aktif</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </form>
    <div class="view-toggle">
        <button class="view-btn active" id="gridViewBtn" onclick="toggleView('grid')"><i class="fa fa-th"></i> Grid</button>
        <button class="view-btn" id="listViewBtn" onclick="toggleView('list')"><i class="fa fa-list"></i> List</button>
    </div>
</div>

    @if($products->count() > 0)
        <div class="products-grid" id="productsContainer">
            @foreach($products as $product)
            <div class="product-card" data-product-id="{{ $product->id }}">
                <div class="product-image-wrapper">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}?t={{ time() }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f0f0f0; color: #ccc; font-size: 14px;">
                            Tidak ada foto
                        </div>
                    @endif
                    <span class="product-status-badge {{ $product->is_active ? '' : 'pending' }}">
                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="product-info">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <p class="product-category">{{ $product->category }}</p>

                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="product-stock"><i class="fa fa-archive" style="color:#aaa;margin-right:4px"></i> Stok: <strong>{{ $product->stock }}</strong></div>

                    <div class="product-actions">
                        <div class="action-group">
                            <button class="action-btn action-btn-primary" onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }}, {{ $product->is_active ? 'true' : 'false' }}, '{{ $product->image ? asset('storage/' . $product->image) : '' }}', {{ $product->category_id ?? 'null' }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="action-btn action-btn-danger" onclick="deleteProduct({{ $product->id }})">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div style="text-align: center; margin-top: 30px;">
            {{ $products->render() }}
        </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fa fa-cube"></i></div>
            <p class="empty-state-text">Anda belum memiliki produk</p>
        </div>
    @endif

<!-- Add Product Wizard Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Produk</h2>
            <button class="modal-close" onclick="closeAddProductWizard()">&times;</button>
        </div>

        <!-- Wizard Stepper -->
        <div class="wizard-stepper">
            <div class="wizard-step active" id="step1-indicator">
                <div class="wizard-step-circle">1</div>
                <div class="wizard-step-label">Informasi</div>
            </div>
            <div class="wizard-step" id="step2-indicator">
                <div class="wizard-step-circle">2</div>
                <div class="wizard-step-label">Media</div>
            </div>
            <div class="wizard-step" id="step3-indicator">
                <div class="wizard-step-circle">3</div>
                <div class="wizard-step-label">Harga & Stok</div>
            </div>
            <div class="wizard-step" id="step4-indicator">
                <div class="wizard-step-circle">4</div>
                <div class="wizard-step-label">Preview</div>
            </div>
        </div>

        <form id="addProductForm">
            @csrf

            <!-- Step 1: Informasi Produk -->
            <div class="wizard-content active" id="step1">
                <h3 style="margin-top: 0; margin-bottom: 20px;">Isi Informasi Produk</h3>
                <div class="form-group">
                    <label class="form-label">Nama Produk *</label>
                    <input type="text" id="newProductName" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi Produk</label>
                    <textarea id="newProductDescription" class="form-control" style="min-height: 100px; resize: vertical;"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select id="newProductCategory" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Step 2: Upload Media -->
            <div class="wizard-content" id="step2">
                <h3 style="margin-top: 0; margin-bottom: 20px;">Upload Media</h3>
                <div class="photo-section">
                    <div class="current-photo" id="addProductPhotoPreview" style="margin-bottom: 20px;">
                        <span style="color: #ccc;">Tidak ada foto</span>
                    </div>
                    <button type="button" class="btn btn-upload" onclick="document.getElementById('addProductPhotoInput').click()">
                        <i class="fa fa-upload"></i> Pilih Foto Produk
                    </button>
                    <input type="file" id="addProductPhotoInput" class="file-input-hidden" accept="image/*" onchange="handleAddProductPhotoUpload(this)">
                    <small style="color: #888; display: block; margin-top: 12px;">Format: JPG, PNG, GIF (Max: 2MB)</small>
                </div>
            </div>

            <!-- Step 3: Harga & Stok -->
            <div class="wizard-content" id="step3">
                <h3 style="margin-top: 0; margin-bottom: 20px;">Atur Harga & Stok</h3>
                <div class="form-group">
                    <label class="form-label">Harga (Rp) *</label>
                    <input type="number" id="newProductPrice" class="form-control" min="0" step="1000" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Stok *</label>
                    <input type="number" id="newProductStock" class="form-control" min="0" required>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="newProductStatus" class="form-control-checkbox" checked>
                        <span>Produk Langsung Tersedia (Aktif)</span>
                    </label>
                </div>
            </div>

            <!-- Step 4: Preview -->
            <div class="wizard-content" id="step4">
                <h3 style="margin-top: 0; margin-bottom: 20px;">Preview Produk</h3>
                <div id="previewContent" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;"></div>
                <p style="color: #666; font-size: 13px; margin: 0;">Pastikan semua informasi sudah benar sebelum mempublikasikan produk Anda.</p>
            </div>

            <div class="wizard-buttons">
                <button type="button" class="btn btn-secondary" id="prevBtn" onclick="prevStep()" style="display: none;"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextStep()">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                <button type="button" class="btn btn-primary" id="publishBtn" onclick="publishProduct()" style="display: none; background: #28a745;">
                    <i class="fa fa-check"></i> Publish
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Produk</h2>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>

        <!-- Photo Management Section -->
        <div class="photo-section">
            <label class="form-label">Foto Produk</label>
            <div class="current-photo" id="currentPhotoPreview">
                <span style="color: #ccc;">Tidak ada foto</span>
            </div>
            <div class="photo-actions-group">
                <button type="button" class="btn btn-upload" onclick="document.getElementById('photoUploadInput').click()">
                    <i class="fa fa-upload"></i> Upload Foto
                </button>
                <button type="button" class="btn btn-delete-photo" id="deletePhotoBtn" onclick="deletePhotoModal()" style="display: none;">
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </div>
            <input type="file" id="photoUploadInput" class="file-input-hidden" accept="image/*" onchange="handlePhotoUpload(this)">
            <small style="color: #888; display: block; margin-top: 8px;">Format: JPG, PNG, GIF (Max: 2MB)</small>
        </div>

        <form id="editForm">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama Produk</label>
                <input type="text" id="productName" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select id="productCategory" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" id="productPrice" class="form-control" min="0" step="1000" required>
            </div>

            <div class="form-group">
                <label class="form-label">Jumlah Stok</label>
                <input type="number" id="productStock" class="form-control" min="0" required>
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" id="productStatus" class="form-control-checkbox">
                    <span>Produk Tersedia (Aktif)</span>
                </label>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Notification Container -->
<div id="notificationContainer"></div>

<!-- Confirmation Modal Container -->
<div id="confirmationContainer"></div>

@push('scripts')
<script>
// Confirmation System
function showConfirmation(message, title = 'Konfirmasi', onConfirm = null, onCancel = null) {
    const container = document.getElementById('confirmationContainer');
    const overlay = document.createElement('div');
    overlay.className = 'confirmation-overlay';
    
    overlay.innerHTML = `
        <div class="confirmation-modal">
            <h3>${title}</h3>
            <p>${message}</p>
            <div class="confirmation-buttons">
                <button class="confirmation-btn confirmation-btn-cancel" onclick="this.parentElement.parentElement.parentElement.remove()">Batal</button>
                <button class="confirmation-btn confirmation-btn-confirm" onclick="const overlay = this.parentElement.parentElement.parentElement; overlay.remove(); if (typeof onConfirm === 'function') { onConfirm(); }">Hapus</button>
            </div>
        </div>
    `;
    
    container.appendChild(overlay);
    
    // Attach the callback to the button
    overlay.querySelector('.confirmation-btn-confirm').onclick = function() {
        overlay.remove();
        if (onConfirm) onConfirm();
    };
}

// Notification System
function showNotification(message, type = 'success') {
    const container = document.getElementById('notificationContainer');
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;

    const icons = {
        success: '<i class="fa fa-check"></i>',
        error: '<i class="fa fa-times"></i>',
        warning: '<i class="fa fa-exclamation-triangle"></i>',
        info: '<i class="fa fa-info-circle"></i>'
    };

    notification.innerHTML = `
        <div class="notification-icon">${icons[type] || ''}</div>
        <div class="notification-content">${message}</div>
        <button class="notification-close" onclick="this.parentElement.classList.add('remove'); setTimeout(() => this.parentElement.remove(), 300)">&times;</button>
    `;

    container.appendChild(notification);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.classList.add('remove');
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Helper function to get CSRF token
function getCsrfToken() {
    const token = document.querySelector('input[name="_token"]')?.value || 
                  document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    return token;
}

let currentProductId = null;
let currentPhotoUrl = null;
let photoHasChanged = false;

function openEditModal(productId, name, price, stock, isActive, photoUrl, categoryId) {
    currentProductId = productId;
    currentPhotoUrl = photoUrl;
    photoHasChanged = false;
    
    document.getElementById('productName').value = name;
    document.getElementById('productCategory').value = categoryId || '';
    document.getElementById('productPrice').value = price;
    document.getElementById('productStock').value = stock;
    document.getElementById('productStatus').checked = isActive;
    
    // Update photo preview
    const photoPreview = document.getElementById('currentPhotoPreview');
    const deletePhotoBtn = document.getElementById('deletePhotoBtn');
    
    if (photoUrl) {
        photoPreview.innerHTML = '<img src="' + photoUrl + '" alt="Product">';
        deletePhotoBtn.style.display = 'flex';
    } else {
        photoPreview.innerHTML = '<span style="color: #ccc;">Tidak ada foto</span>';
        deletePhotoBtn.style.display = 'none';
    }
    
    document.getElementById('editModal').classList.add('show');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('show');
    document.getElementById('editForm').reset();
    document.getElementById('photoUploadInput').value = '';
    currentProductId = null;
    currentPhotoUrl = null;
    photoHasChanged = false;
}

function handlePhotoUpload(input) {
    if (!input.files[0]) return;

    const file = input.files[0];
    const maxSize = 2 * 1024 * 1024; // 2MB

    if (file.size > maxSize) {
        showNotification('Ukuran file terlalu besar! Maksimal 2MB', 'error');
        input.value = '';
        return;
    }

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('currentPhotoPreview').innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;">';
        document.getElementById('deletePhotoBtn').style.display = 'flex';
        photoHasChanged = true;
    };
    reader.readAsDataURL(file);
}

function deletePhotoModal() {
    if (!currentPhotoUrl) return;
    
    if (!confirm('Hapus foto produk?')) return;

    const photoPreview = document.getElementById('currentPhotoPreview');
    const deletePhotoBtn = document.getElementById('deletePhotoBtn');
    
    photoPreview.innerHTML = '<span style="color: #ccc;">Tidak ada foto</span>';
    deletePhotoBtn.style.display = 'none';
    document.getElementById('photoUploadInput').value = '';
    currentPhotoUrl = null;
    photoHasChanged = true;
}

document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // First, handle photo upload if changed
    if (photoHasChanged) {
        const fileInput = document.getElementById('photoUploadInput');
        
        if (fileInput.files.length > 0) {
            // Upload new photo
            uploadPhotoToServer(fileInput.files[0], () => {
                saveProductData();
            });
        } else if (currentPhotoUrl === null && currentProductId) {
            // Delete old photo
            deletePhotoFromServer(() => {
                saveProductData();
            });
        } else {
            saveProductData();
        }
    } else {
        saveProductData();
    }
});

function uploadPhotoToServer(file, callback) {
    const formData = new FormData();
    formData.append('image', file);

    fetch(`/produk/${currentProductId}/photo`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update the preview with new image URL
            if (data.image) {
                currentPhotoUrl = data.image;
                document.getElementById('currentPhotoPreview').innerHTML = '<img src="' + data.image + '?t=' + new Date().getTime() + '" alt="Product" style="width: 100%; object-fit: cover; border-radius: 8px;">';
                document.getElementById('deletePhotoBtn').style.display = 'flex';
            }
            if (callback) callback();
        } else {
            showNotification('Error upload foto: ' + (data.message || 'Terjadi kesalahan!'), 'error');
        }
    })
    .catch(error => {
        console.error('uploadPhoto error:', error);
        showNotification('Error upload foto: ' + error.message, 'error');
    });
}

function deletePhotoFromServer(callback) {
    fetch(`/produk/${currentProductId}/photo/hapus`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.json();
    })
    .then(data => {
        if (data.success) {
            if (callback) callback();
        } else {
            showNotification('Error hapus foto: ' + (data.message || 'Terjadi kesalahan!'), 'error');
        }
    })
    .catch(error => {
        console.error('deletePhoto error:', error);
        showNotification('Error hapus foto: ' + error.message, 'error');
    });
}

function saveProductData() {
    const categoryId = document.getElementById('productCategory').value;
    const data = {
        name: document.getElementById('productName').value,
        category_id: categoryId ? parseInt(categoryId) : null,
        price: document.getElementById('productPrice').value,
        stock: document.getElementById('productStock').value,
        is_active: document.getElementById('productStatus').checked
    };

    fetch(`/produk/${currentProductId}/simpan`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        const status = response.status;
        return response.text().then(text => {
            if (!response.ok) throw new Error('HTTP ' + status + ': ' + text.substring(0, 200));
            return JSON.parse(text);
        });
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            
            // Refresh the product card image in the grid
            if (photoHasChanged) {
                const productCard = document.querySelector(`[data-product-id="${currentProductId}"] .product-image`);
                if (productCard) {
                    productCard.src = productCard.src.split('?')[0] + '?t=' + new Date().getTime();
                }
            }
            
            closeEditModal();
        } else {
            showNotification('Error: ' + (data.message || 'Terjadi kesalahan!'), 'error');
        }
    })
    .catch(error => {
        console.error('saveProduct error:', error);
        showNotification('Terjadi kesalahan! ' + error.message, 'error');
    });
}

function deleteProduct(productId) {
    showConfirmation(
        'Tindakan ini tidak dapat dibatalkan!',
        'Apakah Anda yakin ingin menghapus produk ini?',
        function() {
            fetch(`/produk/${productId}/hapus`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('HTTP ' + response.status);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    location.reload();
                } else {
                    showNotification('Error: ' + (data.message || 'Terjadi kesalahan!'), 'error');
                }
            })
            .catch(error => {
                console.error('deleteProduct error:', error);
                showNotification('Terjadi kesalahan! ' + error.message, 'error');
            });
        }
    );
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Wizard State Management
window.wizardState = {
    step: 1,
    data: {
        name: '',
        description: '',
        category: '',
        category_id: '',
        price: '',
        stock: '',
        status: true,
        photo: null,
        photoFile: null
    }
};

// Wizard Functions
window.openAddProductWizard = function() {
    document.getElementById('addProductModal').classList.add('active');
    document.body.style.overflow = 'hidden';
    wizardState.step = 1;
    wizardState.data = {
        name: '',
        description: '',
        category: '',
        category_id: '',
        price: '',
        stock: '',
        status: true, 
        photo: null,
        photoFile: null
    };
    showStep(1);
};

window.closeAddProductWizard = function() {
    document.getElementById('addProductModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    document.getElementById('addProductForm').reset();
    document.getElementById('addProductPhotoPreview').innerHTML = '<span style="color: #ccc;">Tidak ada foto</span>';
};

window.showStep = function(step) {
    // Hide all steps
    document.querySelectorAll('.wizard-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));
    
    // Show current step
    document.getElementById('step' + step).classList.add('active');
    document.getElementById('step' + step + '-indicator').classList.add('active');

    // Update buttons
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const publishBtn = document.getElementById('publishBtn');

    if (step === 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'inline-block';
        publishBtn.style.display = 'none';
    } else if (step < 4) {
        prevBtn.style.display = 'inline-block';
        nextBtn.style.display = 'inline-block';
        publishBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'inline-block';
        nextBtn.style.display = 'none';
        publishBtn.style.display = 'inline-block';
    }

    if (step === 4) {
        generatePreview();
    }
};

window.nextStep = function() {
    if (wizardState.step === 1) {
        const name = document.getElementById('newProductName').value.trim();
        const categorySelect = document.getElementById('newProductCategory');
        const categoryId = categorySelect.value.trim();
        const categoryName = categorySelect.options[categorySelect.selectedIndex]?.text || '';
        if (!name || !categoryId) {
            showNotification('Nama produk dan kategori harus diisi!', 'warning');
            return;
        }
        wizardState.data.name = name;
        wizardState.data.description = document.getElementById('newProductDescription').value.trim();
        wizardState.data.category_id = categoryId;
        wizardState.data.category = categoryName;
    } else if (wizardState.step === 2) {
        // Media step - photo is optional
    } else if (wizardState.step === 3) {
        const price = document.getElementById('newProductPrice').value.trim();
        const stock = document.getElementById('newProductStock').value.trim();
        if (!price || !stock) {
            showNotification('Harga dan stok harus diisi!', 'warning');
            return;
        }
        wizardState.data.price = parseInt(price);
        wizardState.data.stock = parseInt(stock);
        wizardState.data.status = document.getElementById('newProductStatus').checked;
    }

    wizardState.step++;
    if (wizardState.step > 4) wizardState.step = 4;
    showStep(wizardState.step);
};

window.prevStep = function() {
    wizardState.step--;
    if (wizardState.step < 1) wizardState.step = 1;
    showStep(wizardState.step);
};

window.handleAddProductPhotoUpload = function(input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    if (file.size > 2 * 1024 * 1024) {
        showNotification('Ukuran file terlalu besar! Maksimal 2MB', 'error');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('addProductPhotoPreview');
        preview.innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;">';
        wizardState.data.photo = e.target.result;
        wizardState.data.photoFile = file;
    };
    reader.readAsDataURL(file);
};

window.generatePreview = function() {
    const previewContent = document.getElementById('previewContent');
    const price = parseInt(wizardState.data.price) || 0;
    const stock = parseInt(wizardState.data.stock) || 0;

    let html = '<div style="background: white; padding: 15px; border-radius: 8px;">';
    html += '<div style="display: grid; grid-template-columns: 150px 1fr; gap: 15px;">';
    
    if (wizardState.data.photo) {
        html += '<img src="' + wizardState.data.photo + '" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">';
    } else {
        html += '<div style="width: 150px; height: 150px; background: #e0e0e0; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><span style="color: #999;">No Photo</span></div>';
    }

    html += '<div>';
    html += '<h4 style="margin: 0 0 8px 0; color: #333;">' + (wizardState.data.name || 'N/A') + '</h4>';
    html += '<p style="margin: 0 0 8px 0; font-size: 13px; color: #666;">' + (wizardState.data.description || 'Tidak ada deskripsi') + '</p>';
    html += '<p style="margin: 0 0 8px 0; font-size: 12px; color: #999;">Kategori: ' + (wizardState.data.category || '-') + '</p>';
    html += '<p style="margin: 0 0 8px 0; font-size: 14px; font-weight: bold; color: #28a745;">Rp' + price.toLocaleString('id-ID') + '</p>';
    html += '<p style="margin: 0; font-size: 13px; color: #666;">Stok: <strong>' + stock + ' unit</strong> | Status: <strong style="color: ' + (wizardState.data.status ? '#28a745' : '#dc3545') + ';">' + (wizardState.data.status ? 'Aktif' : 'Nonaktif') + '</strong></p>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    previewContent.innerHTML = html;
};

window.publishProduct = function() {
    if (!wizardState.data.name || !wizardState.data.category_id || !wizardState.data.price || !wizardState.data.stock) {
        showNotification('Semua data belum lengkap!', 'warning');
        return;
    }

    const formData = new FormData();
    formData.append('name', wizardState.data.name);
    formData.append('description', wizardState.data.description);
    formData.append('category_id', wizardState.data.category_id);
    formData.append('category', wizardState.data.category);
    formData.append('price', wizardState.data.price);
    formData.append('stock', wizardState.data.stock);
    formData.append('is_active', wizardState.data.status ? 1 : 0);
    if (wizardState.data.photoFile) {
        formData.append('image', wizardState.data.photoFile, 'product.jpg');
    }

    fetch('/produk', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok && response.status !== 422) {
            throw new Error('Server error: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification('Produk berhasil dipublikasikan!', 'success');
            closeAddProductWizard();
            location.reload();
        } else {
            showNotification('Error: ' + (data.message || 'Gagal menyimpan produk'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error: ' + error, 'error');
    });
};

// View Toggle Functions
window.toggleView = function(view) {
    const container = document.getElementById('productsContainer');
    const buttons = document.querySelectorAll('.view-btn');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    if (view === 'grid') {
        container.style.display = 'grid';
        container.style.gridTemplateColumns = 'repeat(auto-fill, minmax(280px, 1fr))';
        container.style.gap = '20px';
        document.querySelectorAll('[data-product-id]').forEach(card => {
            card.style.display = 'flex';
            card.style.flexDirection = 'column';
            card.querySelectorAll('img').forEach(img => {
                img.style.height = '280px';
                img.style.width = '100%';
                img.style.objectFit = 'cover';
            });
        });
    } else if (view === 'list') {
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        container.style.gap = '10px';
        document.querySelectorAll('[data-product-id]').forEach(card => {
            card.style.display = 'grid';
            card.style.gridTemplateColumns = '100px 1fr';
            card.style.gap = '15px';
            card.style.padding = '15px';
            card.style.borderRadius = '8px';
            card.style.backgroundColor = '#fff';
            card.querySelectorAll('img').forEach(img => {
                img.style.height = '100px';
                img.style.width = '100px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '6px';
            });
            card.querySelectorAll('.product-info').forEach(info => {
                info.style.display = 'flex';
                info.style.flexDirection = 'column';
                info.style.justifyContent = 'space-between';
            });
        });
    }
};

// Close wizard modal when clicking outside
document.getElementById('addProductModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddProductWizard();
    }
});
</script>
@endpush

@endsection
