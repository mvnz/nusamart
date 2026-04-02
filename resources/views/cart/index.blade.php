@extends('layouts.app')

@section('title', 'Keranjang Belanja - NusaMart')

@push('styles')
<style>
.cart-page { padding: 30px 0 60px; }
.page-title { font-size: 22px; font-weight: 700; color: #1e1f29; margin-bottom: 24px; }
.page-title span { color: #D10024; }

.cart-layout { display: grid; grid-template-columns: 1fr 320px; gap: 24px; }
@media(max-width:900px){ .cart-layout { grid-template-columns: 1fr; } }

.cart-table-wrap { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow: hidden; }
.cart-table { width: 100%; border-collapse: collapse; }
.cart-table th { background: #f9f9f9; padding: 14px 16px; font-size: 12px; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: .5px; text-align: left; border-bottom: 1px solid #eee; }
.cart-table td { padding: 16px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
.cart-table tr:last-child td { border-bottom: none; }

.cart-product { display: flex; align-items: center; gap: 14px; }
.cart-product-img { width: 64px; height: 64px; border-radius: 8px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
.cart-product-img img { width: 100%; height: 100%; object-fit: cover; }
.cart-product-img .fa { font-size: 24px; color: #ccc; }
.cart-product-name { font-size: 14px; font-weight: 600; color: #1e1f29; margin-bottom: 4px; }
.cart-product-price { font-size: 12px; color: #888; }

.cart-qty-control { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; width: fit-content; }
.cart-qty-btn { width: 30px; height: 30px; background: #f5f5f5; border: none; cursor: pointer; font-size: 14px; font-weight: 600; transition: background .15s; }
.cart-qty-btn:hover { background: #e0e0e0; }
.cart-qty-input { width: 40px; height: 30px; text-align: center; border: none; border-left: 1px solid #ddd; border-right: 1px solid #ddd; font-family: inherit; font-size: 13px; font-weight: 600; outline: none; }

.cart-subtotal { font-size: 14px; font-weight: 700; color: #D10024; }
.cart-remove { background: none; border: none; color: #ccc; cursor: pointer; font-size: 16px; padding: 6px; transition: color .15s; }
.cart-remove:hover { color: #ef4444; }

.cart-summary-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); padding: 24px; height: fit-content; position: sticky; top: 20px; }
.cart-summary-title { font-size: 16px; font-weight: 700; color: #1e1f29; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid #eee; }
.cart-summary-row { display: flex; justify-content: space-between; font-size: 13px; color: #555; margin-bottom: 10px; }
.cart-summary-row.total { font-size: 16px; font-weight: 700; color: #1e1f29; padding-top: 14px; border-top: 1px solid #eee; margin-top: 6px; }
.cart-summary-row.total span:last-child { color: #D10024; }

.btn-checkout {
    display: block; width: 100%; padding: 14px; background: #D10024; color: #fff;
    border: none; border-radius: 8px; font-family: inherit; font-size: 15px; font-weight: 700;
    cursor: pointer; text-align: center; text-decoration: none; margin-top: 20px;
    transition: background .2s;
}
.btn-checkout:hover { background: #a8001e; }

.btn-continue { display: block; width: 100%; padding: 10px; background: transparent; color: #D10024; border: 1px solid #D10024; border-radius: 8px; font-family: inherit; font-size: 13px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; margin-top: 10px; transition: all .2s; }
.btn-continue:hover { background: #fff0f0; }

.btn-clear { background: none; border: none; color: #999; font-size: 12px; cursor: pointer; font-family: inherit; text-decoration: underline; margin-top: 8px; }
.btn-clear:hover { color: #ef4444; }

.empty-cart { text-align: center; padding: 60px 20px; }
.empty-cart .fa { font-size: 60px; color: #e0e0e0; display: block; margin-bottom: 16px; }
.empty-cart h3 { font-size: 18px; color: #555; margin-bottom: 8px; }
.empty-cart p { font-size: 13px; color: #999; margin-bottom: 24px; }
.btn-shop { display: inline-block; padding: 12px 28px; background: #D10024; color: #fff; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; }
.btn-shop:hover { background: #a8001e; }

.alert-success { background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px; }
.alert-error { background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px; }
</style>
@endpush

@section('content')
<div class="container cart-page">
    <h1 class="page-title">Keranjang <span>Belanja</span></h1>

    @if(session('success'))
        <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <div class="cart-table-wrap">
            <div class="empty-cart">
                <i class="fa fa-shopping-cart"></i>
                <h3>Keranjang Anda Kosong</h3>
                <p>Mulai belanja dan tambahkan produk ke keranjang Anda.</p>
                <a href="{{ route('products.index') }}" class="btn-shop">
                    <i class="fa fa-store"></i> Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <div class="cart-layout">
            {{-- Tabel Item --}}
            <div class="cart-table-wrap">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr>
                            <td>
                                <div class="cart-product">
                                    <div class="cart-product-img">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                        @else
                                            <i class="fa fa-shopping-bag"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="cart-product-name">
                                            <a href="{{ route('products.show', $item->product) }}" style="color:inherit;">
                                                {{ $item->product->name }}
                                            </a>
                                        </div>
                                        <div class="cart-product-price">Stok: {{ $item->product->stock }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:14px;color:#555;">{{ $item->product->formatted_price }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <div class="cart-qty-control">
                                            <button type="button" class="cart-qty-btn" onclick="cartChangeQty(this, -1)">−</button>
                                            <input type="number" name="quantity" class="cart-qty-input"
                                                value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                onchange="this.form.submit()">
                                            <button type="button" class="cart-qty-btn" onclick="cartChangeQty(this, 1)">+</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td class="cart-subtotal">
                                Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-remove" title="Hapus">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="padding:14px 16px;display:flex;justify-content:space-between;align-items:center;border-top:1px solid #eee;">
                    <a href="{{ route('products.index') }}" style="font-size:13px;color:#D10024;font-weight:600;">
                        <i class="fa fa-arrow-left"></i> Lanjut Belanja
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-clear" onclick="return confirm('Kosongkan keranjang?')">
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="cart-summary-card">
                <div class="cart-summary-title">Ringkasan Pesanan</div>
                <div class="cart-summary-row">
                    <span>Subtotal ({{ $cartItems->count() }} produk)</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="cart-summary-row">
                    <span>Ongkos Kirim</span>
                    <span style="color:#10b981;font-weight:600;">Gratis</span>
                </div>
                <div class="cart-summary-row total">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn-checkout">
                    <i class="fa fa-lock"></i> Checkout Sekarang
                </a>
                <a href="{{ route('products.index') }}" class="btn-continue">
                    Lanjut Belanja
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function cartChangeQty(btn, delta) {
    const input = btn.closest('.cart-qty-control').querySelector('.cart-qty-input');
    const max = parseInt(input.max);
    const min = parseInt(input.min);
    let val = parseInt(input.value) + delta;
    if (val < min) val = min;
    if (val > max) val = max;
    input.value = val;
    input.form.submit();
}
</script>
@endpush
