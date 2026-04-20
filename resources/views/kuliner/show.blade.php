@extends('layouts.app')

@section('title', $kuliner->nama . ' - Kuliner Lokal NusaMart')

@push('styles')
<style>
.kuliner-detail-page { padding: 30px 0 60px; }
.breadcrumb { font-size: 13px; color: #888; margin-bottom: 24px; }
.breadcrumb a { color: #D10024; text-decoration: none; }
.breadcrumb a:hover { text-decoration: underline; }
.breadcrumb span { margin: 0 6px; }

.kuliner-detail { display: grid; grid-template-columns: 1fr 1fr; gap: 36px; align-items: start; }
@media(max-width: 768px) { .kuliner-detail { grid-template-columns: 1fr; } }

.kuliner-img-box {
    background: #f5f5f5;
    border-radius: 14px;
    overflow: hidden;
    aspect-ratio: 4/3;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 12px rgba(0,0,0,.08);
}
.kuliner-img-box img { width: 100%; height: 100%; object-fit: cover; }
.kuliner-img-box .no-img { font-size: 80px; color: #ddd; }

.kuliner-info { display: flex; flex-direction: column; gap: 14px; }

.kuliner-kategori-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px; background: #fff7ed; color: #d97706;
    border-radius: 20px; font-size: 12px; font-weight: 700; width: fit-content;
}
.kuliner-title { font-size: 26px; font-weight: 800; color: #1e1f29; line-height: 1.3; margin: 0; }

.kuliner-status {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; width: fit-content;
}
.kuliner-status.buka  { background: #d1fae5; color: #065f46; }
.kuliner-status.tutup { background: #fee2e2; color: #991b1b; }

.kuliner-desc { font-size: 14px; color: #555; line-height: 1.7; }

.kuliner-meta { display: flex; flex-direction: column; gap: 10px; }
.kuliner-meta-row {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 14px; background: #f9f9f9; border-radius: 10px;
    font-size: 13px;
}
.kuliner-meta-icon {
    width: 34px; height: 34px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; flex-shrink: 0;
}
.kuliner-meta-icon.red    { background: #fee2e2; color: #D10024; }
.kuliner-meta-icon.orange { background: #fff7ed; color: #d97706; }
.kuliner-meta-icon.green  { background: #d1fae5; color: #059669; }
.kuliner-meta-icon.blue   { background: #dbeafe; color: #1d4ed8; }
.kuliner-meta-icon.purple { background: #ede9fe; color: #7c3aed; }

.kuliner-meta-label { font-size: 11px; color: #aaa; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
.kuliner-meta-value { font-weight: 600; color: #1e1f29; }
.kuliner-meta-value a { color: #D10024; text-decoration: none; }
.kuliner-meta-value a:hover { text-decoration: underline; }

.kuliner-maps { margin-top: 24px; }
.kuliner-maps-title { font-size: 15px; font-weight: 700; color: #1e1f29; margin-bottom: 12px; }
.kuliner-maps-link {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px; background: #D10024; color: #fff;
    border-radius: 8px; font-size: 13px; font-weight: 700;
    text-decoration: none; transition: background .2s;
}
.kuliner-maps-link:hover { background: #a8001e; }

.btn-back {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; background: #f4f5f7; color: #555;
    border-radius: 8px; font-size: 13px; font-weight: 700;
    text-decoration: none; transition: background .15s; margin-bottom: 24px;
}
.btn-back:hover { background: #e5e7eb; color: #1e1f29; }
</style>
@endpush

@section('content')
<div class="kuliner-detail-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('kuliner.index') }}">Kuliner Lokal</a>
            <span>›</span>
            <span>{{ $kuliner->nama }}</span>
        </div>

        <a href="{{ route('kuliner.index') }}" class="btn-back">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar
        </a>

        <div class="kuliner-detail">
            {{-- Gambar --}}
            <div class="kuliner-img-box">
                @if($kuliner->gambar && file_exists(public_path('uploads/' . $kuliner->gambar)))
                    <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}">
                @else
                    <i class="fa fa-cutlery no-img"></i>
                @endif
            </div>

            {{-- Info --}}
            <div class="kuliner-info">
                <div class="kuliner-kategori-badge">
                    <i class="fa fa-tag"></i> {{ $kuliner->kategori }}
                </div>

                <h1 class="kuliner-title">{{ $kuliner->nama }}</h1>

                <div class="kuliner-status {{ $kuliner->status }}">
                    <i class="fa fa-circle" style="font-size:9px"></i>
                    {{ $kuliner->status === 'buka' ? 'Sedang Buka' : 'Sedang Tutup' }}
                </div>

                <p class="kuliner-desc">{{ $kuliner->deskripsi }}</p>

                <div class="kuliner-meta">
                    <div class="kuliner-meta-row">
                        <div class="kuliner-meta-icon orange"><i class="fa fa-clock-o"></i></div>
                        <div>
                            <div class="kuliner-meta-label">Jam Operasional</div>
                            <div class="kuliner-meta-value">{{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }} WIB</div>
                        </div>
                    </div>
                    <div class="kuliner-meta-row">
                        <div class="kuliner-meta-icon red"><i class="fa fa-map-marker"></i></div>
                        <div>
                            <div class="kuliner-meta-label">Alamat</div>
                            <div class="kuliner-meta-value">{{ $kuliner->alamat }}</div>
                        </div>
                    </div>
                    <div class="kuliner-meta-row">
                        <div class="kuliner-meta-icon green"><i class="fa fa-whatsapp"></i></div>
                        <div>
                            <div class="kuliner-meta-label">Kontak WhatsApp</div>
                            <div class="kuliner-meta-value">
                                <a href="https://wa.me/{{ $kuliner->kontak_wa }}" target="_blank" rel="noopener noreferrer">
                                    +{{ $kuliner->kontak_wa }} <i class="fa fa-external-link" style="font-size:11px"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if($kuliner->link_maps)
                <div class="kuliner-maps">
                    <a href="{{ $kuliner->link_maps }}" target="_blank" rel="noopener noreferrer" class="kuliner-maps-link">
                        <i class="fa fa-map-o"></i> Buka di Google Maps
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
