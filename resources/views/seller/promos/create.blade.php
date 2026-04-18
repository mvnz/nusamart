@extends('layouts.seller')

@section('title', 'Buat Promo - Seller Center NusaMart')

@section('breadcrumb')Promo / <strong>Buat Promo</strong>@endsection

@section('content')

<style>
/* ===================== STEP WIZARD ===================== */
.wizard-wrap { max-width: 820px; margin: 0 auto; }

.step-bar {
    display: flex; align-items: center; margin-bottom: 32px;
    background: #fff; border-radius: 12px; padding: 20px 28px;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
}
.step-item { display: flex; align-items: center; flex: 1; position: relative; }
.step-item:not(:last-child)::after {
    content: ''; flex: 1; height: 2px; background: #e5e7eb;
    margin: 0 10px; transition: background .3s;
}
.step-item.done:not(:last-child)::after { background: #D10024; }
.step-circle {
    width: 36px; height: 36px; border-radius: 50%; border: 2px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 800; background: #fff; color: #aaa;
    flex-shrink: 0; transition: all .3s; position: relative; z-index: 1;
}
.step-item.active .step-circle { border-color: #D10024; background: #D10024; color: #fff; }
.step-item.done .step-circle { border-color: #D10024; background: #D10024; color: #fff; }
.step-item.done .step-circle::after { content: '\f00c'; font-family: FontAwesome; }
.step-label { margin-left: 10px; }
.step-label-title { font-size: 13px; font-weight: 700; color: #aaa; transition: color .3s; }
.step-item.active .step-label-title,
.step-item.done .step-label-title { color: #1e1f29; }
.step-label-sub { font-size: 11px; color: #bbb; margin-top: 1px; }

/* ===================== CARD ===================== */
.wizard-card {
    background: #fff; border-radius: 12px; padding: 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,.08); margin-bottom: 16px;
}
.wizard-card-title { font-size: 18px; font-weight: 800; color: #1e1f29; margin-bottom: 6px; }
.wizard-card-subtitle { font-size: 13px; color: #aaa; margin-bottom: 24px; }

/* ===================== FORM ELEMENTS ===================== */
.form-group { margin-bottom: 20px; }
.form-label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 13px; }
.form-control {
    width: 100%; padding: 12px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 13px; font-family: inherit; box-sizing: border-box; transition: border .2s;
}
.form-control:focus { outline: none; border-color: #D10024; box-shadow: 0 0 0 3px rgba(209,0,36,.08); }
.form-hint { font-size: 11px; color: #aaa; margin-top: 5px; display: block; }

/* ===================== PRODUCT GRID (step 1) ===================== */
.product-pick-search {
    width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 13px; font-family: inherit; box-sizing: border-box; margin-bottom: 14px;
}
.product-pick-search:focus { outline: none; border-color: #D10024; }
.product-grid-picker {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(150px,1fr));
    gap: 12px; max-height: 420px; overflow-y: auto; padding: 4px;
}
.product-pick-card {
    border: 2px solid #e5e7eb; border-radius: 10px; overflow: hidden; cursor: pointer;
    transition: all .2s; background: #fff; position: relative;
}
.product-pick-card:hover { border-color: #D10024; box-shadow: 0 4px 12px rgba(209,0,36,.12); transform: translateY(-2px); }
.product-pick-card.selected { border-color: #D10024; box-shadow: 0 0 0 3px rgba(209,0,36,.15); }
.product-pick-card.selected::after {
    content: '\f00c'; font-family: FontAwesome;
    position: absolute; top: 8px; right: 8px;
    background: #D10024; color: #fff; width: 22px; height: 22px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; font-size: 11px;
}
.product-pick-img { width: 100%; height: 110px; object-fit: cover; display: block; }
.product-pick-img-placeholder {
    width: 100%; height: 110px; background: #f6f6f6;
    display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 28px;
}
.product-pick-body { padding: 10px; }
.product-pick-name {
    font-size: 12px; font-weight: 700; color: #1e1f29; line-height: 1.3; margin-bottom: 4px;
    overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
}
.product-pick-price { font-size: 12px; font-weight: 800; color: #D10024; }
.product-pick-stock { font-size: 10px; color: #aaa; margin-top: 2px; }
.no-product-msg { text-align: center; padding: 32px; color: #aaa; font-size: 13px; display: none; }
.empty-products { text-align: center; padding: 48px 24px; color: #aaa; }
.empty-products i { font-size: 48px; margin-bottom: 12px; display: block; }

/* ===================== STEP 2: DISCOUNT ===================== */
.price-preview {
    background: #fff8f8; border: 1.5px solid #fbd5d5; border-radius: 10px;
    padding: 16px 20px; margin-top: 12px; display: none;
}
.price-preview-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; font-size: 13px; }
.price-preview-row:not(:last-child) { border-bottom: 1px solid #fbd5d5; }
.price-preview-label { color: #888; }
.price-preview-value { font-weight: 700; color: #1e1f29; }
.price-preview-value.red { color: #D10024; }
.price-preview-value.green { color: #16a34a; }
.discount-hint { background: #fff0f0; border-left: 3px solid #D10024; padding: 10px 14px; border-radius: 4px; font-size: 12px; color: #D10024; margin-top: 12px; display: none; }

.date-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media(max-width: 600px) { .date-row { grid-template-columns: 1fr; } }

/* ===================== STEP 3: KONFIRMASI ===================== */
.confirm-card {
    background: #f8f9fb; border-radius: 10px; overflow: hidden; margin-bottom: 20px;
}
.confirm-product-row {
    display: flex; align-items: center; gap: 16px; padding: 16px 20px;
    background: #fff; border-bottom: 1px solid #f0f0f0;
}
.confirm-product-img { width: 72px; height: 72px; object-fit: cover; border-radius: 8px; background: #f6f6f6; flex-shrink: 0; }
.confirm-product-name { font-size: 15px; font-weight: 800; color: #1e1f29; margin-bottom: 4px; }
.confirm-product-stock { font-size: 12px; color: #aaa; }
.confirm-rows { padding: 4px 0; }
.confirm-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 20px; font-size: 13px; border-bottom: 1px solid #f0f0f0; }
.confirm-row:last-child { border-bottom: none; }
.confirm-row-label { color: #888; display: flex; align-items: center; gap: 8px; }
.confirm-row-label i { width: 16px; text-align: center; }
.confirm-row-value { font-weight: 700; color: #1e1f29; }
.confirm-row-value.badge-discount {
    background: #D10024; color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 12px;
}
.confirm-row-value.badge-saving {
    background: #dcfce7; color: #16a34a; padding: 3px 10px; border-radius: 20px; font-size: 12px;
}
.confirm-notice {
    background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px;
    padding: 14px 16px; font-size: 12px; color: #c2410c; display: flex; gap: 10px; align-items: flex-start;
}

/* ===================== NAVIGATION BUTTONS ===================== */
.wizard-nav {
    display: flex; gap: 12px; justify-content: space-between; align-items: center;
    background: #fff; border-radius: 12px; padding: 20px 28px;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
}
.btn { padding: 11px 24px; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
.btn-primary { background: #D10024; color: #fff; }
.btn-primary:hover { background: #a8001e; }
.btn-secondary { background: #f4f5f7; color: #555; border: 1.5px solid #e5e7eb; }
.btn-secondary:hover { background: #e5e7eb; }
.btn-ghost { background: none; color: #aaa; border: none; font-size: 13px; font-weight: 600; cursor: pointer; padding: 8px 4px; }
.btn-ghost:hover { color: #555; }
.btn-success { background: #16a34a; color: #fff; }
.btn-success:hover { background: #15803d; }

.alert { padding: 14px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 10px; }
.alert-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
</style>

<div class="wizard-wrap">

    {{-- Validation errors (shown back after server-side fail) --}}
    @if($errors->any())
    <div class="alert alert-error" style="margin-bottom:20px;">
        <i class="fa fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ===== STEP BAR ===== --}}
    <div class="step-bar">
        <div class="step-item active" id="stepItem1">
            <div class="step-circle" id="stepCircle1">1</div>
            <div class="step-label">
                <div class="step-label-title">Pilih Produk</div>
                <div class="step-label-sub">Produk yang akan dipromo</div>
            </div>
        </div>
        <div class="step-item" id="stepItem2">
            <div class="step-circle" id="stepCircle2">2</div>
            <div class="step-label">
                <div class="step-label-title">Atur Promo</div>
                <div class="step-label-sub">Diskon, periode & kuota</div>
            </div>
        </div>
        <div class="step-item" id="stepItem3">
            <div class="step-circle" id="stepCircle3">3</div>
            <div class="step-label">
                <div class="step-label-title">Konfirmasi</div>
                <div class="step-label-sub">Periksa & simpan</div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('seller.promos.store') }}" id="promoForm">
        @csrf
        <input type="hidden" name="product_id" id="productIdInput" value="{{ old('product_id', request('product_id')) }}">
        <input type="hidden" name="promo_price" id="promoPriceHidden" value="{{ old('promo_price') }}">

        {{-- ============================= STEP 1 ============================= --}}
        <div id="step1" class="wizard-step">
            <div class="wizard-card">
                <div class="wizard-card-title">Pilih Produk</div>
                <div class="wizard-card-subtitle">Pilih satu produk yang ingin kamu berikan promo harga</div>

                @if($products->isEmpty())
                    <div class="empty-products">
                        <i class="fa fa-box-open"></i>
                        <div style="font-size:15px;font-weight:700;color:#555;margin-bottom:6px;">Belum ada produk</div>
                        <div style="font-size:13px;">Tambahkan produk terlebih dahulu sebelum membuat promo</div>
                    </div>
                @else
                    <input type="text" class="product-pick-search" placeholder="&#xF002; Cari produk..." id="productSearch" oninput="filterProducts()" style="font-family:FontAwesome,Montserrat,sans-serif;">
                    <div class="product-grid-picker" id="productGrid">
                        @foreach($products as $product)
                        <div class="product-pick-card {{ (old('product_id', request('product_id')) == $product->id) ? 'selected' : '' }}"
                             data-id="{{ $product->id }}"
                             data-price="{{ $product->price }}"
                             data-name="{{ $product->name }}"
                             data-image="{{ $product->image ? asset('storage/'.$product->image) : '' }}"
                             data-stock="{{ $product->stock }}"
                             onclick="selectProduct(this)">
                            @if($product->image)
                                <img class="product-pick-img" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="product-pick-img-placeholder"><i class="fa fa-image"></i></div>
                            @endif
                            <div class="product-pick-body">
                                <div class="product-pick-name">{{ $product->name }}</div>
                                <div class="product-pick-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="product-pick-stock">Stok: {{ $product->stock }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="no-product-msg" id="noProductMsg"><i class="fa fa-search"></i> Produk tidak ditemukan</div>
                    <div id="step1Error" style="color:#ef4444;font-size:12px;margin-top:10px;display:none;">
                        <i class="fa fa-exclamation-circle"></i> Pilih produk terlebih dahulu
                    </div>
                @endif
            </div>
        </div>

        {{-- ============================= STEP 2 ============================= --}}
        <div id="step2" class="wizard-step" style="display:none;">
            {{-- Selected product summary bar --}}
            <div style="background:#fff;border-radius:12px;padding:14px 20px;box-shadow:0 2px 12px rgba(0,0,0,.07);margin-bottom:16px;display:flex;align-items:center;gap:14px;">
                <img id="sumImg" src="" alt="" style="width:52px;height:52px;object-fit:cover;border-radius:8px;background:#f6f6f6;">
                <div style="flex:1;min-width:0;">
                    <div id="sumName" style="font-size:14px;font-weight:800;color:#1e1f29;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></div>
                    <div id="sumOrigPrice" style="font-size:12px;color:#888;margin-top:2px;"></div>
                </div>
                <button type="button" onclick="goToStep(1)" style="background:none;border:1.5px solid #e5e7eb;border-radius:8px;padding:6px 14px;font-size:12px;color:#888;cursor:pointer;font-family:inherit;font-weight:600;">
                    <i class="fa fa-pencil"></i> Ganti
                </button>
            </div>

            <div class="wizard-card">
                <div class="wizard-card-title">Atur Promo</div>
                <div class="wizard-card-subtitle">Tentukan besaran diskon, periode, dan kuota pembelian</div>

                <div class="form-group">
                    <label class="form-label">Persentase Diskon (%)</label>
                    <input type="number" id="discountPercent" class="form-control" min="1" max="99" step="1"
                           placeholder="Contoh: 25" value="{{ old('discount_percentage') }}"
                           oninput="updateDiscountInfo()">
                    <span class="form-hint">Masukkan diskon dari 1% hingga 99%</span>
                    <div id="step2DiscountError" style="color:#ef4444;font-size:12px;margin-top:6px;display:none;">
                        <i class="fa fa-exclamation-circle"></i> Diskon harus antara 1% - 99%
                    </div>

                    <div class="price-preview" id="pricePreview">
                        <div class="price-preview-row">
                            <span class="price-preview-label">Harga Normal</span>
                            <span class="price-preview-value">Rp <span id="prevNormal">0</span></span>
                        </div>
                        <div class="price-preview-row">
                            <span class="price-preview-label">Harga Promo</span>
                            <span class="price-preview-value red">Rp <span id="prevPromo">0</span></span>
                        </div>
                        <div class="price-preview-row">
                            <span class="price-preview-label">Pelanggan hemat</span>
                            <span class="price-preview-value green">Rp <span id="prevSaving">0</span></span>
                        </div>
                    </div>
                    <div class="discount-hint" id="discountHint"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Periode Promo</label>
                    <div class="date-row">
                        <div>
                            <label class="form-label" style="font-weight:500;font-size:12px;color:#888;">Mulai</label>
                            <input type="datetime-local" name="start_date" id="startDate" class="form-control"
                                   value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <span style="color:#ef4444;font-size:12px;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label" style="font-weight:500;font-size:12px;color:#888;">Berakhir</label>
                            <input type="datetime-local" name="end_date" id="endDate" class="form-control"
                                   value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <span style="color:#ef4444;font-size:12px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <span class="form-hint">Promo otomatis aktif saat waktu mulai tiba</span>
                    <div id="step2DateError" style="color:#ef4444;font-size:12px;margin-top:6px;display:none;">
                        <i class="fa fa-exclamation-circle"></i> Lengkapi tanggal mulai dan berakhir. Tanggal berakhir harus setelah tanggal mulai.
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Kuota Promo</label>
                    <input type="number" name="quota" id="quota" class="form-control" min="0"
                           placeholder="Contoh: 50" value="{{ old('quota') }}" required
                           oninput="checkQuotaStock()">
                    @error('quota')
                        <span style="color:#ef4444;font-size:12px;">{{ $message }}</span>
                    @enderror
                    <span class="form-hint" id="quotaStockHint">Jumlah maksimal pembelian dengan harga promo. Isi <strong>0</strong> untuk tanpa batas.</span>
                    <div id="step2QuotaError" style="color:#ef4444;font-size:12px;margin-top:6px;display:none;">
                        <i class="fa fa-exclamation-circle"></i> Kuota tidak boleh kosong (isi 0 untuk unlimited)
                    </div>
                    <div id="step2QuotaStockError" style="color:#ef4444;font-size:12px;margin-top:6px;display:none;">
                        <i class="fa fa-exclamation-circle"></i> Kuota melebihi stok produk (<span id="quotaStockMax"></span> unit tersedia)
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================= STEP 3 ============================= --}}
        <div id="step3" class="wizard-step" style="display:none;">
            <div class="wizard-card">
                <div class="wizard-card-title">Konfirmasi Promo</div>
                <div class="wizard-card-subtitle">Periksa kembali detail promo sebelum disimpan</div>

                <div class="confirm-card">
                    {{-- Product row --}}
                    <div class="confirm-product-row">
                        <img id="confImg" src="" alt="" class="confirm-product-img">
                        <div style="flex:1;min-width:0;">
                            <div class="confirm-product-name" id="confName">-</div>
                            <div class="confirm-product-stock" id="confStock">-</div>
                        </div>
                    </div>
                    <div class="confirm-rows">
                        <div class="confirm-row">
                            <span class="confirm-row-label"><i class="fa fa-tag"></i> Harga Normal</span>
                            <span class="confirm-row-value">Rp <span id="confNormal">-</span></span>
                        </div>
                        <div class="confirm-row">
                            <span class="confirm-row-label"><i class="fa fa-percent"></i> Diskon</span>
                            <span class="confirm-row-value"><span class="badge-discount" id="confDiscount">-</span></span>
                        </div>
                        <div class="confirm-row">
                            <span class="confirm-row-label"><i class="fa fa-money"></i> Harga Promo</span>
                            <span class="confirm-row-value red" style="font-size:16px;">Rp <span id="confPromo">-</span></span>
                        </div>
                        <div class="confirm-row">
                            <span class="confirm-row-label"><i class="fa fa-smile-o"></i> Pelanggan hemat</span>
                            <span class="confirm-row-value"><span class="badge-saving" id="confSaving">-</span></span>
                        </div>
                        <div class="confirm-row">
                            <span class="confirm-row-label"><i class="fa fa-calendar"></i> Mulai</span>
                            <span class="confirm-row-value" id="confStart">-</span>
                        </div>
                        <div class="confirm-row">
                            <span class="confirm-row-label"><i class="fa fa-calendar-times-o"></i> Berakhir</span>
                            <span class="confirm-row-value" id="confEnd">-</span>
                        </div>
                        <div class="confirm-row">
                            <span class="confirm-row-label"><i class="fa fa-users"></i> Kuota</span>
                            <span class="confirm-row-value" id="confQuota">-</span>
                        </div>
                    </div>
                </div>

                <div class="confirm-notice">
                    <i class="fa fa-info-circle" style="margin-top:1px;flex-shrink:0;"></i>
                    <div>Promo akan aktif otomatis saat tanggal mulai tiba. Pastikan stok produk cukup sesuai kuota yang ditentukan.</div>
                </div>
            </div>
        </div>

        {{-- ============================= NAVIGATION ============================= --}}
        <div class="wizard-nav">
            <div>
                <a href="{{ route('seller.promos.index') }}" class="btn-ghost"><i class="fa fa-times"></i> Batal</a>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="button" id="btnBack" class="btn btn-secondary" onclick="prevStep()" style="display:none;">
                    <i class="fa fa-arrow-left"></i> Kembali
                </button>
                <button type="button" id="btnNext" class="btn btn-primary" onclick="nextStep()">
                    Lanjut <i class="fa fa-arrow-right"></i>
                </button>
                <button type="submit" id="btnSubmit" class="btn btn-success" style="display:none;">
                    <i class="fa fa-check"></i> Buat Promo
                </button>
            </div>
        </div>

    </form>
</div>

<script>
// ===================== STATE =====================
var currentStep = 1;
var selectedProductId   = null;
var selectedProductPrice = 0;
var selectedProductName  = '';
var selectedProductImage = '';
var selectedProductStock = '';

// ===================== STEP NAV =====================
function goToStep(step) {
    // Hide all steps
    document.getElementById('step1').style.display = 'none';
    document.getElementById('step2').style.display = 'none';
    document.getElementById('step3').style.display = 'none';
    document.getElementById('step' + step).style.display = 'block';

    // Update step bar
    for (var i = 1; i <= 3; i++) {
        var item = document.getElementById('stepItem' + i);
        var circle = document.getElementById('stepCircle' + i);
        item.classList.remove('active', 'done');
        if (i < step) { item.classList.add('done'); circle.innerHTML = ''; }
        else if (i === step) { item.classList.add('active'); circle.textContent = i; }
        else { circle.textContent = i; }
    }

    // Nav buttons
    document.getElementById('btnBack').style.display   = step > 1 ? 'inline-flex' : 'none';
    document.getElementById('btnNext').style.display   = step < 3 ? 'inline-flex' : 'none';
    document.getElementById('btnSubmit').style.display = step === 3 ? 'inline-flex' : 'none';

    currentStep = step;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextStep() {
    if (currentStep === 1) {
        if (!validateStep1()) return;
        populateStep2Summary();
        goToStep(2);
    } else if (currentStep === 2) {
        if (!validateStep2()) return;
        populateStep3Summary();
        goToStep(3);
    }
}

function prevStep() {
    if (currentStep > 1) goToStep(currentStep - 1);
}

// ===================== STEP 1: PRODUCT PICK =====================
function selectProduct(card) {
    document.querySelectorAll('.product-pick-card').forEach(function(c) { c.classList.remove('selected'); });
    card.classList.add('selected');

    selectedProductId    = card.dataset.id;
    selectedProductPrice = parseFloat(card.dataset.price);
    selectedProductName  = card.dataset.name;
    selectedProductImage = card.dataset.image;
    selectedProductStock = card.dataset.stock;

    document.getElementById('productIdInput').value = selectedProductId;
    document.getElementById('step1Error').style.display = 'none';
}

function filterProducts() {
    var q = document.getElementById('productSearch').value.toLowerCase();
    var cards = document.querySelectorAll('.product-pick-card');
    var visible = 0;
    cards.forEach(function(card) {
        var match = !q || card.dataset.name.toLowerCase().includes(q);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('noProductMsg').style.display = visible === 0 ? 'block' : 'none';
}

function validateStep1() {
    if (!selectedProductId) {
        document.getElementById('step1Error').style.display = 'block';
        document.getElementById('productGrid').scrollIntoView({ behavior: 'smooth' });
        return false;
    }
    return true;
}

function populateStep2Summary() {
    var img = document.getElementById('sumImg');
    if (selectedProductImage) { img.src = selectedProductImage; img.style.display = 'block'; }
    else { img.style.display = 'none'; }
    document.getElementById('sumName').textContent = selectedProductName;
    document.getElementById('sumOrigPrice').textContent = 'Harga normal: Rp ' + new Intl.NumberFormat('id-ID').format(selectedProductPrice);
    // Reset discount inputs
    document.getElementById('prevNormal').textContent = new Intl.NumberFormat('id-ID').format(selectedProductPrice);
    updateDiscountInfo();
}

// ===================== STEP 2: DISCOUNT =====================
function updateDiscountInfo() {
    var pct = parseFloat(document.getElementById('discountPercent').value) || 0;
    var preview = document.getElementById('pricePreview');
    var hint    = document.getElementById('discountHint');

    if (selectedProductPrice && pct > 0) {
        var promoPrice = Math.round(selectedProductPrice * (1 - pct / 100));
        var saving     = selectedProductPrice - promoPrice;

        document.getElementById('promoPriceHidden').value = promoPrice;
        document.getElementById('prevNormal').textContent = new Intl.NumberFormat('id-ID').format(selectedProductPrice);
        document.getElementById('prevPromo').textContent  = new Intl.NumberFormat('id-ID').format(promoPrice);
        document.getElementById('prevSaving').textContent = new Intl.NumberFormat('id-ID').format(saving);
        preview.style.display = 'block';

        if (pct >= 100 || promoPrice <= 0) {
            hint.style.display = 'block';
            hint.innerHTML = '<i class="fa fa-exclamation-circle"></i> Diskon terlalu besar — harga promo tidak boleh nol atau negatif';
        } else {
            hint.style.display = 'none';
        }
    } else {
        preview.style.display = 'none';
        hint.style.display = 'none';
    }
}

function checkQuotaStock() {
    var quota = parseInt(document.getElementById('quota').value) || 0;
    var stock = parseInt(selectedProductStock) || 0;
    var errEl = document.getElementById('step2QuotaStockError');
    var spanEl = document.getElementById('quotaMax');
    // quota 0 = unlimited, skip check
    if (quota > 0 && stock > 0 && quota > stock) {
        document.getElementById('quotaStockMax').textContent = stock;
        errEl.style.display = 'block';
    } else {
        errEl.style.display = 'none';
    }
}

function validateStep2() {
    var ok = true;
    var pct = parseFloat(document.getElementById('discountPercent').value) || 0;

    document.getElementById('step2DiscountError').style.display = 'none';
    document.getElementById('step2DateError').style.display = 'none';
    document.getElementById('step2QuotaError').style.display = 'none';
    document.getElementById('step2QuotaStockError').style.display = 'none';

    if (pct <= 0 || pct >= 100) {
        document.getElementById('step2DiscountError').style.display = 'block';
        ok = false;
    }
    var start = document.getElementById('startDate').value;
    var end   = document.getElementById('endDate').value;
    if (!start || !end || new Date(end) <= new Date(start)) {
        document.getElementById('step2DateError').style.display = 'block';
        ok = false;
    }
    var quota = document.getElementById('quota').value;
    if (quota === '' || quota === null) {
        document.getElementById('step2QuotaError').style.display = 'block';
        ok = false;
    } else {
        var quotaNum = parseInt(quota);
        var stock    = parseInt(selectedProductStock) || 0;
        if (quotaNum > 0 && stock > 0 && quotaNum > stock) {
            document.getElementById('quotaStockMax').textContent = stock;
            document.getElementById('step2QuotaStockError').style.display = 'block';
            ok = false;
        }
    }
    return ok;
}

function formatDatetimeLocal(val) {
    if (!val) return '-';
    var d = new Date(val);
    return d.toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' });
}

// ===================== STEP 3: SUMMARY =====================
function populateStep3Summary() {
    var pct       = parseFloat(document.getElementById('discountPercent').value) || 0;
    var promoPrice = Math.round(selectedProductPrice * (1 - pct / 100));
    var saving     = selectedProductPrice - promoPrice;
    var quota     = document.getElementById('quota').value;
    var start     = document.getElementById('startDate').value;
    var end       = document.getElementById('endDate').value;

    var confImg = document.getElementById('confImg');
    if (selectedProductImage) { confImg.src = selectedProductImage; confImg.style.display = 'block'; }
    else { confImg.style.display = 'none'; }

    document.getElementById('confName').textContent    = selectedProductName;
    document.getElementById('confStock').textContent   = 'Stok: ' + selectedProductStock;
    document.getElementById('confNormal').textContent  = new Intl.NumberFormat('id-ID').format(selectedProductPrice);
    document.getElementById('confDiscount').textContent = pct + '%';
    document.getElementById('confPromo').textContent   = new Intl.NumberFormat('id-ID').format(promoPrice);
    document.getElementById('confSaving').textContent  = 'Hemat Rp ' + new Intl.NumberFormat('id-ID').format(saving);
    document.getElementById('confStart').textContent   = formatDatetimeLocal(start);
    document.getElementById('confEnd').textContent     = formatDatetimeLocal(end);
    document.getElementById('confQuota').textContent   = quota == 0 ? 'Tidak terbatas' : quota + ' unit';
}

// ===================== INIT =====================
document.addEventListener('DOMContentLoaded', function() {
    // Restore selection from old() on validation error redirect
    var preId = document.getElementById('productIdInput').value;
    if (preId) {
        var card = document.querySelector('.product-pick-card[data-id="' + preId + '"]');
        if (card) selectProduct(card);
    }
    goToStep(1);
});
</script>

@endsection
