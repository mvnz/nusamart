@extends('layouts.app')

@section('title', 'NusaMart – Marketplace Produk UMKM Lokal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="home-wrapper">

    {{-- ===== HERO ===== --}}
    @guest
    <section class="hero-section">
        <div class="container">
            <div class="hero-inner">
                <div class="hero-text">
                    <div class="hero-eyebrow">
                        <i class="fa fa-star"></i>
                        Marketplace Produk UMKM Lokal #1
                    </div>
                    <h1 class="hero-title">
                        Temukan Produk <span>UMKM Terbaik</span><br>
                        dari Nusantara
                    </h1>
                    <p class="hero-subtitle">
                        Belanja langsung dari pengrajin &amp; pedagang UMKM lokal. Ribuan produk
                        autentik berkualitas — makanan, fashion, kerajinan &amp; lebih banyak lagi.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn-hero-primary">
                            <i class="fa fa-shopping-bag"></i> Mulai Belanja
                        </a>
                        <a href="{{ route('page.tentang') }}" class="btn-hero-secondary">
                            <i class="fa fa-info-circle"></i> Tentang NusaMart
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <span class="hero-stat-number">50+</span>
                            <span class="hero-stat-label">UMKM</span>
                        </div>
                        <div class="hero-stat-item">
                            <span class="hero-stat-number">100+</span>
                            <span class="hero-stat-label">Penjual Aktif</span>
                        </div>
                        <div class="hero-stat-item">
                            <span class="hero-stat-number">100+</span>
                            <span class="hero-stat-label">Transaksi Terpercaya</span>
                        </div>
                    </div>
                </div>
                <div class="hero-visual">
                    @php
                        $hcColors = [
                            ['#ff8c69','#e8453c'],
                            ['#a78bfa','#7c3aed'],
                            ['#34d399','#059669'],
                            ['#fbbf24','#d97706'],
                        ];
                    @endphp
                    <div class="hero-cards-grid">
                        @foreach($featuredProducts as $p)
                        @php $ci = $loop->index % 4; @endphp
                        <a href="{{ route('products.show', $p->id) }}" class="hero-product-card" style="text-decoration:none;display:block;">
                            @if($p->image)
                                <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}">
                            @else
                                <div class="hero-card-icon" style="background: linear-gradient(135deg, {{ $hcColors[$ci][0] }}, {{ $hcColors[$ci][1] }});">
                                    <span style="position:relative;z-index:1;">🛍️</span>
                                </div>
                            @endif
                            <div class="hero-product-info">
                                <div class="name">{{ $p->name }}</div>
                                <div class="price">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endguest

    {{-- ===== PROMO STRIP ===== --}}
    <div class="promo-strip">
        <div class="promo-strip-inner">
            <span class="promo-strip-item"><i class="fa fa-truck"></i> Gratis Ongkir min. Rp 100.000</span>
            <span class="promo-strip-item"><i class="fa fa-shield"></i> Pembayaran 100% Aman</span>
            <span class="promo-strip-item"><i class="fa fa-refresh"></i> Garansi Pengembalian 7 Hari</span>
            <span class="promo-strip-item"><i class="fa fa-star"></i> Produk Asli UMKM Lokal</span>
            <span class="promo-strip-item"><i class="fa fa-headphones"></i> Layanan CS 24 Jam</span>
            {{-- Duplikat untuk efek marquee --}}
            <span class="promo-strip-item"><i class="fa fa-truck"></i> Gratis Ongkir min. Rp 100.000</span>
            <span class="promo-strip-item"><i class="fa fa-shield"></i> Pembayaran 100% Aman</span>
            <span class="promo-strip-item"><i class="fa fa-refresh"></i> Garansi Pengembalian 7 Hari</span>
            <span class="promo-strip-item"><i class="fa fa-star"></i> Produk Asli UMKM Lokal</span>
            <span class="promo-strip-item"><i class="fa fa-headphones"></i> Layanan CS 24 Jam</span>
        </div>
    </div>

    {{-- ===== SEARCH BAR (hanya untuk guest) ===== --}}
    @guest
    <div class="home-search-bar">
        <div class="container">
            <form action="{{ route('products.index') }}" method="GET">
            @php
            $hsIconColors = ['#666','#e74c3c','#3498db','#9b59b6','#27ae60','#e67e22','#16a085','#f39c12','#e91e8c','#1abc9c','#2c3e50'];
            $hsIcons = ['fa-th','fa-cutlery','fa-coffee','fa-shopping-bag','fa-leaf','fa-paint-brush','fa-bolt','fa-gift','fa-heart','fa-cube','fa-star'];
            @endphp
            <input type="hidden" name="category_id" id="homeCatInput" value="">
            <div class="home-search-inner">
                <div class="home-cat-wrap">
                    <button type="button" class="home-cat-btn" id="homeCatBtn">
                        <i class="fa fa-th" id="homeCatIcon" style="color:#666"></i>
                        <span id="homeCatLabel">Semua Kategori</span>
                        <i class="fa fa-chevron-down caret"></i>
                    </button>
                    <div class="home-cat-dropdown" id="homeCatDropdown">
                        <div class="home-cat-dropdown-header">Kategori Produk</div>
                        <div class="home-cat-dropdown-items">
                            <div class="home-cat-item selected" data-value="" data-label="Semua Kategori" data-icon="fa-th" data-color="#666">
                                <div class="home-cat-item-icon" style="background:#666"><i class="fa fa-th"></i></div>
                                <span>Semua Kategori</span>
                            </div>
                            @foreach($navCategories as $hIdx => $hCat)
                            <div class="home-cat-item" data-value="{{ $hCat->id }}" data-label="{{ $hCat->name }}" data-icon="{{ $hsIcons[($hIdx+1) % count($hsIcons)] }}" data-color="{{ $hsIconColors[($hIdx+1) % count($hsIconColors)] }}">
                                <div class="home-cat-item-icon" style="background:{{ $hsIconColors[($hIdx+1) % count($hsIconColors)] }}"><i class="fa {{ $hsIcons[($hIdx+1) % count($hsIcons)] }}"></i></div>
                                <span>{{ $hCat->name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="text" name="search" placeholder="Cari produk UMKM favoritmu...">
                <button type="submit" class="home-search-btn">
                    <i class="fa fa-search"></i> Cari
                </button>
            </div>
            </form>
            <script>
            (function(){
                var btn = document.getElementById('homeCatBtn');
                var dd  = document.getElementById('homeCatDropdown');
                var inp = document.getElementById('homeCatInput');
                var lbl = document.getElementById('homeCatLabel');
                var ico = document.getElementById('homeCatIcon');
                btn.addEventListener('click', function(e){ e.stopPropagation(); btn.classList.toggle('open'); dd.classList.toggle('open'); });
                dd.querySelectorAll('.home-cat-item').forEach(function(item){
                    item.addEventListener('click', function(){
                        dd.querySelectorAll('.home-cat-item').forEach(function(i){ i.classList.remove('selected'); });
                        item.classList.add('selected');
                        inp.value = item.dataset.value;
                        lbl.textContent = item.dataset.label;
                        ico.className = 'fa ' + item.dataset.icon;
                        ico.style.color = item.dataset.color;
                        btn.classList.remove('open'); dd.classList.remove('open');
                    });
                });
                document.addEventListener('click', function(){ btn.classList.remove('open'); dd.classList.remove('open'); });
                dd.addEventListener('click', function(e){ e.stopPropagation(); });
            })();
            </script>
        </div>
    </div>
    @endguest

    <div class="home-content-area">

        {{-- ===== KATEGORI POPULER ===== --}}
        @php
        $catColors = ['#e74c3c','#3498db','#9b59b6','#27ae60','#e67e22','#16a085','#f39c12','#e91e8c','#1abc9c','#2c3e50'];
        $catIcons  = ['fa-cutlery','fa-coffee','fa-shopping-bag','fa-leaf','fa-paint-brush','fa-bolt','fa-gift','fa-heart','fa-cube','fa-star'];
        @endphp
        <section class="cat-populer-section">
            <div class="cat-populer-box">
                <div class="cat-promo-card">
                    <div>
                        <div class="cat-promo-label">UMKM Lokal</div>
                        <div class="cat-promo-title">Yuk, belanja di NusaMart</div>
                        <div class="cat-promo-sub">Barang lengkap dari beragam kategori</div>
                    </div>
                    <a href="{{ route('products.index') }}" class="cat-promo-btn">Cek Sekarang</a>
                </div>
                <div class="cat-populer-right">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                        <div class="cat-populer-heading" style="margin-bottom:0">Kategori Populer</div>
                        <a href="{{ route('categories.index') }}" style="font-size:13px;font-weight:600;color:#D10024;text-decoration:none;display:flex;align-items:center;gap:4px;">
                            Semua Kategori <i class="fa fa-arrow-right" style="font-size:11px"></i>
                        </a>
                    </div>
                    <div class="cat-chips-grid">
                        @foreach($navCategories->take(10) as $idx => $cat)
                        <a href="{{ route('products.index', ['category_id' => $cat->id]) }}" class="cat-chip">
                            <div class="cat-chip-icon" style="background: {{ $catColors[$idx % count($catColors)] }};">
                                <i class="fa {{ $catIcons[$idx % count($catIcons)] }}"></i>
                            </div>
                            <span>{{ $cat->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>


        </section>

        {{-- ===== PROMO BANNER ===== --}}
        @php
            $bannerGradients = [
                'linear-gradient(135deg,#D10024,#8B0000)',
                'linear-gradient(135deg,#1565c0,#0d47a1)',
                'linear-gradient(135deg,#2e7d32,#1b5e20)',
            ];
        @endphp
        @if(!empty($promoBanners))
        <section class="promo-banner-section">
            <div class="promo-banner-grid">
                @foreach($promoBanners as $bi => $banner)
                <a href="{{ route('products.index', ['category_id' => $banner['id']]) }}"
                   class="promo-banner-card"
                   @if($bi === 0) style="min-height:200px" @endif>
                    @if($banner['image'])
                        <img src="{{ asset('storage/' . $banner['image']) }}" alt="{{ $banner['name'] }}">
                    @else
                        <div style="position:absolute;inset:0;{{ $bannerGradients[$bi % 3] }}"></div>
                    @endif
                    <div class="promo-banner-overlay">
                        <div class="promo-banner-tag"><i class="fa fa-tag"></i> {{ $banner['name'] }}</div>
                        @if($bi === 0)
                        <div class="promo-banner-title">Produk Pilihan Hari Ini</div>
                        <div class="promo-banner-sub">Temukan produk unggulan UMKM</div>
                        @else
                        <div class="promo-banner-title">{{ $banner['name'] }}</div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- ===== FLASH SALE ===== --}}
        @if(!empty($flashSaleProducts))
        <section class="flash-sale-section">
            <div class="flash-sale-header">
                <div class="flash-sale-title">
                    <span class="flash-icon"><i class="fa fa-bolt"></i></span>
                    Flash Sale
                </div>
                <div class="flash-countdown">
                    <span style="color:#888;font-size:12px;margin-right:4px;">Berakhir dalam:</span>
                    <div class="countdown-block">
                        <span class="countdown-num" id="cd-h">00</span>
                        <span class="countdown-label">jam</span>
                    </div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-block">
                        <span class="countdown-num" id="cd-m">00</span>
                        <span class="countdown-label">mnt</span>
                    </div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-block">
                        <span class="countdown-num" id="cd-s">00</span>
                        <span class="countdown-label">dtk</span>
                    </div>
                </div>
            </div>
            <div class="flash-slider-wrapper">
            <button class="flash-slider-btn flash-slider-prev" id="flashPrev" aria-label="Sebelumnya"><i class="fa fa-chevron-left"></i></button>
            <div class="flash-sale-scroll" id="flashScroll">
                <div class="flash-products-row">
                    @foreach($flashSaleProducts as $p)
                    <a href="{{ route('products.show', $p['id']) }}" class="flash-product-card" style="text-decoration:none;color:inherit">
                        @if($p['image'])
                        <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}">
                        @else
                        <div style="width:100%;height:140px;background:#2a2b3a;display:flex;align-items:center;justify-content:center">
                            <i class="fa fa-image" style="font-size:40px;color:#444"></i>
                        </div>
                        @endif
                        <div class="flash-product-info">
                            <div class="flash-product-name">{{ $p['name'] }}</div>
                            <div class="flash-price-row">
                                <span class="flash-price">Rp {{ number_format($p['price'], 0, ',', '.') }}</span>
                                <span class="flash-original">Rp {{ number_format($p['original_price'], 0, ',', '.') }}</span>
                                <span class="flash-disc">{{ $p['disc'] }}%</span>
                            </div>
                            <div class="flash-progress">
                                <div class="flash-progress-bar">
                                    <div class="flash-progress-fill" style="width: {{ $p['quota'] > 0 ? min(100, round($p['sold'] / $p['quota'] * 100)) : 0 }}%"></div>
                                </div>
                                <div class="flash-progress-text">Terjual {{ $p['sold'] }}</div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <button class="flash-slider-btn flash-slider-next" id="flashNext" aria-label="Berikutnya"><i class="fa fa-chevron-right"></i></button>
            </div>{{-- /flash-slider-wrapper --}}
        </section>
        @endif

        {{-- ===== TABBED PRODUCTS ===== --}}
        <section class="prod-tabs-section">
            <div class="container">
                @php
                    $tabUsername = Auth::check() ? explode(' ', Auth::user()->name)[0] : 'Kamu';
                @endphp
                <div class="prod-tabs-nav" id="prodTabsNav">
                    <button class="prod-tab-btn active" onclick="switchProdTab('for_user', this)">
                        Untuk {{ $tabUsername }}
                    </button>
                    <button class="prod-tab-btn" onclick="switchProdTab('rekomendasi', this)">
                        Rekomendasi
                    </button>
                    <button class="prod-tab-btn" onclick="switchProdTab('populer', this)">
                        Populer
                    </button>
                </div>

                @foreach(['for_user' => $tabProducts['for_user'], 'rekomendasi' => $tabProducts['rekomendasi'], 'populer' => $tabProducts['populer']] as $tabKey => $tabItems)
                <div class="prod-tab-pane {{ $tabKey === 'for_user' ? 'active' : '' }}" id="prod-tab-{{ $tabKey }}" style="padding-top:20px">
                    @if(count($tabItems) > 0)
                    <div class="prod-tabs-grid">
                        @foreach($tabItems as $p)
                        <a href="{{ route('products.show', $p['id']) }}" class="ptile">
                            <div class="ptile-img">
                                @if($p['image'])
                                    <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}">
                                @else
                                    <div class="ptile-img-placeholder">
                                        <i class="fa fa-image" style="font-size:36px;color:#ddd"></i>
                                    </div>
                                @endif
                                @if(!empty($p['promo_pct']))
                                <span class="ptile-disc-badge">-{{ $p['promo_pct'] }}%</span>
                                @endif
                            </div>
                            <div class="ptile-body">
                                @if(!empty($p['category']))
                                <div class="ptile-cat">{{ $p['category'] }}</div>
                                @endif
                                <div class="ptile-name">{{ $p['name'] }}</div>
                                <div class="ptile-seller"><i class="fa fa-store" style="margin-right:4px;"></i>{{ $p['seller'] }}</div>
                                <div class="ptile-price-row">
                                    <span class="ptile-price">Rp {{ number_format($p['price'], 0, ',', '.') }}</span>
                                    @if(!empty($p['promo_pct']))
                                    <span class="ptile-original">Rp {{ number_format($p['original_price'], 0, ',', '.') }}</span>
                                    <span class="ptile-pct">{{ $p['promo_pct'] }}%</span>
                                    @endif
                                </div>
                                <div class="ptile-stock @if($p['stock'] == 0) out @elseif($p['stock'] <= 5) low @endif">
                                    @if($p['stock'] == 0)
                                        <i class="fa fa-times-circle"></i> Stok habis
                                    @elseif($p['stock'] <= 5)
                                        <i class="fa fa-exclamation-triangle"></i> Sisa {{ $p['stock'] }}
                                    @else
                                        <i class="fa fa-check-circle" style="color:#10b981;"></i> Stok: {{ $p['stock'] }}
                                    @endif
                                </div>
                                <div class="ptile-sold"><i class="fa fa-shopping-cart" style="margin-right:3px;"></i> {{ $p['sold'] }} terjual</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <div style="text-align:center;padding:48px;color:#bbb">
                        <i class="fa fa-box-open" style="font-size:40px;display:block;margin-bottom:12px"></i>
                        <div>Belum ada produk tersedia</div>
                    </div>
                    @endif
                </div>
                @endforeach

                <div style="text-align:center;margin-top:24px">
                    <a href="{{ route('products.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 28px;border:1.5px solid #D10024;color:#D10024;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s"
                       onmouseover="this.style.background='#D10024';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color='#D10024'">
                        Lihat Semua Produk <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>

    </div>{{-- /home-content-area --}}

    {{-- ===== TRUST BADGES ===== --}}
    <div class="trust-section">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-item">
                    <div class="trust-icon-wrap"><i class="fa fa-truck"></i></div>
                    <div>
                        <div class="trust-text-title">Gratis Ongkos Kirim</div>
                        <div class="trust-text-sub">Untuk pembelian min. Rp 100.000</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon-wrap"><i class="fa fa-shield"></i></div>
                    <div>
                        <div class="trust-text-title">Transaksi Aman</div>
                        <div class="trust-text-sub">Pembayaran terenkripsi & terjamin</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon-wrap"><i class="fa fa-refresh"></i></div>
                    <div>
                        <div class="trust-text-title">Pengembalian Mudah</div>
                        <div class="trust-text-sub">Garansi 7 hari jika tidak sesuai</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon-wrap"><i class="fa fa-headphones"></i></div>
                    <div>
                        <div class="trust-text-title">Layanan 24/7</div>
                        <div class="trust-text-sub">Customer service siap membantu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>{{-- /home-wrapper --}}
