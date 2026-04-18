@extends('layouts.app')

@section('title', $product->name . ' - NusaMart')

@push('styles')
<style>
.product-detail-page { padding: 30px 0 60px; }
.breadcrumb { font-size: 13px; color: #888; margin-bottom: 24px; }
.breadcrumb a { color: #D10024; }
.breadcrumb span { margin: 0 6px; }

.product-detail { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
@media(max-width:768px){ .product-detail { grid-template-columns: 1fr; } }

.product-image-box {
    background: #fff; border-radius: 12px; overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.08);
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
}
.product-image-box img { width: 100%; height: 100%; object-fit: cover; }
.product-image-box .no-img { font-size: 80px; color: #ccc; }

.product-info { display: flex; flex-direction: column; gap: 16px; }
.product-category-badge {
    display: inline-block; padding: 4px 12px; background: #fff0f0; color: #D10024;
    border-radius: 20px; font-size: 12px; font-weight: 600; width: fit-content;
}
.product-title { font-size: 24px; font-weight: 700; color: #1e1f29; line-height: 1.3; }
.product-seller { font-size: 13px; color: #888; }
.product-seller a { color: #D10024; font-weight: 600; }
.product-price { font-size: 28px; font-weight: 800; color: #D10024; }

.product-stock-info {
    display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500;
    padding: 10px 14px; border-radius: 8px;
}
.product-stock-info.available { background: #d1fae5; color: #065f46; }
.product-stock-info.low { background: #fef3c7; color: #92400e; }
.product-stock-info.out { background: #fee2e2; color: #991b1b; }

.product-description { font-size: 14px; color: #555; line-height: 1.7; }
.product-description h4 { font-size: 15px; font-weight: 600; color: #1e1f29; margin-bottom: 8px; }

.add-to-cart-form { display: flex; flex-direction: column; gap: 12px; }
.qty-row { display: flex; align-items: center; gap: 10px; }
.qty-label { font-size: 13px; font-weight: 600; color: #555; }
.qty-control { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
.qty-btn {
    width: 36px; height: 36px; background: #f5f5f5; border: none; cursor: pointer;
    font-size: 16px; font-weight: 600; color: #333; transition: background .15s;
}
.qty-btn:hover { background: #e0e0e0; }
.qty-input {
    width: 50px; height: 36px; text-align: center; border: none; border-left: 1px solid #ddd;
    border-right: 1px solid #ddd; font-family: inherit; font-size: 14px; font-weight: 600;
    outline: none;
}

.btn-add-cart {
    padding: 14px 28px; background: #fff; color: #D10024; border: 2px solid #D10024; border-radius: 8px;
    font-family: inherit; font-size: 15px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px; transition: background .2s, color .2s;
    flex: 1;
}
.btn-add-cart:hover { background: #fff0f0; }
.btn-add-cart:disabled { border-color: #ccc; color: #9ca3af; cursor: not-allowed; }

.btn-buy-now {
    padding: 14px 28px; background: #D10024; color: #fff; border: none; border-radius: 8px;
    font-family: inherit; font-size: 15px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px; transition: background .2s;
    flex: 1;
}
.btn-buy-now:hover { background: #a8001e; }
.btn-buy-now:disabled { background: #ccc; cursor: not-allowed; }

.btn-wishlist {
    width: 50px; height: 50px; background: #fff; border: 2px solid #e5e7eb; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; cursor: pointer;
    font-size: 18px; transition: border-color .2s, color .2s; flex-shrink: 0;
}
.btn-wishlist:hover { border-color: #D10024; color: #D10024; }
.btn-wishlist.active { border-color: #D10024; color: #D10024; background: #fff0f0; }

.btn-action-row { display: flex; gap: 10px; align-items: stretch; }

.btn-out-of-stock {
    padding: 14px 28px; background: #e5e7eb; color: #9ca3af; border: none; border-radius: 8px;
    font-family: inherit; font-size: 15px; font-weight: 700; cursor: not-allowed;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}

.alert-success { background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px; }
.alert-error { background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px; }

/* ===== ULASAN PEMBELI ===== */
.rv-section { margin-top: 40px; background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.07); overflow: hidden; }
.rv-section-header { padding: 20px 24px 0; border-bottom: 1px solid #f3f4f6; }
.rv-section-title { font-size: 15px; font-weight: 800; color: #1e1f29; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 16px; }

/* Summary box */
.rv-summary { display: flex; gap: 32px; align-items: center; padding: 20px 24px; border-bottom: 1px solid #f3f4f6; flex-wrap: wrap; }
.rv-avg-block { text-align: center; min-width: 90px; }
.rv-avg-num { font-size: 42px; font-weight: 800; color: #1e1f29; line-height: 1; }
.rv-avg-denom { font-size: 14px; color: #aaa; font-weight: 600; }
.rv-avg-stars { color: #f59e0b; font-size: 20px; margin: 4px 0; }
.rv-avg-count { font-size: 12px; color: #888; }

.rv-bars { flex: 1; min-width: 200px; display: flex; flex-direction: column; gap: 7px; }
.rv-bar-row { display: flex; align-items: center; gap: 10px; }
.rv-bar-label { font-size: 13px; color: #f59e0b; width: 14px; text-align: right; flex-shrink: 0; }
.rv-bar-track { flex: 1; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden; }
.rv-bar-fill { height: 100%; background: #10b981; border-radius: 4px; transition: width .4s; }
.rv-bar-count { font-size: 12px; color: #888; width: 30px; text-align: right; flex-shrink: 0; }

/* Review list */
.rv-list { padding: 0 24px; }
.rv-item { padding: 20px 0; border-bottom: 1px solid #f3f4f6; }
.rv-item:last-child { border-bottom: none; }
.rv-item-head { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
.rv-avatar { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg,#D10024,#ff6b6b); color: #fff; font-size: 15px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rv-user-name { font-size: 14px; font-weight: 700; color: #1e1f29; }
.rv-product-label { font-size: 12px; color: #888; margin-top: 2px; }
.rv-meta { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.rv-stars-small { color: #f59e0b; font-size: 14px; letter-spacing: 1px; }
.rv-date { font-size: 12px; color: #aaa; }
.rv-comment { font-size: 14px; color: #555; line-height: 1.6; margin-top: 6px; }

.rv-empty { text-align: center; padding: 48px 24px; color: #aaa; }
.rv-empty i { font-size: 40px; margin-bottom: 12px; display: block; color: #e5e7eb; }

/* Filter bintang */
.rv-filter { display: flex; gap: 8px; flex-wrap: wrap; padding: 14px 24px; border-bottom: 1px solid #f3f4f6; align-items: center; }
.rv-filter-label { font-size: 12px; font-weight: 700; color: #888; text-transform: uppercase; margin-right: 4px; }
.rv-filter-btn { display: inline-flex; align-items: center; gap: 4px; padding: 6px 14px; border: 1.5px solid #e5e7eb; border-radius: 20px; font-size: 13px; font-weight: 600; color: #555; background: #fff; cursor: pointer; transition: all .15s; white-space: nowrap; }
.rv-filter-btn:hover { border-color: #f59e0b; color: #92400e; }
.rv-filter-btn.active { border-color: #f59e0b; background: #fef3c7; color: #92400e; }
.rv-filter-btn .rv-filter-star { color: #f59e0b; }
.rv-filter-count { font-size: 11px; color: #aaa; margin-left: 2px; }

.rv-no-result { display: none; text-align: center; padding: 40px 24px; color: #aaa; }
.rv-no-result i { font-size: 32px; margin-bottom: 10px; display: block; color: #e5e7eb; }

.rv-footer { padding: 16px 24px; border-top: 1px solid #f3f4f6; text-align: center; }
.rv-write-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; background: #D10024; color: #fff; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; transition: background .2s; }
.rv-write-btn:hover { background: #a8001e; color: #fff; }
.rv-own-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #065f46; background: #d1fae5; padding: 8px 16px; border-radius: 8px; }
</style>
@endpush

@section('content')
<div class="container product-detail-page">
    <div class="breadcrumb">
        <a href="{{ route('products.index') }}">Produk</a>
        <span>&rsaquo;</span>
        @if($product->category)
            <span>{{ $product->category }}</span>
            <span>&rsaquo;</span>
        @endif
        <span style="color:#333;">{{ $product->name }}</span>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="product-detail">
        {{-- Gambar Produk --}}
        <div class="product-image-box">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <i class="fa fa-shopping-bag no-img"></i>
            @endif
        </div>

        {{-- Info Produk --}}
        <div class="product-info">
            @if($product->category)
                <span class="product-category-badge">{{ $product->category }}</span>
            @endif

            <h1 class="product-title">{{ $product->name }}</h1>

            <div class="product-seller">
                <i class="fa fa-store"></i> Dijual oleh
                <a href="#">{{ $product->seller->name }}</a>
            </div>

            <div class="product-price">{{ $product->formatted_price }}</div>

            {{-- Status Stok --}}
            @if($product->stock == 0)
                <div class="product-stock-info out">
                    <i class="fa fa-times-circle"></i> Stok Habis
                </div>
            @elseif($product->stock <= 5)
                <div class="product-stock-info low">
                    <i class="fa fa-exclamation-triangle"></i> Stok Terbatas &mdash; Sisa {{ $product->stock }} item
                </div>
            @else
                <div class="product-stock-info available">
                    <i class="fa fa-check-circle"></i> Stok Tersedia &mdash; {{ $product->stock }} item
                </div>
            @endif

            {{-- Deskripsi --}}
            @if($product->description)
            <div class="product-description">
                <h4>Deskripsi Produk</h4>
                <p>{{ $product->description }}</p>
            </div>
            @endif

            {{-- Tambah ke Keranjang --}}
            @auth
                @if(auth()->user()->role === 'pembeli')
                    @if($product->stock > 0)
                        {{-- Qty selector (shared, read by JS) --}}
                        <div class="add-to-cart-form">
                            <div class="qty-row">
                                <span class="qty-label">Jumlah:</span>
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" onclick="changeQty(-1)">−</button>
                                    <input type="number" id="qtyInput" class="qty-input"
                                        value="1" min="1" max="{{ $product->stock }}">
                                    <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                                </div>
                                <span style="font-size:12px;color:#888;">Maks. {{ $product->stock }}</span>
                            </div>

                            {{-- Beli Langsung --}}
                            <form id="formBuyNow" method="POST" action="{{ route('cart.buy-now', $product) }}">
                                @csrf
                                <input type="hidden" name="quantity" id="qtyBuyNow" value="1">
                                <button type="submit" class="btn-buy-now" style="width:100%;">
                                    <i class="fa fa-bolt"></i> Beli Langsung
                                </button>
                            </form>

                            {{-- Tambah ke Keranjang + Wishlist --}}
                            <div class="btn-action-row">
                                <form id="formAddCart" method="POST" action="{{ route('cart.add', $product) }}" style="flex:1;display:flex;">
                                    @csrf
                                    <input type="hidden" name="quantity" id="qtyAddCart" value="1">
                                    <button type="submit" class="btn-add-cart" style="width:100%;">
                                        <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('wishlist.toggle', $product) }}" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="btn-wishlist {{ $isWishlisted ? 'active' : '' }}"
                                        title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}">
                                        <i class="fa {{ $isWishlisted ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <button class="btn-out-of-stock" disabled>
                            <i class="fa fa-times-circle"></i> Stok Habis
                        </button>
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-buy-now" style="text-decoration:none;flex:none;padding:10px 24px;font-size:14px;border-radius:8px;width:auto;">
                    <i class="fa fa-sign-in"></i> Login untuk Membeli
                </a>
            @endauth
        </div>
    </div>

{{-- ===== SECTION ULASAN PEMBELI ===== --}}
@php
    $reviews        = \App\Models\Review::with('user')->forProduct($product->id)->latest()->get();
    $reviewCount    = $reviews->count();
    $averageRating  = $reviewCount ? round($reviews->avg('rating'), 1) : 0;
    $ratingCounts   = [];
    for($i = 5; $i >= 1; $i--) {
        $ratingCounts[$i] = $reviews->where('rating', $i)->count();
    }
    $userReview = auth()->check()
        ? $reviews->firstWhere('user_id', auth()->id())
        : null;
@endphp

<div class="rv-section">
    <div class="rv-section-header">
        <div class="rv-section-title">Ulasan Pembeli</div>
    </div>

    {{-- Ringkasan Rating --}}
    <div class="rv-summary">
        <div class="rv-avg-block">
            <div>
                <span class="rv-avg-num">{{ number_format($averageRating, 1) }}</span>
                <span class="rv-avg-denom"> / 5.0</span>
            </div>
            <div class="rv-avg-stars">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($averageRating))★@else☆@endif
                @endfor
            </div>
            <div class="rv-avg-count">{{ $reviewCount }} rating &bull; {{ $reviewCount }} ulasan</div>
        </div>

        <div class="rv-bars">
            @for($i = 5; $i >= 1; $i--)
            <div class="rv-bar-row">
                <span class="rv-bar-label">{{ $i }}</span>
                <div class="rv-bar-track">
                    <div class="rv-bar-fill" style="width:{{ $reviewCount > 0 ? round($ratingCounts[$i] / $reviewCount * 100) : 0 }}%"></div>
                </div>
                <span class="rv-bar-count">({{ $ratingCounts[$i] }})</span>
            </div>
            @endfor
        </div>
    </div>

    {{-- Filter Bintang --}}
    <div class="rv-filter">
        <span class="rv-filter-label">Filter:</span>
        <button class="rv-filter-btn active" data-filter="0">
            Semua <span class="rv-filter-count">({{ $reviewCount }})</span>
        </button>
        @for($i = 5; $i >= 1; $i--)
        <button class="rv-filter-btn" data-filter="{{ $i }}">
            <span class="rv-filter-star">★</span> {{ $i }}
            <span class="rv-filter-count">({{ $ratingCounts[$i] }})</span>
        </button>
        @endfor
    </div>

    {{-- Daftar Ulasan --}}
    <div class="rv-list" id="rv-list">
        @forelse($reviews as $review)
        <div class="rv-item" data-rating="{{ $review->rating }}">
            <div class="rv-item-head">
                <div class="rv-avatar">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                <div>
                    <div class="rv-user-name">{{ $review->user->name ?? 'Pengguna' }}</div>
                    <div class="rv-meta">
                        <span class="rv-stars-small">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)★@else☆@endif
                            @endfor
                        </span>
                        <span class="rv-date">{{ $review->created_at->locale('id')->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            @if($review->comment)
                <div class="rv-comment">{{ $review->comment }}</div>
            @endif
        </div>
        @empty
        <div class="rv-empty">
            <i class="fa fa-comment-o"></i>
            Belum ada ulasan untuk produk ini.<br>Jadilah yang pertama memberikan ulasan!
        </div>
        @endforelse
        <div class="rv-no-result" id="rv-no-result">
            <i class="fa fa-filter"></i>
            Tidak ada ulasan dengan filter ini.
        </div>
    </div>

    {{-- Tombol Tulis Ulasan --}}
    <div class="rv-footer">
        @auth
            @if($userReview)
                @if($userReview->created_at->diffInHours(now()) < 24)
                    <span class="rv-own-badge"><i class="fa fa-check-circle"></i> Anda sudah mengulas produk ini &mdash; <a href="{{ route('reviews.edit', $userReview->id) }}" style="color:#065f46;font-weight:700;margin-left:4px;">Edit Ulasan</a></span>
                @else
                    <span class="rv-own-badge"><i class="fa fa-check-circle"></i> Anda sudah mengulas produk ini <span style="color:#888;font-weight:400;margin-left:4px;font-size:12px;">(tidak dapat diedit, lebih dari 24 jam)</span></span>
                @endif
            @else
                <a href="{{ route('reviews.create', $product->id) }}" class="rv-write-btn"><i class="fa fa-star"></i> Tulis Ulasan</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="rv-write-btn"><i class="fa fa-sign-in"></i> Login untuk Memberi Ulasan</a>
        @endauth
    </div>
</div>

</div>{{-- /container product-detail-page --}}
@endsection

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qtyInput');
    const max = parseInt(input.max);
    const min = parseInt(input.min);
    let val = parseInt(input.value) + delta;
    if (val < min) val = min;
    if (val > max) val = max;
    input.value = val;
    syncQty(val);
}

function syncQty(val) {
    const buyNow  = document.getElementById('qtyBuyNow');
    const addCart = document.getElementById('qtyAddCart');
    if (buyNow)  buyNow.value  = val;
    if (addCart) addCart.value = val;
}

// Keep hidden inputs in sync when user types directly
const qtyInput = document.getElementById('qtyInput');
if (qtyInput) {
    qtyInput.addEventListener('input', function () {
        let val = parseInt(this.value) || 1;
        const max = parseInt(this.max);
        const min = parseInt(this.min);
        if (val < min) val = min;
        if (val > max) val = max;
        this.value = val;
        syncQty(val);
    });
}

// Filter ulasan berdasarkan bintang
document.querySelectorAll('.rv-filter-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const filter = parseInt(this.dataset.filter);

        // Toggle active
        document.querySelectorAll('.rv-filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        // Show/hide items
        let visible = 0;
        document.querySelectorAll('#rv-list .rv-item').forEach(function(item) {
            const rating = parseInt(item.dataset.rating);
            const show = filter === 0 || rating === filter;
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        // Pesan kosong
        const noResult = document.getElementById('rv-no-result');
        if (noResult) noResult.style.display = visible === 0 ? 'block' : 'none';
    });
});
</script>
@endpush
