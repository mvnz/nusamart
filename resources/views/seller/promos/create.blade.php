@extends('layouts.seller')

@section('title', 'Buat Promo - Seller Center NusaMart')

@section('breadcrumb')Promo / <strong>Buat Promo</strong>@endsection

@section('content')

<style>
    .form-container { max-width: 800px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .form-title { font-size: 22px; font-weight: 800; margin-bottom: 24px; color: #1e1f29; }
    
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 13px; }
    .form-control { width: 100%; padding: 12px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-family: inherit; box-sizing: border-box; transition: border .2s; }
    .form-control:focus { outline: none; border-color: #D10024; box-shadow: 0 0 0 3px rgba(209,0,36,.08); }

    /* Product Grid Picker */
    .product-grid-picker { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; max-height: 420px; overflow-y: auto; padding: 4px; }
    .product-pick-card {
        border: 2px solid #e5e7eb; border-radius: 10px; overflow: hidden; cursor: pointer;
        transition: all .2s; background: #fff; position: relative;
    }
    .product-pick-card:hover { border-color: #D10024; box-shadow: 0 4px 12px rgba(209,0,36,.1); transform: translateY(-2px); }
    .product-pick-card.selected { border-color: #D10024; box-shadow: 0 0 0 3px rgba(209,0,36,.15); }
    .product-pick-card.selected::after {
        content: '\f00c'; font-family: FontAwesome; position: absolute; top: 8px; right: 8px;
        background: #D10024; color: #fff; width: 22px; height: 22px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 11px;
    }
    .product-pick-img { width: 100%; height: 110px; object-fit: cover; background: #f6f6f6; display: block; }
    .product-pick-img-placeholder { width: 100%; height: 110px; background: #f6f6f6; display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 28px; }
    .product-pick-body { padding: 10px; }
    .product-pick-name { font-size: 12px; font-weight: 700; color: #1e1f29; line-height: 1.3; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .product-pick-price { font-size: 12px; font-weight: 800; color: #D10024; }
    .product-pick-stock { font-size: 10px; color: #aaa; margin-top: 2px; }
    .product-pick-search { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-family: inherit; box-sizing: border-box; margin-bottom: 12px; }
    .product-pick-search:focus { outline: none; border-color: #D10024; }
    .selected-product-info { background: #fff0f0; border: 1.5px solid #D10024; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; display: none; align-items: center; gap: 12px; }
    .selected-product-info img { width: 48px; height: 48px; object-fit: cover; border-radius: 6px; }
    .selected-product-info .sel-name { font-size: 13px; font-weight: 700; color: #1e1f29; }
    .selected-product-info .sel-price { font-size: 12px; color: #D10024; font-weight: 600; }
    .no-product-msg { text-align: center; padding: 32px; color: #aaa; font-size: 13px; display: none; }
    
    .alert { padding: 14px 16px; border-radius: 8px; margin-bottom: 16px; display: flex; gap: 10px; }
    .alert-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
    
    .price-info { background: #f8f9fb; padding: 14px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; color: #666; line-height: 1.6; }
    .price-info-item { margin-bottom: 8px; }
    .price-info-label { font-weight: 600; color: #333; }
    
    .btn-group { display: flex; gap: 12px; margin-top: 28px; }
    .btn { padding: 12px 24px; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all .2s; }
    .btn-primary { background: #D10024; color: #fff; flex: 1; }
    .btn-primary:hover { background: #a8001e; }
    .btn-secondary { background: #f4f5f7; color: #555; border: 1.5px solid #e5e7eb; }
    .btn-secondary:hover { background: #e5e7eb; }
    
    .discount-info { background: #fff0f0; border-left: 4px solid #D10024; padding: 12px 14px; border-radius: 4px; margin-bottom: 16px; font-size: 12px; color: #D10024; }
</style>

<div class="form-container">
    <h1 class="form-title">Buat Promo Produk</h1>

    @if($errors->any())
        <div class="alert alert-error">
            <div style="flex-shrink: 0;">
                <i class="fa fa-exclamation-circle"></i>
            </div>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('seller.promos.store') }}" onsubmit="return validateForm()">
        @csrf

        <div class="form-group">
            <label class="form-label">Pilih Produk *</label>

            {{-- Selected product summary --}}
            <div class="selected-product-info" id="selectedProductInfo">
                <img id="selImg" src="" alt="">
                <div>
                    <div class="sel-name" id="selName"></div>
                    <div class="sel-price" id="selPrice"></div>
                </div>
                <button type="button" onclick="clearProduct()" style="margin-left:auto;background:none;border:none;color:#D10024;cursor:pointer;font-size:18px;line-height:1;">&times;</button>
            </div>

            <input type="text" class="product-pick-search" placeholder="&#xF002; Cari produk..." id="productSearch" oninput="filterProducts()" style="font-family: FontAwesome, Montserrat, sans-serif;">

            <div class="product-grid-picker" id="productGrid">
                @foreach($products as $product)
                <div class="product-pick-card {{ (request('product_id') == $product->id || (isset($productId) && $productId == $product->id)) ? 'selected' : '' }}"
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

            <input type="hidden" name="product_id" id="productIdInput" value="{{ request('product_id') ?? ($productId ?? '') }}" required>
            @error('product_id')
                <span style="color: #ef4444; font-size: 12px; display:block; margin-top:6px;">{{ $message }}</span>
            @enderror
        </div>

        <div id="priceInfo" class="price-info" style="display: none;">
            <div class="price-info-item">
                <span class="price-info-label">Harga Normal:</span> Rp <span id="normalPrice">0</span>
            </div>
            <div class="price-info-item">
                <span class="price-info-label">Harga Promo:</span> Rp <span id="promoPrice">0</span>
            </div>
            <div class="price-info-item">
                <span class="price-info-label">Diskon:</span> <span id="discountPercentDisplay">0</span>%
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Persentase Diskon (%) *</label>
            <input type="number" id="discountPercent" class="form-control" min="1" max="99" step="1" required placeholder="Contoh: 25" onchange="updateDiscountInfo()" oninput="updateDiscountInfo()">
            <input type="hidden" name="promo_price" id="promoPriceHidden">
            @error('promo_price')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
            <small style="color: #aaa; display: block; margin-top: 6px;">Masukkan diskon dari 1% hingga 99%</small>
        </div>

        <div id="discountWarning" class="discount-info" style="display: none;"></div>

        <div class="form-group">
            <label class="form-label">Tanggal Mulai Promo *</label>
            <input type="datetime-local" name="start_date" class="form-control" required>
            @error('start_date')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
            <small style="color: #aaa; display: block; margin-top: 6px;">Promo otomatis aktif saat waktu tiba</small>
        </div>

        <div class="form-group">
            <label class="form-label">Tanggal Berakhir Promo *</label>
            <input type="datetime-local" name="end_date" class="form-control" required>
            @error('end_date')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Kuota Promo *</label>
            <input type="number" name="quota" class="form-control" min="0" required placeholder="Contoh: 50 (masukkan 0 untuk unlimited)">
            @error('quota')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
            <small style="color: #aaa; display: block; margin-top: 6px;">Jumlah produk yang bisa dijual dengan harga promo. 0 = tanpa batas</small>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Buat Promo
            </button>
            <a href="{{ route('seller.promos.index') }}" class="btn btn-secondary" style="text-decoration: none; text-align: center;">
                <i class="fa fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
// --- Product Grid Picker ---
function selectProduct(card) {
    // Deselect all
    document.querySelectorAll('.product-pick-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');

    var id    = card.dataset.id;
    var price = card.dataset.price;
    var name  = card.dataset.name;
    var image = card.dataset.image;

    document.getElementById('productIdInput').value = id;

    // Show summary bar
    var info = document.getElementById('selectedProductInfo');
    info.style.display = 'flex';
    document.getElementById('selName').textContent  = name;
    document.getElementById('selPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
    var selImg = document.getElementById('selImg');
    if (image) { selImg.src = image; selImg.style.display = 'block'; }
    else        { selImg.style.display = 'none'; }

    // Update price info & discount
    document.getElementById('normalPrice').textContent = new Intl.NumberFormat('id-ID').format(price);
    document.getElementById('priceInfo').style.display = 'block';
    updateDiscountInfo();
}

function clearProduct() {
    document.querySelectorAll('.product-pick-card').forEach(c => c.classList.remove('selected'));
    document.getElementById('productIdInput').value = '';
    document.getElementById('selectedProductInfo').style.display = 'none';
    document.getElementById('priceInfo').style.display = 'none';
    document.getElementById('discountWarning').style.display = 'none';
}

function filterProducts() {
    var q = document.getElementById('productSearch').value.toLowerCase();
    var cards = document.querySelectorAll('.product-pick-card');
    var visible = 0;
    cards.forEach(function(card) {
        var name = card.dataset.name.toLowerCase();
        if (!q || name.includes(q)) { card.style.display = ''; visible++; }
        else { card.style.display = 'none'; }
    });
    document.getElementById('noProductMsg').style.display = visible === 0 ? 'block' : 'none';
}

function getSelectedPrice() {
    var selected = document.querySelector('.product-pick-card.selected');
    return selected ? parseFloat(selected.dataset.price) : 0;
}

function updateDiscountInfo() {
    var normalPrice = getSelectedPrice();
    var discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;

    if (normalPrice && discountPercent > 0) {
        var promoPrice = Math.round(normalPrice * (1 - discountPercent / 100));
        var discountNominal = normalPrice - promoPrice;

        document.getElementById('promoPriceHidden').value = promoPrice;
        document.getElementById('promoPrice').textContent = new Intl.NumberFormat('id-ID').format(promoPrice);
        document.getElementById('discountPercentDisplay').textContent = discountPercent;

        var warn = document.getElementById('discountWarning');
        warn.style.display = 'block';
        if (discountPercent >= 100 || promoPrice <= 0) {
            warn.innerHTML = '<i class="fa fa-exclamation-circle"></i> Diskon terlalu besar, harga promo tidak boleh negatif atau nol';
        } else {
            warn.innerHTML = '<i class="fa fa-info-circle"></i> Pelanggan akan membeli Rp ' + new Intl.NumberFormat('id-ID').format(promoPrice) + ' (hemat Rp ' + new Intl.NumberFormat('id-ID').format(discountNominal) + ')';
        }
    } else {
        document.getElementById('discountWarning').style.display = 'none';
    }
}

function validateForm() {
    var productId = document.getElementById('productIdInput').value;
    if (!productId) {
        alert('Pilih produk terlebih dahulu');
        document.getElementById('productGrid').scrollIntoView({ behavior: 'smooth' });
        return false;
    }
    var discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
    if (discountPercent <= 0 || discountPercent >= 100) {
        alert('Masukkan diskon antara 1% hingga 99%');
        return false;
    }
    var promoPrice = parseFloat(document.getElementById('promoPriceHidden').value) || 0;
    if (promoPrice <= 0) {
        alert('Harga promo tidak valid');
        return false;
    }
    return true;
}

// On load: if product already selected (e.g. after validation error), activate its card
document.addEventListener('DOMContentLoaded', function() {
    var preselected = document.getElementById('productIdInput').value;
    if (preselected) {
        var card = document.querySelector('.product-pick-card[data-id="' + preselected + '"]');
        if (card) selectProduct(card);
    }
});
</script>

@endsection
