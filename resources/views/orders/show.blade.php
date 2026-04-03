@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number . ' - NusaMart')

@push('styles')
<style>
.order-detail-page { padding: 30px 0 60px; }
.breadcrumb { font-size: 13px; color: #888; margin-bottom: 20px; }
.breadcrumb a { color: #D10024; }
.breadcrumb span { margin: 0 6px; }

.order-detail-layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; }
@media(max-width:900px){ .order-detail-layout { grid-template-columns: 1fr; } }

.card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); padding: 24px; margin-bottom: 20px; }
.card-title { font-size: 15px; font-weight: 700; color: #1e1f29; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px; }
.card-title .fa { color: #D10024; }

.order-header-meta { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 6px; align-items: flex-end; }
.meta-item { display: flex; flex-direction: column; justify-content: flex-end; }
.meta-item label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: .5px; font-weight: 600; display: block; margin-bottom: 4px; }
.meta-item value { font-size: 14px; font-weight: 600; color: #1e1f29; }

.status-badge {
    display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 10px;
    font-weight: 700; color: #fff; letter-spacing: .4px;
}

/* Status Timeline */
.status-timeline { display: flex; align-items: flex-start; gap: 0; margin: 20px 0; overflow-x: auto; padding-bottom: 8px; }
.status-step { display: flex; flex-direction: column; align-items: center; flex: 1; min-width: 80px; }
.status-step-icon {
    width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center;
    justify-content: center; font-size: 14px; z-index: 1; position: relative;
    border: 2px solid #ddd; background: #fff; color: #ccc;
}
.status-step.done .status-step-icon { background: #10b981; border-color: #10b981; color: #fff; }
.status-step.current .status-step-icon { background: #D10024; border-color: #D10024; color: #fff; }
.status-step.cancelled .status-step-icon { background: #ef4444; border-color: #ef4444; color: #fff; }
.status-step-label { font-size: 11px; color: #888; text-align: center; margin-top: 6px; font-weight: 500; }
.status-step.done .status-step-label, .status-step.current .status-step-label { color: #1e1f29; font-weight: 600; }
.status-line { flex: 1; height: 2px; background: #eee; margin-top: 17px; align-self: flex-start; }
.status-line.done { background: #10b981; }

/* Items Table */
.items-table { width: 100%; border-collapse: collapse; }
.items-table th { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: .5px; font-weight: 600; padding: 10px 12px; border-bottom: 1px solid #eee; text-align: left; }
.items-table td { padding: 14px 12px; border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
.items-table tr:last-child td { border-bottom: none; }

.item-product { display: flex; align-items: center; gap: 12px; }
.item-img { width: 52px; height: 52px; border-radius: 6px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
.item-img img { width: 100%; height: 100%; object-fit: cover; }
.item-name { font-size: 14px; font-weight: 600; color: #1e1f29; }

.total-section { margin-top: 16px; padding-top: 16px; border-top: 1px solid #eee; }
.total-row { display: flex; justify-content: space-between; font-size: 13px; color: #555; margin-bottom: 8px; }
.total-row.grand { font-size: 16px; font-weight: 700; color: #1e1f29; padding-top: 12px; border-top: 2px solid #eee; margin-top: 4px; }
.total-row.grand span:last-child { color: #D10024; }

/* Info Lists */
.info-list { display: flex; flex-direction: column; gap: 12px; }
.info-row { display: flex; gap: 12px; }
.info-icon { width: 32px; height: 32px; background: #fff0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #D10024; flex-shrink: 0; }
.info-label { font-size: 11px; color: #888; margin-bottom: 2px; }
.info-value { font-size: 13px; font-weight: 600; color: #1e1f29; }

.tracking-box {
    background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 14px;
    display: flex; align-items: center; gap: 12px;
}
.tracking-box .fa { font-size: 24px; color: #0284c7; }
.tracking-box-text label { font-size: 11px; color: #0284c7; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 4px; }
.tracking-box-text span { font-size: 18px; font-weight: 700; color: #1e1f29; letter-spacing: 1px; }

.alert-success { background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px; }

.btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #f5f5f5; color: #555; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: background .15s; }
.btn-back:hover { background: #eee; }
.btn-shop-again { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #D10024; color: #fff; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: background .15s; }
.btn-shop-again:hover { background: #a8001e; }
.btn-received { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #10b981; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; transition: background .15s; }
.btn-received:hover { background: #059669; }
.btn-track { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #0284c7; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; text-decoration: none; transition: background .15s; }
.btn-track:hover { background: #0369a1; color: #fff; }
.order-actions-inline { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px; }
</style>
@endpush

@section('content')
<div class="container order-detail-page">
    <div class="breadcrumb">
        <a href="{{ route('orders.index') }}">Daftar Pembelian</a>
        <span>&rsaquo;</span>
        <span style="color:#333;">{{ $order->order_number }}</span>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="order-detail-layout">
        {{-- Kolom Kiri --}}
        <div>
            {{-- Header Pesanan --}}
            <div class="card">
                <div class="card-title"><i class="fa fa-file-text-o"></i> Detail Pesanan</div>

                <div class="order-header-meta">
                    <div class="meta-item">
                        <label>Nomor Pesanan</label>
                        <value>{{ $order->order_number }}</value>
                    </div>
                    <div class="meta-item">
                        <label>Tanggal Pesan</label>
                        <value>{{ $order->created_at->format('d M Y, H:i') }}</value>
                    </div>
                    <div class="meta-item">
                        <label>Status</label>
                        <span class="status-badge" style="background: {{ $order->status_color }};">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>

                {{-- Timeline Status --}}
                @php
                    $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                    $currentIdx = array_search($order->status, $statuses);
                    $isCancelled = $order->status === 'cancelled';
                @endphp

                @if(!$isCancelled)
                <div class="status-timeline">
                    @foreach($statuses as $idx => $s)
                        <div class="status-step @if($currentIdx > $idx) done @elseif($currentIdx == $idx) current @endif">
                            <div class="status-step-icon">
                                @if($s == 'pending') <i class="fa fa-clock-o"></i>
                                @elseif($s == 'processing') <i class="fa fa-cog"></i>
                                @elseif($s == 'shipped') <i class="fa fa-truck"></i>
                                @else <i class="fa fa-check"></i>
                                @endif
                            </div>
                            <div class="status-step-label">
                                @if($s == 'pending') Menunggu
                                @elseif($s == 'processing') Diproses
                                @elseif($s == 'shipped') Dikirim
                                @else Selesai
                                @endif
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="status-line @if($currentIdx > $idx) done @endif"></div>
                        @endif
                    @endforeach
                </div>
                @else
                <div style="background:#fee2e2;border-radius:8px;padding:12px 16px;color:#991b1b;font-size:13px;margin:12px 0;">
                    <i class="fa fa-times-circle"></i> Pesanan ini telah dibatalkan.
                </div>
                @endif

                {{-- Nomor Resi --}}
                @if($order->tracking_number)
                <div class="tracking-box">
                    <i class="fa fa-truck"></i>
                    <div class="tracking-box-text">
                        <label>Nomor Resi Pengiriman</label>
                        @if($order->courier_name)
                        <div style="font-size:11px;color:#6d28d9;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px">
                            {{ $order->courier_name }}
                        </div>
                        @endif
                        <span>{{ $order->tracking_number }}</span>
                    </div>
                </div>
                @endif

                {{-- Tombol konfirmasi & lacak (hanya saat status Dikirim) --}}
                @if($order->status === 'shipped')
                <div class="order-actions-inline">
                    <form method="POST" action="{{ route('orders.received', $order) }}" onsubmit="return confirm('Konfirmasi pesanan sudah diterima?')" style="margin:0">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-received">
                            <i class="fa fa-check-circle"></i> Pesanan Selesai
                        </button>
                    </form>
                    @if($order->tracking_number)
                    @php
                        $awb = urlencode($order->tracking_number);
                        $courier = strtolower($order->courier_name ?? '');
                        $trackUrl = match(true) {
                            str_contains($courier, 'jne')      => 'https://www.jne.co.id/id/tracking/trace/' . $awb,
                            str_contains($courier, 'j&t')      => 'https://jet.co.id/track',
                            str_contains($courier, 'sicepat')  => 'https://www.sicepat.com/checkAwb?awb=' . $awb,
                            str_contains($courier, 'anteraja') => 'https://anteraja.id/tracking/' . $awb,
                            str_contains($courier, 'pos')      => 'https://www.posindonesia.co.id/id/tracking?noResi=' . $awb,
                            str_contains($courier, 'ninja')    => 'https://www.ninjaxpress.co/id-id/tracking?id=' . $awb,
                            str_contains($courier, 'lion')     => 'https://lionparcel.com/track?awb=' . $awb,
                            str_contains($courier, 'tiki')     => 'https://tiki.id/id/tracking?airwaybill=' . $awb,
                            default                            => 'https://cekresi.com/?noresi=' . $awb,
                        };
                    @endphp
                    <a href="{{ $trackUrl }}" target="_blank" rel="noopener noreferrer" class="btn-track">
                        <i class="fa fa-external-link"></i> Lacak Paket
                    </a>
                    @endif
                </div>
                @endif
            </div>

            {{-- Daftar Item --}}
            <div class="card">
                <div class="card-title"><i class="fa fa-shopping-bag"></i> Item Pesanan</div>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="item-product">
                                    <div class="item-img">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}">
                                        @else
                                            <i class="fa fa-shopping-bag" style="color:#ccc;font-size:18px;"></i>
                                        @endif
                                    </div>
                                    <div class="item-name">{{ $item->product_name }}</div>
                                </div>
                            </td>
                            <td style="font-size:13px;color:#555;">{{ $item->formatted_price }}</td>
                            <td style="font-size:14px;font-weight:600;">{{ $item->quantity }}</td>
                            <td style="font-size:14px;font-weight:700;color:#D10024;">{{ $item->formatted_subtotal }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="total-section">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>{{ $order->formatted_total }}</span>
                    </div>
                    <div class="total-row">
                        <span>Ongkos Kirim</span>
                        <span style="color:#10b981;font-weight:600;">Gratis</span>
                    </div>
                    <div class="total-row grand">
                        <span>Total Pembayaran</span>
                        <span>{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                <a href="{{ route('orders.index') }}" class="btn-back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('products.index') }}" class="btn-shop-again">
                    <i class="fa fa-refresh"></i> Belanja Lagi
                </a>
            </div>
        </div>

        {{-- Kolom Kanan: Info --}}
        <div>
            {{-- Alamat Pengiriman --}}
            <div class="card">
                <div class="card-title"><i class="fa fa-map-marker"></i> Alamat Pengiriman</div>
                <div class="info-list">
                    <div class="info-row">
                        <div class="info-icon"><i class="fa fa-user"></i></div>
                        <div>
                            <div class="info-label">Nama Penerima</div>
                            <div class="info-value">{{ $order->shipping_name }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fa fa-phone"></i></div>
                        <div>
                            <div class="info-label">Telepon</div>
                            <div class="info-value">{{ $order->shipping_phone }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fa fa-home"></i></div>
                        <div>
                            <div class="info-label">Alamat</div>
                            <div class="info-value">{{ $order->shipping_address }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fa fa-building"></i></div>
                        <div>
                            <div class="info-label">Kota / Provinsi</div>
                            <div class="info-value">{{ $order->shipping_city }}, {{ $order->shipping_province }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Pembayaran --}}
            <div class="card">
                <div class="card-title"><i class="fa fa-credit-card"></i> Info Pembayaran</div>
                <div class="info-list">
                    <div class="info-row">
                        <div class="info-icon"><i class="fa fa-university"></i></div>
                        <div>
                            <div class="info-label">Metode</div>
                            <div class="info-value">
                                @if($order->payment_method === 'transfer')
                                    Transfer Bank Manual
                                @elseif($order->payment_method === 'virtual_account')
                                    Virtual Account {{ strtoupper($order->va_bank ?? '') }}
                                @else
                                    {{ ucfirst($order->payment_method) }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fa fa-money"></i></div>
                        <div>
                            <div class="info-label">Total Tagihan</div>
                            @if($order->payment_method === 'transfer' && $order->unique_code)
                            <div class="info-value" style="color:#D10024;font-size:16px;">{{ $order->formatted_transfer_amount }}</div>
                            @else
                            <div class="info-value" style="color:#D10024;font-size:16px;">{{ $order->formatted_total }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($order->payment_method === 'transfer')
                {{-- Unique code highlight --}}
                @if($order->unique_code)
                <div style="margin-top:14px;background:linear-gradient(135deg,#fff7ed,#fff);border:1.5px solid #fed7aa;border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:14px;">
                    <div style="flex-shrink:0;width:40px;height:40px;background:#f97316;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-tag" style="color:#fff;font-size:16px;"></i>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:11px;font-weight:700;color:#c2410c;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px;">Nominal Transfer Unik</div>
                        <div style="font-size:20px;font-weight:800;color:#1e1f29;letter-spacing:1px;">{{ $order->formatted_transfer_amount }}</div>
                        <div style="font-size:11px;color:#9a3412;margin-top:2px;">
                            Subtotal <strong>{{ $order->formatted_total }}</strong> + kode unik <strong>{{ $order->unique_code }}</strong>
                        </div>
                    </div>
                </div>
                @endif
                <div style="margin-top:12px;border:1px solid #e8e8e8;border-radius:8px;overflow:hidden;">
                    <div style="background:#f9f9f9;padding:8px 14px;font-size:11px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid #eee;">
                        <i class="fa fa-info-circle" style="color:#D10024;margin-right:4px;"></i> Rekening Tujuan Transfer
                    </div>
                    <div style="padding:10px 14px;display:flex;flex-direction:column;gap:8px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;">
                            <span style="color:#888;">Bank BCA</span>
                            <span style="font-weight:700;color:#1e1f29;letter-spacing:.5px;">1234567890</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;padding-top:6px;border-top:1px solid #f5f5f5;">
                            <span style="color:#888;">Bank Mandiri</span>
                            <span style="font-weight:700;color:#1e1f29;letter-spacing:.5px;">9876543210</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;padding-top:6px;border-top:1px solid #f5f5f5;">
                            <span style="color:#888;">Bank BNI</span>
                            <span style="font-weight:700;color:#1e1f29;letter-spacing:.5px;">1122334455</span>
                        </div>
                        <div style="padding-top:6px;border-top:1px solid #f5f5f5;font-size:12px;color:#888;">
                            Atas nama: <strong style="color:#1e1f29;">NusaMart</strong>
                        </div>
                    </div>
                </div>
                @endif

                @if($order->payment_method === 'virtual_account' && $order->virtual_account_number)
                @php
                    $vaBankName = match($order->va_bank) {
                        'bca'     => 'BCA',
                        'mandiri' => 'Mandiri',
                        'bni'     => 'BNI',
                        'bri'     => 'BRI',
                        default   => strtoupper($order->va_bank ?? ''),
                    };
                    $vaBankColor = match($order->va_bank) {
                        'bca'     => '#005baa',
                        'mandiri' => '#003d91',
                        'bni'     => '#f15a24',
                        'bri'     => '#00529b',
                        default   => '#3b82f6',
                    };
                @endphp
                <div style="margin-top:14px;border:2px solid #dbeafe;border-radius:10px;overflow:hidden;">
                    <div style="background:#eff6ff;padding:10px 14px;display:flex;align-items:center;gap:8px;border-bottom:1px solid #dbeafe;">
                        <div style="background:{{ $vaBankColor }};color:#fff;font-size:10px;font-weight:800;padding:4px 8px;border-radius:4px;letter-spacing:.5px;">
                            {{ $vaBankName }}
                        </div>
                        <span style="font-size:12px;font-weight:700;color:#1e40af;">Virtual Account {{ $vaBankName }}</span>
                    </div>
                    <div style="padding:16px 14px;text-align:center;">
                        <div style="font-size:11px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Nomor Virtual Account</div>
                        <div style="font-size:22px;font-weight:800;color:#1e1f29;letter-spacing:3px;font-family:monospace;">
                            {{ chunk_split($order->virtual_account_number, 4, ' ') }}
                        </div>
                        <button type="button"
                            onclick="navigator.clipboard.writeText('{{ $order->virtual_account_number }}');this.innerHTML='<i class=\'fa fa-check\'></i> Disalin!';"
                            style="margin-top:10px;padding:6px 16px;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:6px;color:#1d4ed8;font-size:12px;font-weight:600;cursor:pointer;">
                            <i class="fa fa-copy"></i> Salin Nomor
                        </button>
                        <div style="margin-top:10px;font-size:11px;color:#888;">
                            Atas nama: <strong style="color:#1e1f29;">NusaMart</strong>
                        </div>
                    </div>
                </div>
                @endif

                @if($order->status === 'pending')
                <div style="margin-top:12px;background:#fef3c7;border-radius:8px;padding:12px;font-size:12px;color:#92400e;">
                    <i class="fa fa-exclamation-triangle"></i>
                    <strong>Segera lakukan transfer</strong> sebesar <strong>{{ $order->formatted_total }}</strong>
                    ke rekening NusaMart. Pesanan akan dibatalkan jika tidak ada konfirmasi dalam 24 jam.
                </div>
                @endif
            </div>

            {{-- Catatan --}}
            @if($order->notes)
            <div class="card">
                <div class="card-title"><i class="fa fa-sticky-note-o"></i> Catatan</div>
                <p style="font-size:13px;color:#555;line-height:1.6;">{{ $order->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>


@endsection
