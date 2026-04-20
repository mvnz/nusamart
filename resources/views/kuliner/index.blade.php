@extends('layouts.app')

@section('title', 'Kuliner Lokal Manud Jaya - NusaMart')

@push('styles')
<style>
.kuliner-page { padding: 32px 0 56px; }
.kuliner-header { margin-bottom: 28px; }
.kuliner-header h2 { font-size: 24px; font-weight: 800; color: #1e1f29; }
.kuliner-header p { color: #888; font-size: 13px; margin-top: 6px; }

.kuliner-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 22px;
}

.kuliner-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
    transition: transform .2s, box-shadow .2s;
    text-decoration: none;
    color: inherit;
    display: block;
}
.kuliner-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }

.kuliner-card-img {
    height: 190px;
    background: #f5f5f5;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.kuliner-card-img img { width: 100%; height: 100%; object-fit: cover; }
.kuliner-card-img .no-img { font-size: 52px; color: #ddd; }

.kuliner-status-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}
.badge-buka  { background: #d1fae5; color: #065f46; }
.badge-tutup { background: #fee2e2; color: #991b1b; }

.kuliner-card-body { padding: 16px; }
.kuliner-card-kategori {
    font-size: 11px; color: #d97706; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px;
}
.kuliner-card-nama { font-size: 15px; font-weight: 700; color: #1e1f29; margin-bottom: 6px; line-height: 1.4; }
.kuliner-card-alamat { font-size: 12px; color: #888; display: flex; align-items: flex-start; gap: 5px; }
.kuliner-card-alamat i { margin-top: 2px; color: #D10024; flex-shrink: 0; }

.kuliner-card-footer {
    padding: 12px 16px;
    border-top: 1px solid #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    color: #888;
}
.kuliner-card-footer i { color: #D10024; }

.kuliner-empty { text-align: center; padding: 60px 20px; color: #999; }
.kuliner-empty .fa { font-size: 52px; margin-bottom: 16px; display: block; color: #ddd; }
.kuliner-empty h3 { font-size: 18px; color: #555; margin-bottom: 8px; }
</style>
@endpush

@section('content')
<div class="kuliner-page">
    <div class="container">
        <div class="kuliner-header">
            <h2><i class="fa fa-cutlery" style="color:#d97706"></i> Kuliner Lokal Manud Jaya</h2>
            <p>Temukan warung dan kuliner lokal pilihan dari Desa Manud Jaya</p>
        </div>

        @if($kuliners->isEmpty())
            <div class="kuliner-empty">
                <i class="fa fa-cutlery"></i>
                <h3>Belum ada kuliner terdaftar</h3>
                <p>Informasi warung lokal akan segera hadir.</p>
            </div>
        @else
            <div class="kuliner-grid">
                @foreach($kuliners as $kuliner)
                <a href="{{ route('kuliner.show', $kuliner->id) }}" class="kuliner-card">
                    <div class="kuliner-card-img">
                        @if($kuliner->gambar && file_exists(public_path('uploads/' . $kuliner->gambar)))
                            <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}">
                        @else
                            <i class="fa fa-cutlery no-img"></i>
                        @endif
                        <span class="kuliner-status-badge {{ $kuliner->status === 'buka' ? 'badge-buka' : 'badge-tutup' }}">
                            <i class="fa fa-circle" style="font-size:8px"></i>
                            {{ ucfirst($kuliner->status) }}
                        </span>
                    </div>
                    <div class="kuliner-card-body">
                        <div class="kuliner-card-kategori"><i class="fa fa-tag"></i> {{ $kuliner->kategori }}</div>
                        <div class="kuliner-card-nama">{{ $kuliner->nama }}</div>
                        <div class="kuliner-card-alamat">
                            <i class="fa fa-map-marker"></i>
                            <span>{{ Str::limit($kuliner->alamat, 60) }}</span>
                        </div>
                    </div>
                    <div class="kuliner-card-footer">
                        <span><i class="fa fa-clock-o"></i> {{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</span>
                        <span style="color:#D10024; font-weight:600; font-size:12px;">Lihat Detail <i class="fa fa-arrow-right"></i></span>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
