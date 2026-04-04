@extends('layouts.seller')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Seller Center NusaMart')

@section('breadcrumb')
    Transaksi / <a href="{{ route('seller.orders') }}" style="color:#D10024;font-weight:600;text-decoration:none">Pesanan</a> / <strong>#{{ $order->order_number }}</strong>
@endsection

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
                    <label class="action-input-label">Kurir <span style="color:#D10024">*</span></label>
                    <select name="courier_name" class="action-input" required style="margin-bottom:10px">
                        <option value="">-- Pilih Kurir --</option>
                        <option value="JNE" {{ old('courier_name') == 'JNE' ? 'selected' : '' }}>JNE</option>
                        <option value="J&T Express" {{ old('courier_name') == 'J&T Express' ? 'selected' : '' }}>J&T Express</option>
                        <option value="SiCepat" {{ old('courier_name') == 'SiCepat' ? 'selected' : '' }}>SiCepat</option>
                        <option value="AnterAja" {{ old('courier_name') == 'AnterAja' ? 'selected' : '' }}>AnterAja</option>
                        <option value="Pos Indonesia" {{ old('courier_name') == 'Pos Indonesia' ? 'selected' : '' }}>Pos Indonesia</option>
                        <option value="Ninja Xpress" {{ old('courier_name') == 'Ninja Xpress' ? 'selected' : '' }}>Ninja Xpress</option>
                        <option value="Lion Parcel" {{ old('courier_name') == 'Lion Parcel' ? 'selected' : '' }}>Lion Parcel</option>
                        <option value="Tiki" {{ old('courier_name') == 'Tiki' ? 'selected' : '' }}>Tiki</option>
                        <option value="GoSend" {{ old('courier_name') == 'GoSend' ? 'selected' : '' }}>GoSend</option>
                        <option value="GrabExpress" {{ old('courier_name') == 'GrabExpress' ? 'selected' : '' }}>GrabExpress</option>
                    </select>
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
                    @if($order->courier_name)
                        <div class="tracking-badge" style="margin:8px auto 0;display:inline-flex;background:#f3f0ff;color:#6d28d9">
                            <i class="fa fa-motorcycle"></i> {{ $order->courier_name }}
                        </div>
                    @endif
                    @if($order->tracking_number)
                        <div class="tracking-badge" style="margin:6px auto 0;display:inline-flex">
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
