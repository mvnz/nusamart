@extends('layouts.seller')

@section('title', 'Promo Produk - Seller Center NusaMart')

@section('breadcrumb')Promo / <strong>Daftar Promo</strong>@endsection

@section('content')

<style>
    .promo-container { max-width: 100%; }
    .promo-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .promo-header h1 { margin: 0; font-size: 24px; font-weight: 800; color: #1e1f29; }
    
    .filter-bar { background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.05); margin-bottom: 20px; display: flex; gap: 12px; }
    .filter-input { flex: 1; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; }
    .filter-input:focus { outline: none; border-color: #D10024; }
    .filter-select { padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; cursor: pointer; }
    
    .btn-add { background: #D10024; color: #fff; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    .btn-add:hover { background: #a8001e; }
    
    .promo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
    .promo-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.05); transition: box-shadow .2s; }
    .promo-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.1); }
    
    .promo-header-card { padding: 16px; background: linear-gradient(135deg, #D10024, #ff6b6b); color: #fff; }
    .promo-product-name { font-size: 14px; font-weight: 600; margin-bottom: 4px; }
    .promo-status-badge { display: inline-block; padding: 4px 12px; background: rgba(255,255,255,.2); border-radius: 20px; font-size: 11px; font-weight: 700; }
    
    .promo-body { padding: 16px; }
    .promo-price-row { display: flex; gap: 10px; align-items: baseline; margin-bottom: 12px; flex-wrap: wrap; }
    .promo-price-old { font-size: 13px; text-decoration: line-through; color: #9aa0a6; margin-right: 6px; }
    .promo-price-arrow { color: #666; font-size: 14px; margin: 0 6px; }
    .promo-price-new { font-size: 18px; font-weight: 800; color: #D10024; }
    .promo-discount-badge { background: #FFE5E5; color: #D10024; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 700; margin-left: 8px; }
    
    .promo-info { font-size: 13px; color: #666; margin-bottom: 10px; line-height: 1.6; }
    .promo-info-label { font-weight: 600; color: #333; }
    
    .promo-quota { background: #f4f5f7; padding: 10px; border-radius: 8px; font-size: 12px; color: #666; margin-bottom: 12px; }
    .quota-bar { width: 100%; height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden; margin-top: 6px; }
    .quota-fill { height: 100%; background: #D10024; }
    
    .promo-actions { display: flex; gap: 8px; }
    .btn-sm { flex: 1; padding: 8px 12px; border: none; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px; transition: all .2s; }
    .btn-edit { background: #dbeafe; color: #1e40af; }
    .btn-edit:hover { background: #bfdbfe; }
    .btn-deactivate { background: #fecaca; color: #991b1b; }
    .btn-deactivate:hover { background: #fca5a5; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
    .btn-delete:hover { background: #fecaca; }
    
    .empty-state { text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; }
    .empty-icon { font-size: 48px; color: #e5e7eb; margin-bottom: 12px; }
    .empty-text { color: #aaa; font-size: 14px; }
    
    .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    .status-active { background: #d1fae5; color: #065f46; }
    .status-scheduled { background: #fef3c7; color: #92400e; }
    .status-expired { background: #f3f4f6; color: #6b7280; }
    .status-inactive { background: #fee2e2; color: #991b1b; }
</style>

<div class="promo-container">
    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #10b981;">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="promo-header">
        <div>
            <h1>Promo Produk</h1>
            <p style="margin: 4px 0 0; color: #aaa; font-size: 13px;">Kelola promosi produk Anda</p>
        </div>
        <a href="{{ route('seller.promos.create') }}" class="btn-add">
            <i class="fa fa-plus"></i> Buat Promo
        </a>
    </div>

    <div class="filter-bar">
        <form method="GET" style="display: flex; gap: 12px; flex: 1;">
            <input type="text" name="search" placeholder="Cari produk..." class="filter-input" value="{{ request('search') }}" style="flex: 1;">
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Berakhir</option>
            </select>
        </form>
    </div>

    @if($promos->count() > 0)
        <div class="promo-grid">
            @foreach($promos as $promo)
                <div class="promo-card">
                    <div class="promo-header-card">
                        <div class="promo-product-name">{{ $promo->product->name }}</div>
                        <span class="promo-status-badge">
                            @if($promo->isActive())
                                ✓ Aktif
                            @elseif($promo->isScheduled())
                                ⏰ Terjadwal
                            @elseif($promo->isExpired())
                                ✕ Berakhir
                            @else
                                ✕ Nonaktif
                            @endif
                        </span>
                    </div>
                    
                    <div class="promo-body">
                        <div class="promo-price-row">
                            <span class="promo-price-old">Rp {{ number_format($promo->original_price, 0, ',', '.') }}</span>
                            <span class="promo-price-arrow">→</span>
                            <span class="promo-price-new">Rp {{ number_format($promo->promo_price, 0, ',', '.') }}</span>
                            <span class="promo-discount-badge">-{{ $promo->getDiscountPercentage() }}%</span>
                        </div>

                        <div class="promo-info">
                            <div><span class="promo-info-label">Periode:</span></div>
                            <div style="font-size: 12px; color: #999;">
                                {{ $promo->start_date->format('d/m/Y H:i') }} - {{ $promo->end_date->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        @if($promo->quota > 0)
                            <div class="promo-quota">
                                Kuota: {{ $promo->used_quota }}/{{ $promo->quota }}
                                <div class="quota-bar">
                                    <div class="quota-fill" style="width: {{ ($promo->used_quota / $promo->quota * 100) }}%"></div>
                                </div>
                            </div>
                        @else
                            <div class="promo-quota">Kuota: Unlimited ∞</div>
                        @endif

                        <div class="promo-actions">
                            @if(!$promo->isExpired() && !$promo->isActive())
                                <a href="{{ route('seller.promos.edit', $promo->id) }}" class="btn-sm btn-edit">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            @endif
                            
                            @if($promo->is_active && !$promo->isExpired())
                                <form method="POST" action="{{ route('seller.promos.deactivate', $promo->id) }}" style="flex: 1;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-sm btn-deactivate" style="width: 100%;">
                                        <i class="fa fa-times"></i> Nonaktif
                                    </button>
                                </form>
                            @elseif(!$promo->is_active && !$promo->isExpired())
                                <form method="POST" action="{{ route('seller.promos.activate', $promo->id) }}" style="flex: 1;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-sm" style="background: #d1fae5; color: #065f46; flex: 1; border: none; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer;">
                                        <i class="fa fa-check"></i> Aktif
                                    </button>
                                </form>
                            @endif
                            
                            <form method="POST" action="{{ route('seller.promos.destroy', $promo->id) }}" style="flex: 1; display: flex;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-delete" style="width: 100%;" onclick="return confirm('Hapus promo ini?')">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($promos->hasPages())
            <div style="text-align: center; margin-top: 30px;">
                {{ $promos->render() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fa fa-tag"></i></div>
            <p class="empty-text">Anda belum membuat promo apapun. <a href="{{ route('seller.promos.create') }}" style="color: #D10024; text-decoration: none; font-weight: 600;">Buat sekarang</a></p>
        </div>
    @endif
</div>

@endsection
