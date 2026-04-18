@extends('layouts.seller')

@section('title', 'Buat Promo - Seller Center NusaMart')

@section('breadcrumb')Promo / <strong>Buat Promo</strong>@endsection

@section('content')

<style>
    .form-container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .form-title { font-size: 22px; font-weight: 800; margin-bottom: 24px; color: #1e1f29; }
    
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 13px; }
    .form-control { width: 100%; padding: 12px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-family: inherit; box-sizing: border-box; transition: border .2s; }
    .form-control:focus { outline: none; border-color: #D10024; box-shadow: 0 0 0 3px rgba(209,0,36,.08); }
    
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
            <select name="product_id" class="form-control" required onchange="updateProductPrice()">
                <option value="">-- Pilih Produk --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ request('product_id') == $product->id || $productId == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
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
function validateForm() {
    const discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
    const promoPriceHidden = parseFloat(document.getElementById('promoPriceHidden').value) || 0;
    
    if (discountPercent <= 0 || discountPercent >= 100) {
        alert('Masukkan diskon antara 1% hingga 99%');
        return false;
    }
    
    if (promoPriceHidden <= 0) {
        alert('Harga promo tidak valid');
        return false;
    }
    
    return true;
}

function updateProductPrice() {
    const select = document.querySelector('select[name="product_id"]');
    const selected = select.options[select.selectedIndex];
    const price = selected.dataset.price;
    
    if (price) {
        document.getElementById('normalPrice').textContent = new Intl.NumberFormat('id-ID').format(price);
        document.getElementById('priceInfo').style.display = 'block';
        document.getElementById('discountPercent').value = '';
        updateDiscountInfo();
    } else {
        document.getElementById('priceInfo').style.display = 'none';
    }
}

function updateDiscountInfo() {
    const select = document.querySelector('select[name="product_id"]');
    const selected = select.options[select.selectedIndex];
    const normalPrice = parseFloat(selected.dataset.price) || 0;
    const discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
    
    if (normalPrice && discountPercent > 0) {
        const promoPrice = Math.round(normalPrice * (1 - discountPercent / 100));
        const discountNominal = normalPrice - promoPrice;
        
        // Set hidden field untuk form submission
        document.getElementById('promoPriceHidden').value = promoPrice;
        
        document.getElementById('promoPrice').textContent = new Intl.NumberFormat('id-ID').format(promoPrice);
        document.getElementById('discountPercentDisplay').textContent = discountPercent;
        
        if (discountPercent >= 100 || promoPrice <= 0) {
            document.getElementById('discountWarning').style.display = 'block';
            document.getElementById('discountWarning').innerHTML = 
                '<i class="fa fa-exclamation-circle"></i> Diskon terlalu besar, harga promo tidak boleh negatif atau nol';
        } else {
            document.getElementById('discountWarning').style.display = 'block';
            document.getElementById('discountWarning').innerHTML = 
                '<i class="fa fa-info-circle"></i> Pelanggan akan membeli Rp ' + new Intl.NumberFormat('id-ID').format(promoPrice) + ' (hemat Rp ' + new Intl.NumberFormat('id-ID').format(discountNominal) + ')';
        }
    } else if (discountPercent > 0) {
        document.getElementById('discountWarning').style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', updateProductPrice);
</script>

@endsection