@endsection

@push('scripts')
<script>
// Product Tab Switcher
function switchProdTab(key, btn) {
    document.querySelectorAll('.prod-tab-pane').forEach(function(p){ p.classList.remove('active'); });
    document.querySelectorAll('.prod-tab-btn').forEach(function(b){ b.classList.remove('active'); });
    document.getElementById('prod-tab-' + key).classList.add('active');
    btn.classList.add('active');
}

// Flash Sale Slider
(function() {
    var scroll = document.getElementById('flashScroll');
    var prev   = document.getElementById('flashPrev');
    var next   = document.getElementById('flashNext');
    if (!scroll || !prev || !next) return;

    var STEP = 174 * 3; // 3 kartu per klik (160px card + 14px gap)

    function updateBtns() {
        prev.classList.toggle('fs-hidden', scroll.scrollLeft <= 2);
        next.classList.toggle('fs-hidden', scroll.scrollLeft + scroll.clientWidth >= scroll.scrollWidth - 2);
    }

    prev.addEventListener('click', function() { scroll.scrollBy({ left: -STEP, behavior: 'smooth' }); });
    next.addEventListener('click', function() { scroll.scrollBy({ left:  STEP, behavior: 'smooth' }); });
    scroll.addEventListener('scroll', updateBtns);
    window.addEventListener('resize', updateBtns);

    // Drag-to-scroll (mouse)
    var isDragging = false, startX, startScroll;
    scroll.addEventListener('mousedown', function(e) {
        isDragging = true; startX = e.pageX; startScroll = scroll.scrollLeft;
        scroll.classList.add('dragging');
    });
    document.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        scroll.scrollLeft = startScroll - (e.pageX - startX);
    });
    document.addEventListener('mouseup', function() {
        if (isDragging) { isDragging = false; scroll.classList.remove('dragging'); updateBtns(); }
    });

    updateBtns();
})();

