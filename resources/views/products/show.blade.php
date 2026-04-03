@extends('layouts.app')

@section('title', $product->name . ' - NusaMart')

@push('styles')
<style>
.product-detail-page { padding: 30px 0 60px; }
.breadcrumb { font-size: 13px; color: #888; margin-bottom: 24px; }
.breadcrumb a { color: #D10024; }
.breadcrumb span { margin: 0 6px; }

.product-detail { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
@media(max-width:768px){ .product-detail { grid-template-columns: 1fr; } }

.product-image-box {
    background: #fff; border-radius: 12px; overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.08);
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
}
.product-image-box img { width: 100%; height: 100%; object-fit: cover; }
.product-image-box .no-img { font-size: 80px; color: #ccc; }

.product-info { display: flex; flex-direction: column; gap: 16px; }
.product-category-badge {
    display: inline-block; padding: 4px 12px; background: #fff0f0; color: #D10024;
    border-radius: 20px; font-size: 12px; font-weight: 600; width: fit-content;
}
.product-title { font-size: 24px; font-weight: 700; color: #1e1f29; line-height: 1.3; }
.product-seller { font-size: 13px; color: #888; }
.product-seller a { color: #D10024; font-weight: 600; }
.product-price { font-size: 28px; font-weight: 800; color: #D10024; }

.product-stock-info {
    display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500;
    padding: 10px 14px; border-radius: 8px;
}
.product-stock-info.available { background: #d1fae5; color: #065f46; }
.product-stock-info.low { background: #fef3c7; color: #92400e; }
.product-stock-info.out { background: #fee2e2; color: #991b1b; }

.product-description { font-size: 14px; color: #555; line-height: 1.7; }
.product-description h4 { font-size: 15px; font-weight: 600; color: #1e1f29; margin-bottom: 8px; }

.add-to-cart-form { display: flex; flex-direction: column; gap: 12px; }
.qty-row { display: flex; align-items: center; gap: 10px; }
.qty-label { font-size: 13px; font-weight: 600; color: #555; }
.qty-control { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
.qty-btn {
    width: 36px; height: 36px; background: #f5f5f5; border: none; cursor: pointer;
    font-size: 16px; font-weight: 600; color: #333; transition: background .15s;
}
.qty-btn:hover { background: #e0e0e0; }
.qty-input {
    width: 50px; height: 36px; text-align: center; border: none; border-left: 1px solid #ddd;
    border-right: 1px solid #ddd; font-family: inherit; font-size: 14px; font-weight: 600;
    outline: none;
}

.btn-add-cart {
    padding: 14px 28px; background: #fff; color: #D10024; border: 2px solid #D10024; border-radius: 8px;
    font-family: inherit; font-size: 15px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px; transition: background .2s, color .2s;
    flex: 1;
}
.btn-add-cart:hover { background: #fff0f0; }
.btn-add-cart:disabled { border-color: #ccc; color: #9ca3af; cursor: not-allowed; }

.btn-buy-now {
    padding: 14px 28px; background: #D10024; color: #fff; border: none; border-radius: 8px;
    font-family: inherit; font-size: 15px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px; transition: background .2s;
    flex: 1;
}
.btn-buy-now:hover { background: #a8001e; }
.btn-buy-now:disabled { background: #ccc; cursor: not-allowed; }

.btn-wishlist {
    width: 50px; height: 50px; background: #fff; border: 2px solid #e5e7eb; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; cursor: pointer;
    font-size: 18px; transition: border-color .2s, color .2s; flex-shrink: 0;
}
.btn-wishlist:hover { border-color: #D10024; color: #D10024; }
.btn-wishlist.active { border-color: #D10024; color: #D10024; background: #fff0f0; }

.btn-action-row { display: flex; gap: 10px; align-items: stretch; }

.btn-out-of-stock {
    padding: 14px 28px; background: #e5e7eb; color: #9ca3af; border: none; border-radius: 8px;
    font-family: inherit; font-size: 15px; font-weight: 700; cursor: not-allowed;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}

.alert-success { background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px; }
.alert-error { background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px; }
</style>
@endpush

@section('content')
<div class="container product-detail-page">
    <div class="breadcrumb">
        <a href="{{ route('products.index') }}">Produk</a>
        <span>&rsaquo;</span>
        @if($product->category)
            <span>{{ $product->category }}</span>
            <span>&rsaquo;</span>
        @endif
        <span style="color:#333;">{{ $product->name }}</span>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="product-detail">
        {{-- Gambar Produk --}}
        <div class="product-image-box">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <i class="fa fa-shopping-bag no-img"></i>
            @endif
        </div>

        {{-- Info Produk --}}
        <div class="product-info">
            @if($product->category)
                <span class="product-category-badge">{{ $product->category }}</span>
            @endif

            <h1 class="product-title">{{ $product->name }}</h1>

            <div class="product-seller">
                <i class="fa fa-store"></i> Dijual oleh
                <a href="#">{{ $product->seller->name }}</a>
            </div>

            <div class="product-price">{{ $product->formatted_price }}</div>

            {{-- Status Stok --}}
            @if($product->stock == 0)
                <div class="product-stock-info out">
                    <i class="fa fa-times-circle"></i> Stok Habis
                </div>
            @elseif($product->stock <= 5)
                <div class="product-stock-info low">
                    <i class="fa fa-exclamation-triangle"></i> Stok Terbatas &mdash; Sisa {{ $product->stock }} item
                </div>
            @else
                <div class="product-stock-info available">
                    <i class="fa fa-check-circle"></i> Stok Tersedia &mdash; {{ $product->stock }} item
                </div>
            @endif

            {{-- Deskripsi --}}
            @if($product->description)
            <div class="product-description">
                <h4>Deskripsi Produk</h4>
                <p>{{ $product->description }}</p>
            </div>
            @endif

            {{-- Tambah ke Keranjang --}}
            @auth
                @if(auth()->user()->role === 'pembeli')
                    @if($product->stock > 0)
                        {{-- Qty selector (shared, read by JS) --}}
                        <div class="add-to-cart-form">
                            <div class="qty-row">
                                <span class="qty-label">Jumlah:</span>
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" onclick="changeQty(-1)">−</button>
                                    <input type="number" id="qtyInput" class="qty-input"
                                        value="1" min="1" max="{{ $product->stock }}">
                                    <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                                </div>
                                <span style="font-size:12px;color:#888;">Maks. {{ $product->stock }}</span>
                            </div>

                            {{-- Beli Langsung --}}
                            <form id="formBuyNow" method="POST" action="{{ route('cart.buy-now', $product) }}">
                                @csrf
                                <input type="hidden" name="quantity" id="qtyBuyNow" value="1">
                                <button type="submit" class="btn-buy-now" style="width:100%;">
                                    <i class="fa fa-bolt"></i> Beli Langsung
                                </button>
                            </form>

                            {{-- Tambah ke Keranjang + Wishlist --}}
                            <div class="btn-action-row">
                                <form id="formAddCart" method="POST" action="{{ route('cart.add', $product) }}" style="flex:1;display:flex;">
                                    @csrf
                                    <input type="hidden" name="quantity" id="qtyAddCart" value="1">
                                    <button type="submit" class="btn-add-cart" style="width:100%;">
                                        <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('wishlist.toggle', $product) }}" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="btn-wishlist {{ $isWishlisted ? 'active' : '' }}"
                                        title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}">
                                        <i class="fa {{ $isWishlisted ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <button class="btn-out-of-stock" disabled>
                            <i class="fa fa-times-circle"></i> Stok Habis
                        </button>
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-buy-now" style="text-decoration:none;">
                    <i class="fa fa-sign-in"></i> Login untuk Membeli
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qtyInput');
    const max = parseInt(input.max);
    const min = parseInt(input.min);
    let val = parseInt(input.value) + delta;
    if (val < min) val = min;
    if (val > max) val = max;
    input.value = val;
    syncQty(val);
}

function syncQty(val) {
    const buyNow  = document.getElementById('qtyBuyNow');
    const addCart = document.getElementById('qtyAddCart');
    if (buyNow)  buyNow.value  = val;
    if (addCart) addCart.value = val;
}

// Keep hidden inputs in sync when user types directly
const qtyInput = document.getElementById('qtyInput');
if (qtyInput) {
    qtyInput.addEventListener('input', function () {
        let val = parseInt(this.value) || 1;
        const max = parseInt(this.max);
        const min = parseInt(this.min);
        if (val < min) val = min;
        if (val > max) val = max;
        this.value = val;
        syncQty(val);
    });
}
</script>
@endpush
