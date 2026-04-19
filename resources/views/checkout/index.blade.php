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

.va-bank-options { display: grid; grid-template-columns: repeat(2,1fr); gap: 8px; margin-top: 12px; }
.va-bank-btn {
    display: flex; align-items: center; gap: 10px; padding: 10px 12px;
    border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer;
    transition: all .2s; background: #fff;
}
.va-bank-btn:hover { border-color: #D10024; }
.va-bank-btn input[type=radio] { display:none; }
.va-bank-btn.selected { border-color: #D10024; background: #fff5f5; }
.va-bank-logo { width: 36px; height: 22px; border-radius: 4px; display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:800; color:#fff; flex-shrink:0; letter-spacing:.5px; }
.va-bank-name { font-size: 13px; font-weight: 600; color: #1e1f29; }
.va-bank-sub { font-size: 11px; color: #888; }

/* Voucher */
.voucher-card-inner { background:linear-gradient(135deg,#fff5f5,#fff); border:2px dashed #f5c6c6; border-radius:12px; padding:18px 20px; position:relative; overflow:hidden; }
.voucher-card-inner::before { content:''; position:absolute; right:-24px; top:50%; transform:translateY(-50%); width:48px; height:48px; background:#f9f9fb; border-radius:50%; }
.voucher-card-inner::after  { content:''; position:absolute; left:-24px;  top:50%; transform:translateY(-50%); width:48px; height:48px; background:#f9f9fb; border-radius:50%; }
.voucher-icon-wrap { width:40px; height:40px; border-radius:10px; background:linear-gradient(135deg,#D10024,#ff6b6b); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 4px 10px rgba(209,0,36,.2); }
.voucher-icon-wrap .fa { color:#fff; font-size:17px; }
.voucher-label { font-size:14px; font-weight:700; color:#1e1f29; }
.voucher-sublabel { font-size:11px; color:#aaa; margin-top:1px; }
.voucher-input-row { display:flex; gap:0; margin-top:14px; }
.voucher-input-row input {
    flex:1; padding:11px 16px; border:1.5px solid #e0e0e0; border-right:none;
    border-radius:8px 0 0 8px; font-family:inherit; font-size:13px; outline:none;
    text-transform:uppercase; letter-spacing:1.5px; font-weight:600; color:#1e1f29;
    background:#fff; transition:border-color .2s;
}
.voucher-input-row input:focus { border-color:#D10024; }
.voucher-input-row input::placeholder { letter-spacing:.5px; font-weight:400; color:#bbb; text-transform:none; }
.btn-apply-voucher {
    padding:11px 20px; background:#D10024; color:#fff; border:none;
    border-radius:0 8px 8px 0; font-family:inherit; font-size:13px; font-weight:700;
    cursor:pointer; white-space:nowrap; transition:background .2s; letter-spacing:.3px;
}
.btn-apply-voucher:hover { background:#a8001e; }
.btn-apply-voucher:disabled { background:#e0e0e0; color:#aaa; cursor:default; }
.voucher-feedback { margin-top:10px; font-size:12px; border-radius:8px; padding:10px 14px; display:none; align-items:center; gap:8px; }
.voucher-feedback.show { display:flex; }
.voucher-feedback.success { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
.voucher-feedback.error   { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
.voucher-feedback .fa { font-size:14px; flex-shrink:0; }
.voucher-feedback-text { flex:1; }
.btn-remove-voucher { background:none; border:1px solid #fca5a5; color:#D10024; cursor:pointer; font-size:11px; font-weight:700; padding:3px 8px; border-radius:20px; white-space:nowrap; transition:all .15s; }
.btn-remove-voucher:hover { background:#D10024; color:#fff; }
.voucher-applied-badge { display:none; align-items:center; gap:8px; margin-top:12px; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:8px; padding:9px 14px; }
.voucher-applied-badge.show { display:flex; }
.voucher-applied-code { font-size:13px; font-weight:700; color:#065f46; letter-spacing:1px; }
.voucher-applied-discount { margin-left:auto; font-size:13px; font-weight:700; color:#D10024; }
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

                    {{-- Transfer Bank --}}
                    <label class="payment-option {{ old('payment_method','transfer') === 'transfer' ? 'active' : '' }}" id="transferOption" onclick="switchPayment('transfer')">
                        <input type="radio" name="payment_method" value="transfer" {{ old('payment_method','transfer') === 'transfer' ? 'checked' : '' }}>
                        <div class="payment-option-info">
                            <h5><i class="fa fa-university" style="margin-right:6px;color:#D10024;"></i> Transfer Bank Manual</h5>
                            <p>Transfer ke rekening bank NusaMart</p>
                        </div>
                    </label>

                    <div id="transferInfo" class="bank-info" style="{{ old('payment_method','transfer') !== 'transfer' ? 'display:none' : '' }}">
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

                    {{-- Virtual Account --}}
                    <label class="payment-option {{ old('payment_method') === 'virtual_account' ? 'active' : '' }}" id="vaOption" onclick="switchPayment('virtual_account')" style="margin-top:10px;">
                        <input type="radio" name="payment_method" value="virtual_account" {{ old('payment_method') === 'virtual_account' ? 'checked' : '' }}>
                        <div class="payment-option-info">
                            <h5><i class="fa fa-barcode" style="margin-right:6px;color:#3b82f6;"></i> Virtual Account</h5>
                            <p>Bayar otomatis via nomor VA yang digenerate</p>
                        </div>
                    </label>

                    <div id="vaInfo" style="{{ old('payment_method') !== 'virtual_account' ? 'display:none' : '' }}">
                        <div class="bank-info">
                            <h6 style="color:#3b82f6;"><i class="fa fa-bank" style="color:#3b82f6;margin-right:6px;"></i>Pilih Bank</h6>
                            <div class="va-bank-options">
                                @foreach(['bca' => ['BCA', '#005baa'], 'mandiri' => ['Mandiri', '#003d91'], 'bni' => ['BNI', '#f15a24'], 'bri' => ['BRI', '#00529b']] as $bankVal => [$bankName, $bankColor])
                                <label class="va-bank-btn {{ old('va_bank') === $bankVal ? 'selected' : '' }}" onclick="selectVaBank(this)">
                                    <input type="radio" name="va_bank" value="{{ $bankVal }}" {{ old('va_bank') === $bankVal ? 'checked' : '' }}>
                                    <div class="va-bank-logo" style="background:{{ $bankColor }}">{{ $bankName }}</div>
                                    <div>
                                        <div class="va-bank-name">Bank {{ $bankName }}</div>
                                        <div class="va-bank-sub">Nomor VA otomatis</div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('va_bank')<div class="error-msg" style="margin-top:6px;">{{ $message }}</div>@enderror
                            <p style="font-size:12px;color:#888;margin-top:10px;">
                                <i class="fa fa-info-circle" style="color:#3b82f6;"></i>
                                Nomor Virtual Account akan ditampilkan setelah pesanan dibuat. Bayar sebelum batas waktu 24 jam.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Voucher --}}
                <div class="card" style="padding:20px 24px;">
                    <div class="voucher-card-inner">
                        <div style="display:flex;align-items:center;gap:14px;position:relative;z-index:1;">
                            <div class="voucher-icon-wrap">
                                <i class="fa fa-ticket"></i>
                            </div>
                            <div>
                                <div class="voucher-label">Punya Kode Voucher?</div>
                                <div class="voucher-sublabel">Masukkan kode & hemat lebih banyak!</div>
                            </div>
                        </div>
                        <div class="voucher-input-row" style="position:relative;z-index:1;">
                            <input type="text" id="voucherInput" placeholder="Contoh: HEMAT20" autocomplete="off">
                            <button type="button" class="btn-apply-voucher" id="btnApplyVoucher" onclick="applyVoucher()">
                                <i class="fa fa-check" style="margin-right:5px;"></i>Terapkan
                            </button>
                        </div>
                        <div class="voucher-feedback" id="voucherFeedback" style="position:relative;z-index:1;"></div>
                    </div>
                    <input type="hidden" name="voucher_code" id="voucherCodeHidden" value="{{ old('voucher_code') }}">
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

                    @foreach($itemsBySeller as $sellerId => $sellerItems)
                    @php $sellerSubtotal = $sellerItems->sum(fn($i) => $i->quantity * $i->product->getDisplayPrice()); @endphp
                    <div style="margin-bottom:10px;">
                        <div style="font-size:12px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;padding-bottom:6px;border-bottom:1px dashed #f0f0f0;display:flex;align-items:center;gap:6px;">
                            <i class="fa fa-store" style="color:#D10024;"></i>
                            {{ $sellerItems->first()->product->seller->name ?? 'Toko' }}
                        </div>
                        @foreach($sellerItems as $item)
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
                                @php $displayPrice = $item->product->getDisplayPrice(); @endphp
                                <div class="order-item-qty">
                                    {{ $item->quantity }} x
                                    @if($displayPrice < $item->product->price)
                                        <span style="color:#D10024;font-weight:700;">Rp {{ number_format($displayPrice, 0, ',', '.') }}</span>
                                        <span style="text-decoration:line-through;color:#bbb;font-size:11px;margin-left:2px;">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                    @else
                                        Rp {{ number_format($displayPrice, 0, ',', '.') }}
                                    @endif
                                </div>
                            </div>
                            <div class="order-item-price">
                                Rp {{ number_format($item->quantity * $displayPrice, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                        <div style="display:flex;justify-content:flex-end;font-size:12px;color:#888;padding-top:6px;">
                            Subtotal toko: <strong style="color:#1e1f29;margin-left:4px;">Rp {{ number_format($sellerSubtotal, 0, ',', '.') }}</strong>
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
                        <div class="summary-row" id="discountRow" style="display:none;color:#10b981;font-weight:600;">
                            <span><i class="fa fa-tag" style="margin-right:4px;"></i>Diskon Voucher</span>
                            <span id="discountDisplay">-Rp 0</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Pembayaran</span>
                            <span id="grandTotalDisplay">Rp {{ number_format($total, 0, ',', '.') }}</span>
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

@push('scripts')
<script>
var _baseTotal = {{ $total }};
var _appliedDiscount = 0;

function formatRp(val) {
    return 'Rp ' + Math.round(val).toLocaleString('id-ID');
}

function applyVoucher() {
    var code = document.getElementById('voucherInput').value.trim();
    var fb   = document.getElementById('voucherFeedback');
    if (!code) {
        fb.className = 'voucher-feedback error show';
        fb.innerHTML = '<i class="fa fa-exclamation-circle"></i><span class="voucher-feedback-text">Masukkan kode voucher terlebih dahulu.</span>';
        return;
    }
    var btn = document.getElementById('btnApplyVoucher');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin" style="margin-right:5px;"></i>Memeriksa...';
    fb.className = 'voucher-feedback';
    fb.innerHTML = '';

    fetch('{{ route('checkout.validateVoucher') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code: code, total: _baseTotal })
    })
    .then(function(r){ return r.json(); })
    .then(function(data) {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-check" style="margin-right:5px;"></i>Terapkan';
        if (data.valid) {
            _appliedDiscount = data.discount;
            document.getElementById('voucherCodeHidden').value = code.toUpperCase();
            document.getElementById('discountRow').style.display = '';
            document.getElementById('discountDisplay').textContent = '-' + data.discount_fmt;
            document.getElementById('grandTotalDisplay').textContent = formatRp(_baseTotal - _appliedDiscount);
            fb.className = 'voucher-feedback success show';
            fb.innerHTML = '<i class="fa fa-check-circle"></i>' +
                '<span class="voucher-feedback-text">' + data.message + '</span>' +
                '<button type="button" class="btn-remove-voucher" onclick="removeVoucher()"><i class="fa fa-times" style="margin-right:3px;"></i>Hapus</button>';
        } else {
            _appliedDiscount = 0;
            document.getElementById('voucherCodeHidden').value = '';
            document.getElementById('discountRow').style.display = 'none';
            document.getElementById('grandTotalDisplay').textContent = formatRp(_baseTotal);
            fb.className = 'voucher-feedback error show';
            fb.innerHTML = '<i class="fa fa-times-circle"></i><span class="voucher-feedback-text">' + data.message + '</span>';
        }
    })
    .catch(function(){
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-check" style="margin-right:5px;"></i>Terapkan';
        fb.className = 'voucher-feedback error show';
        fb.innerHTML = '<i class="fa fa-times-circle"></i><span class="voucher-feedback-text">Terjadi kesalahan. Coba lagi.</span>';
    });
}

function removeVoucher() {
    _appliedDiscount = 0;
    document.getElementById('voucherInput').value = '';
    document.getElementById('voucherCodeHidden').value = '';
    document.getElementById('discountRow').style.display = 'none';
    document.getElementById('grandTotalDisplay').textContent = formatRp(_baseTotal);
    var fb = document.getElementById('voucherFeedback');
    fb.className = 'voucher-feedback';
    fb.innerHTML = '';
}

function switchPayment(method) {
    var transferOpt = document.getElementById('transferOption');
    var vaOpt       = document.getElementById('vaOption');
    var transferInfo = document.getElementById('transferInfo');
    var vaInfo       = document.getElementById('vaInfo');

    if (method === 'transfer') {
        transferOpt.classList.add('active');
        vaOpt.classList.remove('active');
        transferInfo.style.display = '';
        vaInfo.style.display = 'none';
        transferOpt.querySelector('input').checked = true;
    } else {
        vaOpt.classList.add('active');
        transferOpt.classList.remove('active');
        vaInfo.style.display = '';
        transferInfo.style.display = 'none';
        vaOpt.querySelector('input').checked = true;
    }
}

function selectVaBank(label) {
    document.querySelectorAll('.va-bank-btn').forEach(function(l){ l.classList.remove('selected'); });
    label.classList.add('selected');
    label.querySelector('input').checked = true;
}
</script>
@endpush
