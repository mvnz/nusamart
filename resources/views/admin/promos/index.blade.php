@extends('layouts.admin')

@section('title', 'Monitor Promo - Admin Panel')

@section('content')

<style>
    .admin-promo-container { max-width: 100%; }
    .section-header { margin-bottom: 24px; }
    .section-title { font-size: 20px; font-weight: 800; color: #1e1f29; margin-bottom: 12px; }
    
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .stat-card { background: #fff; border-radius: 12px; padding: 18px; box-shadow: 0 2px 8px rgba(0,0,0,.05); }
    .stat-number { font-size: 28px; font-weight: 800; color: #D10024; margin-bottom: 4px; }
    .stat-label { font-size: 12px; color: #aaa; font-weight: 600; text-transform: uppercase; }
    
    .filter-bar { background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.05); margin-bottom: 20px; display: flex; gap: 12px; flex-wrap: wrap; }
    .filter-input { padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; flex: 1; min-width: 180px; }
    .filter-select { padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; cursor: pointer; }
    
    .table-container { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.05); }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f8f9fb; border-bottom: 1.5px solid #e5e7eb; padding: 14px 16px; text-align: left; font-weight: 700; font-size: 12px; color: #666; text-transform: uppercase; }
    td { padding: 14px 16px; border-bottom: 1px solid #f0f0f0; font-size: 13px; }
    tr:hover { background: #f8f9fb; }
    
    .product-col { display: flex; align-items: center; gap: 10px; }
    .product-img { width: 40px; height: 40px; border-radius: 6px; object-fit: cover; background: #f0f0f0; }
    
    .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    .status-active { background: #d1fae5; color: #065f46; }
    .status-scheduled { background: #fef3c7; color: #92400e; }
    .status-expired { background: #f3f4f6; color: #6b7280; }
    .status-inactive { background: #fee2e2; color: #991b1b; }
    
    .price-col { font-weight: 600; color: #D10024; }
    .discount-badge { background: #FFE5E5; color: #D10024; padding: 2px 8px; border-radius: 4px; font-weight: 600; font-size: 12px; }
    
    .action-buttons { display: flex; gap: 6px; }
    .btn-sm { padding: 6px 10px; border: none; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; gap: 3px; }
    .btn-view { background: #dbeafe; color: #1e40af; }
    .btn-deactivate { background: #fecaca; color: #991b1b; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
    
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-icon { font-size: 48px; color: #e5e7eb; margin-bottom: 12px; }
    .empty-text { color: #aaa; }
</style>

<div class="admin-promo-container">
    @php
        $stats = \App\Http\Controllers\Admin\AdminPromoController::getStats();
    @endphp

    <div class="section-header">
        <h1 class="section-title"><i class="fa fa-tag"></i> Monitor Promo</h1>
        <p style="color: #aaa; font-size: 13px; margin: 0;">Kelola dan monitor semua promo yang dibuat penjual</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['active'] }}</div>
            <div class="stat-label">Promo Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['scheduled'] }}</div>
            <div class="stat-label">Terjadwal</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['expired'] }}</div>
            <div class="stat-label">Berakhir</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['inactive'] }}</div>
            <div class="stat-label">Nonaktif</div>
        </div>
    </div>

    <div class="filter-bar">
        <form method="GET" style="display: flex; gap: 12px; flex: 1; flex-wrap: wrap;">
            <input type="text" name="search" placeholder="Cari produk atau penjual..." class="filter-input" value="{{ request('search') }}" style="flex: 1; min-width: 200px;">
            
            <select name="seller_id" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Penjual</option>
                @foreach($sellers as $seller)
                    <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                        {{ $seller->name }}
                    </option>
                @endforeach
            </select>
            
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Berakhir</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </form>
    </div>

    @if($promos->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Penjual</th>
                        <th>Harga</th>
                        <th>Periode</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promos as $promo)
                        <tr>
                            <td>
                                <div class="product-col">
                                    @if($promo->product->image)
                                        <img src="{{ asset('storage/' . $promo->product->image) }}" alt="" class="product-img">
                                    @else
                                        <div class="product-img" style="display: flex; align-items: center; justify-content: center; color: #ccc;">
                                            <i class="fa fa-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight: 600;">{{ $promo->product->name }}</div>
                                        <div style="font-size: 11px; color: #aaa;">ID: {{ $promo->product->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $promo->seller->name }}</div>
                                <div style="font-size: 11px; color: #aaa;">{{ $promo->seller->email }}</div>
                            </td>
                            <td>
                                <div class="price-col">Rp {{ number_format($promo->promo_price, 0, ',', '.') }}</div>
                                <span class="discount-badge">-{{ $promo->getDiscountPercentage() }}%</span>
                            </td>
                            <td>
                                <div style="font-size: 12px;">
                                    {{ $promo->start_date->format('d/m/Y') }}<br>
                                    s/d {{ $promo->end_date->format('d/m/Y') }}
                                </div>
                            </td>
                            <td>
                                @if($promo->quota > 0)
                                    {{ $promo->used_quota }}/{{ $promo->quota }}
                                @else
                                    <span style="color: #aaa;">Unlimited</span>
                                @endif
                            </td>
                            <td>
                                @if($promo->isActive())
                                    <span class="status-badge status-active">✓ Aktif</span>
                                @elseif($promo->isScheduled())
                                    <span class="status-badge status-scheduled">⏰ Terjadwal</span>
                                @elseif($promo->isExpired())
                                    <span class="status-badge status-expired">✕ Berakhir</span>
                                @else
                                    <span class="status-badge status-inactive">✕ Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.promos.show', $promo->id) }}" class="btn-sm btn-view">
                                        <i class="fa fa-eye"></i> Lihat
                                    </a>
                                    
                                    @if($promo->is_active)
                                        <form method="POST" action="{{ route('admin.promos.deactivate', $promo->id) }}" style="display: inline;">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-sm btn-deactivate" onclick="return confirm('Nonaktifkan promo ini?')">
                                                <i class="fa fa-times"></i> Matikan
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.promos.activate', $promo->id) }}" style="display: inline;">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-sm" style="background: #d1fae5; color: #065f46; border: none; border-radius: 6px; font-size: 11px; font-weight: 700; padding: 6px 10px;">
                                                <i class="fa fa-check"></i> Nyalakan
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('admin.promos.destroy', $promo->id) }}" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Hapus promo ini?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($promos->hasPages())
            <div style="text-align: center; margin-top: 20px;">
                {{ $promos->render() }}
            </div>
        @endif
    @else
        <div class="table-container">
            <div class="empty-state">
                <div class="empty-icon"><i class="fa fa-inbox"></i></div>
                <p class="empty-text">Tidak ada promo yang ditemukan</p>
            </div>
        </div>
    @endif
</div>

@endsection
