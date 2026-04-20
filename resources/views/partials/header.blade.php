<!-- Main Header -->
<style>
@media(max-width:768px){
    .search-bar{display:none!important;}
}
</style>
@php
    $cartCount = 0;
    $cartItems = collect();
    $cartTotal = 0;
    $wishlistCount = 0;
    if (auth()->check() && auth()->user()->role === 'pembeli') {
        $cartItems = auth()->user()->carts()->with('product')->get();
        $cartCount = $cartItems->sum('quantity');
        $cartTotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
        $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
    }
@endphp
<header class="main-header">
    <div class="container">
        <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fa fa-bars"></i></button>
        <div class="logo-section">
            <a href="{{ route('home') }}">
                <div class="logo-icon">N</div>
                <span class="logo-text">Nusa<span>Mart</span></span>
            </a>
        </div>
        @if(!auth()->check() || auth()->user()->role !== 'admin')
        @php
            $selCat = $navCategories->firstWhere('id', request('category_id'));
            $selCatLabel = $selCat ? $selCat->name : 'Semua Kategori';
            $visibleCats = $navCategories->take(5);
            $hasMore = $navCategories->count() > 5;
        @endphp
        <div class="search-bar">
            <form action="{{ route('products.index') }}" method="GET" style="display:contents;" id="headerSearchForm">
                <input type="hidden" name="category_id" id="headerCatInput" value="{{ request('category_id') }}">
                <div class="sb-cat-wrap" id="sbCatWrap">
                    <button type="button" class="sb-cat-btn" id="sbCatBtn" onclick="toggleSbCat(event)">
                        <i class="fa fa-th-large sb-cat-icon"></i>
                        <span id="sbCatLabel">{{ $selCatLabel }}</span>
                        <i class="fa fa-chevron-down sb-cat-arrow" id="sbCatArrow"></i>
                    </button>
                    <div class="sb-cat-menu" id="sbCatMenu">
                        <div class="sb-cat-item {{ !request('category_id') ? 'active' : '' }}" onclick="selectSbCat('', 'Semua Kategori')">
                            <i class="fa fa-th-large"></i> Semua Kategori
                        </div>
                        @foreach($visibleCats as $cat)
                        <div class="sb-cat-item {{ request('category_id') == $cat->id ? 'active' : '' }}" onclick="selectSbCat('{{ $cat->id }}', '{{ addslashes($cat->name) }}')">
                            <i class="fa fa-tag"></i> {{ $cat->name }}
                        </div>
                        @endforeach
                        @if($hasMore)
                        <div class="sb-cat-more" onclick="window.location='{{ route('categories.index') }}'">
                            <i class="fa fa-ellipsis-h"></i> Lihat semua kategori
                        </div>
                        @endif
                    </div>
                </div>
                <input type="text" name="search" placeholder="Cari produk, kategori..." value="{{ request('search') }}">
                <button type="submit"><i class="fa fa-search"></i> Cari</button>
            </form>
        </div>
        <div class="header-right">
            @auth
            @if(auth()->user()->role === 'pembeli')
            <a href="{{ route('wishlist.index') }}" class="header-icon">
                <i class="fa {{ $wishlistCount > 0 ? 'fa-heart' : 'fa-heart-o' }}"></i>
                <span class="count-badge">{{ $wishlistCount }}</span>
                <span class="icon-label">Wishlist</span>
            </a>
            @endif
            @endauth
            @if(auth()->check() && auth()->user()->role === 'pembeli')
            <div class="cart-summary">
                <a href="{{ route('cart.index') }}" class="header-icon" id="cartToggle">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="count-badge">{{ $cartCount }}</span>
                    <span class="icon-label">Keranjang</span>
                </a>
                <div class="cart-dropdown" id="cartDropdown">
                    <div class="cart-dropdown-items">
                        @forelse($cartItems->take(3) as $item)
                        <div class="cart-dropdown-item">
                            <div class="cart-item-img">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <i class="fa fa-shopping-bag"></i>
                                @endif
                            </div>
                            <div class="cart-item-info">
                                <div class="cart-item-name">{{ Str::limit($item->product->name, 25) }}</div>
                                <div class="cart-item-qty">{{ $item->quantity }}x <span class="cart-item-price">{{ $item->product->formatted_price }}</span></div>
                            </div>
                            <form action="{{ route('cart.remove', $item) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="cart-item-remove"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
                        @empty
                        <div style="padding:20px;text-align:center;color:#999;font-size:13px;">
                            <i class="fa fa-shopping-cart" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                            Keranjang kosong
                        </div>
                        @endforelse
                    </div>
                    <div class="cart-dropdown-summary">
                        <div class="cart-dropdown-count">{{ $cartCount }} Item dipilih</div>
                        <div class="cart-dropdown-subtotal">SUBTOTAL: <span>Rp {{ number_format($cartTotal, 0, ',', '.') }}</span></div>
                    </div>
                    <div class="cart-dropdown-actions">
                        <a href="{{ route('cart.index') }}" class="cart-btn-view">Lihat Keranjang</a>
                        <a href="{{ route('checkout.index') }}" class="cart-btn-checkout">Checkout <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @elseif(!auth()->check())
        {{-- Tampilkan logo lebih besar untuk halaman utama (guest) --}}
        @endif
    </div>
</header>
<script>
function toggleSbCat(e){
    e.stopPropagation();
    var menu = document.getElementById('sbCatMenu');
    var arrow = document.getElementById('sbCatArrow');
    var wrap = document.getElementById('sbCatWrap');
    var open = menu.classList.toggle('open');
    arrow.style.transform = open ? 'rotate(180deg)' : '';
    wrap.classList.toggle('open', open);
}
function selectSbCat(val, label){
    document.getElementById('headerCatInput').value = val;
    document.getElementById('sbCatLabel').textContent = label;
    document.getElementById('sbCatMenu').classList.remove('open');
    document.getElementById('sbCatArrow').style.transform = '';
    document.getElementById('sbCatWrap').classList.remove('open');
}
document.addEventListener('click', function(e){
    var wrap = document.getElementById('sbCatWrap');
    if(wrap && !wrap.contains(e.target)){
        document.getElementById('sbCatMenu').classList.remove('open');
        document.getElementById('sbCatArrow').style.transform = '';
        wrap.classList.remove('open');
    }
});
</script>
