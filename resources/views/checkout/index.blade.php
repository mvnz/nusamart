@extends('layouts.app')

@section('title', 'Checkout - NusaMart')

@push('styles')
<style>
.checkout-page { padding: 30px 0 60px; }
.page-title { font-size: 22px; font-weight: 700; color: #1e1f29; margin-bottom: 24px; }
.page-title span { color: #D10024; }

.checkout-layout { display: grid; grid-template-columns: 1fr 340px; gap: 24px; }
@media(max-width:900px){ .checkout-layout { grid-template-columns: 1fr; } }

.card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); padding: 24px; margin-bottom: 20px; }
.card-title { font-size: 15px; font-weight: 700; color: #1e1f29; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px; }
.card-title .fa { color: #D10024; }

.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 13px; font-weight: 600; color: #555; margin-bottom: 6px; }
.form-group label .req { color: #D10024; }
.form-group input, .form-group select, .form-group textarea {
    width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 8px;
    font-family: inherit; font-size: 14px; outline: none; transition: border-color .2s;
    background: #fff;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #D10024; }
.form-group textarea { resize: vertical; min-height: 80px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
@media(max-width:600px){ .form-row { grid-template-columns: 1fr; } }

.payment-option { display: flex; align-items: center; gap: 12px; padding: 14px; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: border-color .2s; }
.payment-option:hover { border-color: #D10024; }
.payment-option input[type=radio] { width: 18px; height: 18px; accent-color: #D10024; }
.payment-option-info h5 { font-size: 14px; font-weight: 600; color: #1e1f29; margin: 0 0 2px; }
.payment-option-info p { font-size: 12px; color: #888; margin: 0; }
.payment-option.active { border-color: #D10024; background: #fff0f0; }

.bank-info { margin-top: 12px; background: #f9f9f9; border-radius: 8px; padding: 14px; font-size: 13px; }
.bank-info h6 { font-weight: 700; color: #333; margin-bottom: 8px; }
.bank-info .bank-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #eee; }
.bank-info .bank-row:last-child { border-bottom: none; }
.bank-info .bank-label { color: #888; }
.bank-info .bank-value { font-weight: 600; color: #1e1f29; }

.order-summary-card { position: sticky; top: 20px; height: fit-content; }
.order-item-row { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
.order-item-row:last-child { border-bottom: none; }
.order-item-img { width: 48px; height: 48px; border-radius: 6px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
.order-item-img img { width: 100%; height: 100%; object-fit: cover; }
.order-item-name { font-size: 13px; font-weight: 600; color: #1e1f29; flex: 1; }
.order-item-qty { font-size: 12px; color: #888; }
.order-item-price { font-size: 13px; font-weight: 700; color: #D10024; white-space: nowrap; }

.summary-row { display: flex; justify-content: space-between; font-size: 13px; color: #555; margin-bottom: 10px; }
.summary-row.total { font-size: 16px; font-weight: 700; color: #1e1f29; padding-top: 14px; border-top: 2px solid #eee; margin-top: 6px; }
.summary-row.total span:last-child { color: #D10024; }

.btn-place-order {
    display: block; width: 100%; padding: 15px; background: #D10024; color: #fff;
    border: none; border-radius: 8px; font-family: inherit; font-size: 15px; font-weight: 700;
    cursor: pointer; text-align: center; margin-top: 20px; transition: background .2s;
}
.btn-place-order:hover { background: #a8001e; }

.alert-error { background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px; }

.error-msg { color: #ef4444; font-size: 12px; margin-top: 4px; }
</style>
@endpush

@section('content')
<div class="container checkout-page">
    <h1 class="page-title"><span>Checkout</span></h1>

    @if(session('error'))
        <div class="alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="checkout-layout">
            {{-- Kolom Kiri: Form --}}
            <div>
                {{-- Alamat Pengiriman --}}
                <div class="card">
                    <div class="card-title">
                        <i class="fa fa-map-marker"></i> Alamat Pengiriman
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Penerima <span class="req">*</span></label>
                            <input type="text" name="shipping_name"
                                value="{{ old('shipping_name', $user->name) }}"
                                placeholder="Nama lengkap penerima" required>
                            @error('shipping_name')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Nomor Telepon <span class="req">*</span></label>
                            <input type="text" name="shipping_phone"
                                value="{{ old('shipping_phone', $user->phone) }}"
                                placeholder="08XXXXXXXXXX" required>
                            @error('shipping_phone')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap <span class="req">*</span></label>
                        <textarea name="shipping_address" placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan..." required>{{ old('shipping_address', $user->alamat) }}</textarea>
                        @error('shipping_address')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Kota / Kabupaten <span class="req">*</span></label>
                            <input type="text" name="shipping_city"
                                value="{{ old('shipping_city', $user->kota) }}"
                                placeholder="Kota / Kabupaten" required>
                            @error('shipping_city')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Provinsi <span class="req">*</span></label>
                            <input type="text" name="shipping_province"
                                value="{{ old('shipping_province', $user->propinsi) }}"
                                placeholder="Provinsi" required>
                            @error('shipping_province')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="card">
                    <div class="card-title">
                        <i class="fa fa-credit-card"></i> Metode Pembayaran
                    </div>

                    <label class="payment-option active" id="transferOption">
                        <input type="radio" name="payment_method" value="transfer" checked>
                        <div class="payment-option-info">
                            <h5><i class="fa fa-university" style="margin-right:6px;color:#D10024;"></i> Transfer Bank</h5>
                            <p>Transfer ke rekening bank yang tersedia</p>
                        </div>
                    </label>

                    <div class="bank-info">
                        <h6><i class="fa fa-info-circle" style="color:#D10024;margin-right:6px;"></i>Informasi Rekening</h6>
                        <div class="bank-row">
                            <span class="bank-label">Bank BCA</span>
                            <span class="bank-value">1234567890 a/n NusaMart</span>
                        </div>
                        <div class="bank-row">
                            <span class="bank-label">Bank Mandiri</span>
                            <span class="bank-value">9876543210 a/n NusaMart</span>
                        </div>
                        <div class="bank-row">
                            <span class="bank-label">Bank BNI</span>
                            <span class="bank-value">1122334455 a/n NusaMart</span>
                        </div>
                        <p style="font-size:12px;color:#888;margin-top:10px;">
                            <i class="fa fa-exclamation-triangle" style="color:#f59e0b;"></i>
                            Harap transfer sesuai total tagihan. Pesanan akan diproses setelah pembayaran dikonfirmasi.
                        </p>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="card">
                    <div class="card-title">
                        <i class="fa fa-sticky-note-o"></i> Catatan Pesanan (Opsional)
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <textarea name="notes" placeholder="Catatan untuk penjual...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Ringkasan --}}
            <div class="order-summary-card">
                <div class="card">
                    <div class="card-title">
                        <i class="fa fa-shopping-bag"></i> Ringkasan Pesanan
                    </div>

                    @foreach($cartItems as $item)
                    <div class="order-item-row">
                        <div class="order-item-img">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                            @else
                                <i class="fa fa-shopping-bag" style="color:#ccc;font-size:18px;"></i>
                            @endif
                        </div>
                        <div style="flex:1;">
                            <div class="order-item-name">{{ $item->product->name }}</div>
                            <div class="order-item-qty">{{ $item->quantity }} x {{ $item->product->formatted_price }}</div>
                        </div>
                        <div class="order-item-price">
                            Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach

                    <div style="margin-top:14px;">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Ongkos Kirim</span>
                            <span style="color:#10b981;font-weight:600;">Gratis</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-place-order">
                        <i class="fa fa-check-circle"></i> Buat Pesanan
                    </button>

                    <a href="{{ route('cart.index') }}" style="display:block;text-align:center;margin-top:10px;font-size:13px;color:#888;">
                        <i class="fa fa-arrow-left"></i> Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