// Countdown Timer
(function() {
    @if(!empty($flashSaleDeadline))
    var deadline = new Date('{{ $flashSaleDeadline }}');
    @else
    var now = new Date();
    var deadline = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 0, 0, 0);
    @endif

    function pad(n) { return n < 10 ? '0' + n : n; }
    function updateCountdown() {
        var now = new Date();
        var diff = Math.max(0, deadline - now);
        var h = Math.floor(diff / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        var hEl = document.getElementById('cd-h');
        var mEl = document.getElementById('cd-m');
        var sEl = document.getElementById('cd-s');
        if (hEl) hEl.textContent = pad(h);
        if (mEl) mEl.textContent = pad(m);
        if (sEl) sEl.textContent = pad(s);
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
})();

// Burger Menu & Category Filter
(function() {
    var burgerBtn = document.getElementById('categoryBurgerBtn');
    var dropdown = document.getElementById('categoryDropdownMenu');
    var overlay = document.getElementById('categoryDropdownOverlay');
    var closeBtn = document.getElementById('closeDropdownBtn');
    var currentFilter = 'all';

    // Toggle burger menu
    if (burgerBtn) {
        burgerBtn.addEventListener('click', function() {
            dropdown.classList.add('active');
            overlay.classList.add('active');
            burgerBtn.classList.add('active');
        });
    }

    // Close dropdown
    function closeDropdown() {
        dropdown.classList.remove('active');
        overlay.classList.remove('active');
        if (burgerBtn) {
            burgerBtn.classList.remove('active');
        }
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeDropdown);
    }

    if (overlay) {
        overlay.addEventListener('click', closeDropdown);
    }

    // Category filter function
    window.filterByCategory = function(element, category) {
        // Determine category from element or parameter
        var selectedCategory = category || (element ? element.getAttribute('data-category') : 'all');
        currentFilter = selectedCategory;

        // Update active state for dropdown items in sidebar
        var dropdownItems = document.querySelectorAll('.dropdown-category-item');
        dropdownItems.forEach(function(item) {
            if (item.getAttribute('data-category') === selectedCategory) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // Update active state for category cards in grid
        var categoryCards = document.querySelectorAll('.category-card');
        categoryCards.forEach(function(card) {
            if (card.getAttribute('data-category') === selectedCategory) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        });

        // Update active state for navbar dropdown items
        var navDropdownItems = document.querySelectorAll('.nav-dropdown-item');
        navDropdownItems.forEach(function(item) {
            if (item.getAttribute('data-category') === selectedCategory) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // Filter products in all product grids
        var allProducts = document.querySelectorAll('.product-card');
        var visibleCount = 0;
        
        allProducts.forEach(function(product) {
            var productCategory = product.getAttribute('data-category');
            if (selectedCategory === 'all' || productCategory === selectedCategory) {
                product.style.display = '';
                setTimeout(function() {
                    product.style.opacity = '1';
                }, 10);
                visibleCount++;
            } else {
                product.style.opacity = '0';
                setTimeout(function() {
                    product.style.display = 'none';
                }, 200);
            }
        });

        console.log('Filter applied: ' + selectedCategory + ' - ' + visibleCount + ' products shown');

        // Close dropdown after selection
        if (dropdown && dropdown.classList.contains('active')) {
            closeDropdown();
        }
        
        // Close navbar dropdown if open
        var navDropdown = document.getElementById('navCategoryDropdown');
        if (navDropdown && navDropdown.classList.contains('active')) {
            navDropdown.classList.remove('active');
            var navBtn = document.getElementById('navCategoryBtn');
            if (navBtn) {
                navBtn.classList.remove('active');
            }
        }
    };

    // Add smooth transition to products
    var style = document.createElement('style');
    style.textContent = '.product-card { transition: opacity 0.2s ease; }';
    document.head.appendChild(style);
})();
</script>

{{-- ═══ KULINER PROMO POPUP ═══ --}}
<style>
.hklp-overlay {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(10, 5, 20, 0.68);
    backdrop-filter: blur(5px);
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
    animation: hklpIn .35s ease;
}
.hklp-overlay.hklp-hiding { animation: hklpOut .28s ease forwards; }
@keyframes hklpIn  { from{opacity:0} to{opacity:1} }
@keyframes hklpOut { from{opacity:1} to{opacity:0} }

.hklp-box {
    background: #fff;
    border-radius: 22px;
    max-width: 400px; width: 100%;
    overflow: hidden;
    box-shadow: 0 28px 70px rgba(0,0,0,.32);
    animation: hklpUp .4s cubic-bezier(.34,1.56,.64,1);
}
@keyframes hklpUp { from{transform:translateY(44px) scale(.94);opacity:0} to{transform:none;opacity:1} }

/* ── Header ── */
.hklp-head {
    background: linear-gradient(135deg, #1a0533 0%, #D10024 55%, #ff6b35 100%);
    padding: 32px 24px 26px;
    text-align: center;
    position: relative; overflow: hidden;
}
.hklp-head::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='22' stroke='%23ffffff' stroke-opacity='0.06' stroke-width='1' fill='none'/%3E%3C/svg%3E");
}
.hklp-blob { position:absolute; border-radius:50%; background:rgba(255,255,255,.08); }
.hklp-blob.b1 { width:160px;height:160px; top:-50px; right:-40px; }
.hklp-blob.b2 { width:100px;height:100px; bottom:-28px; left:-18px; }

.hklp-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    border-radius: 20px;
    color: #fff; font-size: 11px; font-weight: 700;
    padding: 4px 12px; margin-bottom: 14px;
    position: relative; z-index: 1;
    letter-spacing: .4px; text-transform: uppercase;
}
.hklp-icon {
    width: 70px; height: 70px;
    background: rgba(255,255,255,.16);
    border: 2px solid rgba(255,255,255,.28);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 30px; color: #fff;
    margin-bottom: 14px; position: relative; z-index: 1;
    animation: hklpFloat 3.2s ease-in-out infinite;
}
@keyframes hklpFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
.hklp-title {
    font-size: 20px; font-weight: 900; color: #fff;
    line-height: 1.25; position: relative; z-index: 1;
    text-shadow: 0 3px 12px rgba(0,0,0,.3);
    margin-bottom: 7px;
}
.hklp-sub {
    font-size: 12.5px; color: rgba(255,255,255,.8);
    line-height: 1.5; position: relative; z-index: 1;
    max-width: 300px; margin: 0 auto;
}

/* close btn */
.hklp-close {
    position: absolute; top: 12px; right: 14px; z-index: 5;
    background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.28);
    color: #fff; width: 30px; height: 30px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; cursor: pointer; transition: background .18s;
}
.hklp-close:hover { background: rgba(255,255,255,.3); }

/* ── Feature list ── */
.hklp-feats {
    padding: 18px 20px 6px;
    display: flex; flex-direction: column; gap: 10px;
}
.hklp-feat {
    display: flex; align-items: center; gap: 12px;
    background: #fdf2f2; border-radius: 12px;
    padding: 10px 14px;
}
.hklp-feat-ico {
    width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #ffd6d6, #ffefef);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: #D10024;
}
.hklp-feat-txt { font-size: 12.5px; font-weight: 700; color: #444; }
.hklp-feat-txt small { font-weight: 500; color: #888; display: block; margin-top: 1px; }

/* ── Footer ── */
.hklp-footer { padding: 16px 20px 22px; display: flex; flex-direction: column; gap: 8px; }
.hklp-cta {
    display: block; width: 100%;
    background: linear-gradient(135deg, #D10024, #ff4455);
    color: #fff; font-weight: 800; font-size: 14.5px;
    padding: 13px 16px; border-radius: 13px; border: none;
    cursor: pointer; text-align: center;
    box-shadow: 0 6px 18px rgba(209,0,36,.35);
    transition: transform .18s, box-shadow .18s;
    text-decoration: none;
}
.hklp-cta:hover { transform: translateY(-2px); box-shadow: 0 10px 26px rgba(209,0,36,.45); color: #fff; }
.hklp-skip {
    background: none; border: none; width: 100%;
    color: #bbb; font-size: 12px; font-weight: 600;
    cursor: pointer; padding: 3px; transition: color .18s;
}
.hklp-skip:hover { color: #777; }

@media(max-width:440px){ .hklp-title{font-size:18px;} }
</style>

<div class="hklp-overlay" id="hklPopup" role="dialog" aria-modal="true" aria-labelledby="hklpTitle">
    <div class="hklp-box">
        <div class="hklp-head">
            <div class="hklp-blob b1"></div>
            <div class="hklp-blob b2"></div>
            <button class="hklp-close" onclick="hklpClose()" aria-label="Tutup"><i class="fa fa-times"></i></button>
            <div class="hklp-badge"><i class="fa fa-star"></i> Baru di NusaMart</div>
            <div class="hklp-icon"><i class="fa fa-cutlery"></i></div>
            <div class="hklp-title" id="hklpTitle">Memperkenalkan<br>Kuliner Lokal<br>Desa Manud Jaya</div>
            <p class="hklp-sub">Temukan warung dan kuliner asli khas desa — lengkap dengan info lokasi, jam buka, dan kontak langsung.</p>
        </div>

        <div class="hklp-feats">
            <div class="hklp-feat">
                <div class="hklp-feat-ico"><i class="fa fa-map-marker"></i></div>
                <div class="hklp-feat-txt">Lokasi & Google Maps <small>Alamat lengkap tiap warung</small></div>
            </div>
            <div class="hklp-feat">
                <div class="hklp-feat-ico"><i class="fa fa-clock-o"></i></div>
                <div class="hklp-feat-txt">Status Buka / Tutup Real-time <small>Cek langsung sebelum datang</small></div>
            </div>
            <div class="hklp-feat">
                <div class="hklp-feat-ico"><i class="fa fa-whatsapp"></i></div>
                <div class="hklp-feat-txt">Kontak WhatsApp <small>Pesan langsung ke warung</small></div>
            </div>
        </div>

        <div class="hklp-footer">
            <a href="{{ route('kuliner.index') }}" class="hklp-cta" onclick="hklpClose()">
                <i class="fa fa-cutlery"></i>&nbsp; Jelajahi Kuliner Sekarang
            </a>
            <button class="hklp-skip" onclick="hklpClose(true)">Jangan tampilkan lagi</button>
        </div>
    </div>
</div>

<script>
(function(){
    var popup = document.getElementById('hklPopup');
    if(!popup) return;
    var KEY = 'hklp_dismissed';
    if(localStorage.getItem(KEY) === '1'){
        popup.style.display = 'none';
        return;
    }
    document.body.style.overflow = 'hidden';
    popup.addEventListener('click', function(e){ if(e.target === popup) hklpClose(); });
    document.addEventListener('keydown', function kd(e){ if(e.key==='Escape'){ hklpClose(); document.removeEventListener('keydown',kd); } });
})();

function hklpClose(remember){
    var popup = document.getElementById('hklPopup');
    if(!popup || popup.style.display==='none') return;
    if(remember) localStorage.setItem('hklp_dismissed','1');
    popup.classList.add('hklp-hiding');
    document.body.style.overflow = '';
    setTimeout(function(){ popup.style.display='none'; }, 270);
}
</script>

@endpush
