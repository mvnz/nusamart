{{-- ============ PEMBELI DASHBOARD ============ --}}
@php
    $user = auth()->user();
    $orders = $user->orders()->latest()->take(5)->get();
    $totalOrders = $user->orders()->count();
    $pendingOrders = $user->orders()->where('status', 'pending')->count();
    $completedOrders = $user->orders()->where('status', 'delivered')->count();
    $cartCount = $user->carts()->sum('quantity');
@endphp

<style>
.pembeli-dash { padding: 28px 0 60px; background:#f5f6fa; min-height:60vh; }
.welcome-bar {
    background: linear-gradient(135deg, #1a0533 0%, #D10024 55%, #ff6b35 100%);
    color: #fff; border-radius: 22px; padding: 32px 36px;
    margin-bottom: 28px; overflow:hidden; position:relative;
}
.wb-blob { position:absolute; border-radius:50%; background:rgba(255,255,255,.07); animation:wbBlob 4s ease-in-out infinite; pointer-events:none; }
.wb-blob.b1 { width:280px;height:280px;top:-80px;right:-50px;animation-delay:0s; }
.wb-blob.b2 { width:180px;height:180px;bottom:-60px;left:4%;animation-delay:1.5s; }
.wb-blob.b3 { width:110px;height:110px;top:15px;left:38%;animation-delay:.8s; }
@keyframes wbBlob { 0%,100%{transform:scale(1);opacity:.6} 50%{transform:scale(1.2);opacity:1} }
.wb-inner { position:relative;z-index:2;display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap; }
.welcome-bar h2 { font-size: 22px; font-weight: 900; margin-bottom: 4px; text-shadow:0 3px 14px rgba(0,0,0,.3); }
.welcome-bar p { font-size: 13px; opacity: .85; }
.welcome-bar .btn-shop-now {
    padding: 12px 24px; background: rgba(255,255,255,.18);
    border:1.5px solid rgba(255,255,255,.35);
    backdrop-filter:blur(8px);
    color: #fff;
    border-radius: 12px; font-size: 14px; font-weight: 700;
    text-decoration: none; white-space: nowrap;
    transition: background .2s;
}
.welcome-bar .btn-shop-now:hover { background: rgba(255,255,255,.28); color:#fff; }

.dash-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
@media(max-width:768px){ .dash-stats { grid-template-columns: repeat(2, 1fr); } }

.stat-card {
    border-radius: 20px; padding: 22px 20px;
    box-shadow: 0 6px 24px rgba(0,0,0,.13);
    border: none;
    display: flex; flex-direction: column; gap: 0;
    transition: transform .22s, box-shadow .22s;
    position: relative; overflow: hidden;
    min-height: 130px; justify-content: space-between;
}
.stat-card:hover { transform:translateY(-5px); box-shadow:0 16px 36px rgba(0,0,0,.18); }
.stat-card.c-red    { background: linear-gradient(135deg,#D10024 0%,#ff6b6b 100%); }
.stat-card.c-yellow { background: linear-gradient(135deg,#b45309 0%,#fbbf24 100%); }
.stat-card.c-green  { background: linear-gradient(135deg,#065f46 0%,#34d399 100%); }
.stat-card.c-purple { background: linear-gradient(135deg,#4c1d95 0%,#a78bfa 100%); }
.stat-card .stat-icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; font-size: 18px;
    background: rgba(255,255,255,.2); color: #fff;
    backdrop-filter: blur(6px); border:1.5px solid rgba(255,255,255,.3);
    margin-bottom: 14px;
}
.stat-card .stat-num { font-size: 34px; font-weight: 900; color: #fff; line-height:1; text-shadow:0 2px 8px rgba(0,0,0,.2); }
.stat-card .stat-label { font-size: 13px; font-weight: 700; color: rgba(255,255,255,.9); margin-top: 4px; }
.stat-card .stat-deco { position:absolute;right:-12px;bottom:-12px;font-size:88px;opacity:.13;color:#fff;pointer-events:none;line-height:1; }

.dash-grid { display: grid; grid-template-columns: 1fr 280px; gap: 20px; }
@media(max-width:900px){ .dash-grid { grid-template-columns: 1fr; } }

.dash-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.07); }
.dash-card-header {
    padding: 18px 20px; border-bottom: 1px solid #eee;
    display: flex; justify-content: space-between; align-items: center;
}
.dash-card-header h3 { font-size: 15px; font-weight: 700; color: #1e1f29; }
.dash-card-header a { font-size: 12px; color: #D10024; font-weight: 600; }

.order-row {
    padding: 14px 20px; display: flex; justify-content: space-between;
    align-items: center; border-bottom: 1px solid #f5f5f5;
}
.order-row:last-child { border-bottom: none; }
.order-row-num { font-size: 13px; font-weight: 600; color: #1e1f29; margin-bottom: 3px; }
.order-row-date { font-size: 11px; color: #aaa; }
.order-row-total { font-size: 13px; font-weight: 700; color: #D10024; }
.order-badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; color: #fff; }
.order-row-right { text-align: right; }

.empty-row { padding: 30px 20px; text-align: center; color: #999; font-size: 13px; }
.empty-row .fa { font-size: 32px; color: #e0e0e0; display: block; margin-bottom: 10px; }

.quick-links { padding: 20px; display: flex; flex-direction: column; gap: 10px; }
.quick-link {
    display: flex; align-items: center; gap: 12px; padding: 12px 14px;
    border-radius: 8px; background: #f9f9f9; text-decoration: none; color: #333;
    font-size: 13px; font-weight: 600; transition: background .15s;
}
.quick-link:hover { background: #fff0f0; color: #D10024; }
.quick-link .fa { font-size: 16px; width: 20px; text-align: center; color: #D10024; }
.quick-link .ql-count {
    margin-left: auto; background: #D10024; color: #fff;
    font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 20px;
}

/* Product list styles */
.produk-section { margin-top: 32px; }
.produk-section-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 18px; flex-wrap: wrap; gap: 12px;
}
.produk-section-header h3 { font-size: 18px; font-weight: 700; color: #1e1f29; }
.produk-section-header a { font-size: 13px; color: #D10024; font-weight: 600; text-decoration: none; }
.produk-section-header a:hover { text-decoration: underline; }

.produk-filter-bar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
.produk-filter-bar form { display: flex; gap: 8px; flex-wrap: wrap; flex: 1; }
.produk-filter-bar input, .produk-filter-bar select {
    padding: 8px 14px; border: 1.5px solid #e0e0e0; border-radius: 8px;
    font-size: 13px; outline: none; transition: border .2s; background: #fff;
}
.produk-filter-bar input { flex: 1; min-width: 160px; }
.produk-filter-bar input:focus, .produk-filter-bar select:focus { border-color: #D10024; }
.produk-filter-bar button {
    padding: 8px 18px; background: #D10024; color: #fff;
    border: none; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600;
    transition: background .2s;
}
.produk-filter-bar button:hover { background: #a8001e; }

.produk-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 18px;
}
@media(max-width:768px) { .produk-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } }
@media(max-width:480px) { .produk-grid { grid-template-columns: 1fr; } }

.produk-card {
    background: #fff; border-radius: 12px; overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,.07); transition: transform .2s, box-shadow .2s;
    display: flex; flex-direction: column; position: relative;
}
.produk-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }
.produk-card-img {
    height: 170px; background: #f5f5f5; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
}
.produk-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
.produk-card:hover .produk-card-img img { transform: scale(1.05); }
.produk-card-img .no-img { font-size: 48px; color: #ccc; }
.produk-card-body { padding: 14px; flex: 1; display: flex; flex-direction: column; }
.produk-card-cat { font-size: 11px; color: #D10024; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
.produk-card-name { font-size: 14px; font-weight: 700; color: #1e1f29; line-height: 1.4; margin-bottom: 4px; }
.produk-card-seller { font-size: 11px; color: #aaa; margin-bottom: 8px; }
.produk-card-price { font-size: 16px; font-weight: 800; color: #D10024; margin-bottom: 4px; }
.produk-card-rating { display: flex; align-items: center; gap: 4px; font-size: 12px; margin-bottom: 4px; min-height: 18px; }
.produk-card-rating .pcr-star { color: #f59e0b; font-size: 13px; }
.produk-card-rating .pcr-val { font-weight: 700; color: #1e1f29; }
.produk-card-rating .pcr-count { color: #aaa; }
.produk-card-rating .pcr-sep { color: #ccc; }
.produk-card-rating .pcr-sold { color: #888; font-size: 11px; }
.produk-card-stock { font-size: 11px; margin-bottom: 10px; }
.produk-card-stock.ok { color: #10b981; }
.produk-card-stock.low { color: #f59e0b; }
.produk-card-stock.out { color: #ef4444; }
.btn-produk-detail {
    display: block; text-align: center; padding: 9px;
    background: #1e1f29; color: #fff; border-radius: 8px;
    font-size: 13px; font-weight: 600; text-decoration: none;
    transition: background .2s; margin-top: auto;
}
.btn-produk-detail::after { content: ''; position: absolute; inset: 0; z-index: 1; }
.btn-produk-detail:hover { background: #D10024; color: #fff; }

.produk-empty { text-align: center; padding: 48px 20px; color: #aaa; }
.produk-empty .fa { font-size: 48px; display: block; margin-bottom: 12px; color: #e0e0e0; }

.produk-pagination { margin-top: 24px; display: flex; justify-content: center; }
</style>

<div class="pembeli-dash">
    <div class="welcome-bar">
        <div class="wb-blob b1"></div>
        <div class="wb-blob b2"></div>
        <div class="wb-blob b3"></div>
        <div class="wb-inner">
            <div>
                <h2>Halo, {{ $user->name }}! 👋</h2>
                <p>Selamat datang di NusaMart. Temukan produk terbaik pilihan Anda.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn-shop-now">
                <i class="fa fa-shopping-bag"></i> Belanja Sekarang
            </a>
        </div>
    </div>

    <div class="dash-stats">
        <div class="stat-card c-red">
            <div class="stat-deco"><i class="fa fa-shopping-bag"></i></div>
            <div class="stat-icon"><i class="fa fa-shopping-bag"></i></div>
            <div class="stat-num">{{ $totalOrders }}</div>
            <div class="stat-label">Total Pembelian</div>
        </div>
        <div class="stat-card c-yellow">
            <div class="stat-deco"><i class="fa fa-clock-o"></i></div>
            <div class="stat-icon"><i class="fa fa-clock-o"></i></div>
            <div class="stat-num">{{ $pendingOrders }}</div>
            <div class="stat-label">Menunggu Konfirmasi</div>
        </div>
        <div class="stat-card c-green">
            <div class="stat-deco"><i class="fa fa-check-circle"></i></div>
            <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
            <div class="stat-num">{{ $completedOrders }}</div>
            <div class="stat-label">Pesanan Selesai</div>
        </div>
        <div class="stat-card c-purple">
            <div class="stat-deco"><i class="fa fa-shopping-cart"></i></div>
            <div class="stat-icon"><i class="fa fa-shopping-cart"></i></div>
            <div class="stat-num">{{ $cartCount }}</div>
            <div class="stat-label">Item di Keranjang</div>
        </div>
    </div>

    <div class="dash-grid">
        {{-- Pesanan Terbaru --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <h3><i class="fa fa-list-alt" style="color:#D10024;margin-right:6px;"></i> Pesanan Terbaru</h3>
                <a href="{{ route('orders.index') }}">Lihat Semua →</a>
            </div>
            @forelse($orders as $order)
            <div class="order-row">
                <div>
                    <div class="order-row-num">{{ $order->order_number }}</div>
                    <div class="order-row-date">{{ $order->created_at->format('d M Y') }}</div>
                </div>
                <div class="order-row-right">
                    <div class="order-row-total">{{ $order->formatted_total }}</div>
                    <span class="order-badge" style="background:{{ $order->status_color }};">{{ $order->status_label }}</span>
                </div>
            </div>
            @empty
            <div class="empty-row">
                <i class="fa fa-shopping-bag"></i>
                Belum ada pesanan.<br>
                <a href="{{ route('products.index') }}" style="color:#D10024;font-weight:600;">Mulai belanja</a>
            </div>
            @endforelse
        </div>

        {{-- Quick Links --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <h3><i class="fa fa-th-large" style="color:#D10024;margin-right:6px;"></i> Menu Cepat</h3>
            </div>
            <div class="quick-links">
                <a href="{{ route('products.index') }}" class="quick-link">
                    <i class="fa fa-store"></i> Jelajahi Produk
                </a>
                <a href="{{ route('cart.index') }}" class="quick-link">
                    <i class="fa fa-shopping-cart"></i> Keranjang Saya
                    @if($cartCount > 0)
                        <span class="ql-count">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('orders.index') }}" class="quick-link">
                    <i class="fa fa-list-alt"></i> Daftar Pesanan
                    @if($totalOrders > 0)
                        <span class="ql-count">{{ $totalOrders }}</span>
                    @endif
                </a>
                <a href="{{ route('profile') }}" class="quick-link">
                    <i class="fa fa-user-circle"></i> Profil Saya
                </a>
            </div>
        </div>
    </div>

    {{-- Produk Tersedia --}}
    <div class="produk-section">
        <div class="produk-section-header">
            <h3><i class="fa fa-shopping-bag" style="color:#D10024;margin-right:8px"></i>Produk Tersedia</h3>
            <a href="{{ route('products.index') }}">Lihat Semua <i class="fa fa-arrow-right"></i></a>
        </div>

        <div class="produk-filter-bar">
            <form action="{{ route('dashboard') }}" method="GET">
                <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                <select name="category_id">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"><i class="fa fa-search"></i> Cari</button>
            </form>
        </div>

        @if($products->isEmpty())
            <div class="produk-empty">
                <i class="fa fa-shopping-bag"></i>
                <div style="font-size:14px;font-weight:600;color:#bbb">Belum ada produk tersedia saat ini.</div>
            </div>
        @else
            <div class="produk-grid">
                @foreach($products as $product)
                <div class="produk-card">
                    <div class="produk-card-img">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <i class="fa fa-shopping-bag no-img"></i>
                        @endif
                    </div>
                    <div class="produk-card-body">
                        @if($product->category)
                            <div class="produk-card-cat">{{ $product->category->name }}</div>
                        @endif
                        <div class="produk-card-name">{{ $product->name }}</div>
                        <div class="produk-card-seller"><i class="fa fa-store" style="margin-right:4px"></i>{{ $product->seller->name }}</div>
                        <div class="produk-card-price">{{ $product->formatted_price }}</div>
                        <div class="produk-card-rating">
                            @if($product->reviews_count > 0)
                            <span class="pcr-star">&#9733;</span>
                            <span class="pcr-val">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                            @endif
                            @if(($product->order_items_count ?? 0) > 0)
                            @if($product->reviews_count > 0)<span class="pcr-sep">&middot;</span>@endif
                            <span class="pcr-sold">{{ $product->order_items_count }} terjual</span>
                            @endif
                        </div>
                        <div class="produk-card-stock @if($product->stock == 0) out @elseif($product->stock <= 5) low @else ok @endif">
                            @if($product->stock == 0)
                                <i class="fa fa-times-circle"></i> Stok habis
                            @elseif($product->stock <= 5)
                                <i class="fa fa-exclamation-triangle"></i> Sisa {{ $product->stock }}
                            @else
                                <i class="fa fa-check-circle"></i> Stok: {{ $product->stock }}
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product) }}" class="btn-produk-detail">Lihat Detail</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="produk-pagination">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
