@extends('layouts.seller')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Seller Center NusaMart')

@section('breadcrumb')
    Transaksi / <a href="{{ route('seller.orders') }}" style="color:#D10024;font-weight:600;text-decoration:none">Pesanan</a> / <strong>#{{ $order->order_number }}</strong>
@endsection

@push('styles')
<style>
.od-page { display:grid; grid-template-columns:1fr 320px; gap:20px; align-items:start; }
@media(max-width:900px){ .od-page{ grid-template-columns:1fr; } }

.od-card { background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.05); margin-bottom:20px; overflow:hidden; }
.od-card-header { padding:16px 20px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between; }
.od-card-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#aaa; display:flex; align-items:center; gap:8px; }
.od-card-title i { font-size:13px; color:#D10024; }
.od-card-body { padding:20px; }

/* Info rows */
.od-row { display:flex; justify-content:space-between; align-items:flex-start; padding:9px 0; border-bottom:1px solid #f9f9f9; font-size:13px; }
.od-row:last-child { border-bottom:none; }
.od-label { color:#888; flex-shrink:0; min-width:150px; }
.od-value { font-weight:600; color:#1e1f29; text-align:right; word-break:break-word; max-width:220px; }

/* Status chip */
.sc-status-chip { display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; }
.sc-status-chip.pending    { background:#fef3c7; color:#92400e; }
.sc-status-chip.processing { background:#dbeafe; color:#1e40af; }
.sc-status-chip.shipped    { background:#ede9fe; color:#5b21b6; }
.sc-status-chip.delivered  { background:#d1fae5; color:#065f46; }
.sc-status-chip.cancelled  { background:#fee2e2; color:#991b1b; }

/* Items */
.item-row { display:flex; align-items:center; gap:14px; padding:12px 0; border-bottom:1px solid #f5f5f5; }
.item-row:last-child { border-bottom:none; }
.item-img { width:60px; height:60px; border-radius:8px; object-fit:cover; background:#f4f5f7; flex-shrink:0; }
.item-img-ph { width:60px; height:60px; border-radius:8px; background:#f4f5f7; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:22px; flex-shrink:0; }
.item-name { font-size:13px; font-weight:700; color:#1e1f29; margin-bottom:3px; }
.item-meta { font-size:12px; color:#aaa; }
.item-sub { margin-left:auto; font-size:14px; font-weight:800; color:#D10024; white-space:nowrap; }
.total-row { display:flex; justify-content:space-between; align-items:center; padding:14px 0 0; margin-top:6px; border-top:2px solid #f0f0f0; font-size:15px; font-weight:800; color:#1e1f29; }

/* Action card */
.action-card { background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.05); padding:24px; position:sticky; top:20px; }
.action-title { font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.6px; margin-bottom:16px; display:flex; align-items:center; gap:6px; }
.action-title i { color:#D10024; font-size:13px; }
.action-status-block { text-align:center; padding:16px 0 20px; margin-bottom:20px; border-bottom:1px solid #f0f0f0; }
.action-btn { display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:12px; border:none; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .2s; margin-bottom:10px; }
.action-btn.primary { background:#D10024; color:#fff; }
.action-btn.primary:hover { background:#a8001e; }
.action-btn.outline { background:#fff; color:#D10024; border:2px solid #D10024; }
.action-btn.outline:hover { background:#fff5f5; }
.action-input { width:100%; padding:10px 12px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; outline:none; margin-bottom:10px; box-sizing:border-box; transition:border .2s; }
.action-input:focus { border-color:#D10024; }
.action-input-label { font-size:12px; font-weight:700; color:#555; margin-bottom:6px; display:block; }
.action-note { font-size:12px; color:#aaa; text-align:center; line-height:1.6; margin-top:10px; }
.action-done { text-align:center; padding:10px 0 20px; }
.action-done-icon { font-size:42px; margin-bottom:10px; display:block; }
.action-done-msg { font-size:14px; color:#333; font-weight:700; }
.action-hint { font-size:13px; color:#555; margin-bottom:16px; line-height:1.6; }

.back-link { display:inline-flex; align-items:center; gap:7px; font-size:13px; font-weight:600; color:#D10024; text-decoration:none; margin-bottom:20px; transition:color .15s; }
.back-link:hover { color:#a8001e; }

.alert { padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:8px; }
.alert-success { background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; }
.alert-error   { background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; }

.tracking-badge { display:inline-flex; align-items:center; gap:6px; background:#f4f5f7; padding:6px 12px; border-radius:8px; font-size:13px; font-weight:700; color:#333; margin-top:8px; }
</style>
@endpush

@section('content')

<a href="{{ route('seller.orders') }}" class="back-link"><i class="fa fa-arrow-left"></i> Kembali ke Daftar Pesanan</a>

@if(session('success'))
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {{ $errors->first() }}</div>
@endif

<div class="od-page">

    {{-- ===== LEFT COLUMN ===== --}}
    <div>

        {{-- Informasi Pesanan --}}
        <div class="od-card">
            <div class="od-card-header">
                <span class="od-card-title"><i class="fa fa-file-text-o"></i> Informasi Pesanan</span>
                <span class="sc-status-chip {{ $order->status }}">{{ $order->status_label }}</span>
            </div>
            <div class="od-card-body">
                <div class="od-row">
                    <span class="od-label">No. Pesanan</span>
                    <span class="od-value">#{{ $order->order_number }}</span>
                </div>
                <div class="od-row">
                    <span class="od-label">Tanggal Pesan</span>
                    <span class="od-value">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                </div>
                <div class="od-row">
                    <span class="od-label">Metode Pembayaran</span>
                    <span class="od-value">{{ $order->payment_method ?? '-' }}</span>
                </div>
                @if($order->va_bank)
                <div class="od-row">
                    <span class="od-label">Bank</span>
                    <span class="od-value">{{ strtoupper($order->va_bank) }}</span>
                </div>
                @endif
                @if($order->tracking_number)
                <div class="od-row">
                    <span class="od-label">No. Resi</span>
                    <span class="od-value">{{ $order->tracking_number }}</span>
                </div>
                @endif
                @if($order->notes)
                <div class="od-row">
                    <span class="od-label">Catatan Pembeli</span>
                    <span class="od-value" style="font-style:italic">{{ $order->notes }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Produk Dipesan --}}
        <div class="od-card">
            <div class="od-card-header">
                <span class="od-card-title"><i class="fa fa-shopping-bag"></i> Produk Dipesan</span>
                <span style="font-size:12px;color:#aaa;font-weight:600">{{ $order->items->count() }} item</span>
            </div>
            <div class="od-card-body">
                @foreach($order->items as $item)
                <div class="item-row">
                    @if($item->product?->image)
                        <img class="item-img" src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product_name }}">
                    @else
                        <div class="item-img-ph"><i class="fa fa-image"></i></div>
                    @endif
                    <div style="flex:1;min-width:0">
                        <div class="item-name">{{ $item->product_name }}</div>
                        <div class="item-meta">{{ $item->formatted_price }} &times; {{ $item->quantity }}</div>
                    </div>
                    <div class="item-sub">{{ $item->formatted_subtotal }}</div>
                </div>
                @endforeach

                <div class="total-row">
                    <span>Total Pembayaran</span>
                    <span style="color:#D10024">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        {{-- Alamat Pengiriman --}}
        <div class="od-card">
            <div class="od-card-header">
                <span class="od-card-title"><i class="fa fa-map-marker"></i> Alamat Pengiriman</span>
            </div>
            <div class="od-card-body">
                <div class="od-row">
                    <span class="od-label">Nama Penerima</span>
                    <span class="od-value">{{ $order->shipping_name }}</span>
                </div>
                <div class="od-row">
                    <span class="od-label">No. Telepon</span>
                    <span class="od-value">{{ $order->shipping_phone ?? '-' }}</span>
                </div>
                <div class="od-row">
                    <span class="od-label">Alamat Lengkap</span>
                    <span class="od-value">{{ $order->shipping_address }}</span>
                </div>
                <div class="od-row">
                    <span class="od-label">Kota</span>
                    <span class="od-value">{{ $order->shipping_city }}</span>
                </div>
                <div class="od-row">
                    <span class="od-label">Provinsi</span>
                    <span class="od-value">{{ $order->shipping_province }}</span>
                </div>
            </div>
        </div>

        {{-- Info Pembeli --}}
        <div class="od-card">
            <div class="od-card-header">
                <span class="od-card-title"><i class="fa fa-user-o"></i> Info Pembeli</span>
            </div>
            <div class="od-card-body">
                <div class="od-row">
                    <span class="od-label">Nama</span>
                    <span class="od-value">{{ $order->user?->name ?? '-' }}</span>
                </div>
                <div class="od-row">
                    <span class="od-label">Email</span>
                    <span class="od-value">{{ $order->user?->email ?? '-' }}</span>
                </div>
            </div>
        </div>

    </div>{{-- end left --}}

    {{-- ===== RIGHT COLUMN: ACTION ===== --}}
    <div>
        <div class="action-card">
            <div class="action-title"><i class="fa fa-bolt"></i> Aksi Pesanan</div>

            <div class="action-status-block">
                <span class="sc-status-chip {{ $order->status }}" style="font-size:13px;padding:6px 18px">
                    {{ $order->status_label }}
                </span>
                <div style="font-size:12px;color:#aaa;margin-top:8px">
                    {{ $order->created_at->format('d M Y, H:i') }}
                </div>
            </div>

            @if($order->status === 'pending')
                <p class="action-hint">Pesanan baru masuk. Klik <strong>Proses Pesanan</strong> untuk menyiapkan barang.</p>
                <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="processing">
                    <button type="submit" class="action-btn primary">
                        <i class="fa fa-check"></i> Proses Pesanan
                    </button>
                </form>
                <p class="action-note">Dengan memproses pesanan, pembeli akan mendapat notifikasi bahwa pesanan sedang disiapkan.</p>

            @elseif($order->status === 'processing')
                <p class="action-hint">Pesanan sedang diproses. Masukkan nomor resi pengiriman, lalu klik <strong>Tandai Dikirim</strong>.</p>
                <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="shipped">
                    <label class="action-input-label">Nomor Resi <span style="color:#D10024">*</span></label>
                    <input type="text" name="tracking_number" class="action-input"
                        placeholder="Contoh: JNE1234567890"
                        value="{{ old('tracking_number') }}" required>
                    <button type="submit" class="action-btn primary">
                        <i class="fa fa-truck"></i> Tandai Dikirim
                    </button>
                </form>
                <p class="action-note">Nomor resi akan ditampilkan kepada pembeli untuk melacak paket.</p>

            @elseif($order->status === 'shipped')
                <div class="action-done">
                    <i class="action-done-icon fa fa-truck" style="color:#8b5cf6"></i>
                    <div class="action-done-msg">Paket Sudah Dikirim</div>
                    @if($order->tracking_number)
                        <div class="tracking-badge" style="margin:10px auto 0;display:inline-flex">
                            <i class="fa fa-barcode"></i> {{ $order->tracking_number }}
                        </div>
                    @endif
                </div>
                <p class="action-note">Menunggu konfirmasi penerimaan paket dari pembeli.</p>

            @elseif($order->status === 'delivered')
                <div class="action-done">
                    <i class="action-done-icon fa fa-check-circle" style="color:#10b981"></i>
                    <div class="action-done-msg">Pesanan Selesai</div>
                </div>
                <p class="action-note">Pembeli telah mengkonfirmasi penerimaan paket. Transaksi selesai.</p>

            @elseif($order->status === 'cancelled')
                <div class="action-done">
                    <i class="action-done-icon fa fa-times-circle" style="color:#ef4444"></i>
                    <div class="action-done-msg" style="color:#991b1b">Pesanan Dibatalkan</div>
                </div>
            @endif

        </div>
    </div>{{-- end right --}}

</div>{{-- end od-page --}}

@endsection
