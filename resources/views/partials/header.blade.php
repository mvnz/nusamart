<!-- Main Header -->
<header class="main-header">
    <div class="container">
        <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fa fa-bars"></i></button>
        <div class="logo-section">
            <a href="#">
                <div class="logo-icon">N</div>
                <span class="logo-text">Nusa<span>Mart</span></span>
            </a>
        </div>
        @if(auth()->check() && auth()->user()->role !== 'admin')
        <div class="search-bar">
            <select>
                <option>Semua Kategori</option>
                <option>Makanan</option>
                <option>Minuman</option>
                <option>Fashion</option>
                <option>Kerajinan</option>
                <option>Kesehatan</option>
            </select>
            <input type="text" placeholder="Cari produk...">
            <button><i class="fa fa-search"></i> Cari</button>
        </div>
        <div class="header-right">
            <a href="#" class="header-icon">
                <i class="fa fa-heart-o"></i>
                <span class="count-badge">2</span>
                <span class="icon-label">Your Wishlist</span>
            </a>
            <div class="cart-summary">
                <a href="#" class="header-icon" id="cartToggle">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="count-badge">3</span>
                    <span class="icon-label">Your Cart</span>
                </a>
                <div class="cart-dropdown" id="cartDropdown">
                    <div class="cart-dropdown-items">
                        <div class="cart-dropdown-item">
                            <div class="cart-item-img"><i class="fa fa-coffee"></i></div>
                            <div class="cart-item-info">
                                <div class="cart-item-name">Kopi Gayo Premium 250g</div>
                                <div class="cart-item-qty">1x <span class="cart-item-price">Rp 95.000</span></div>
                            </div>
                            <button class="cart-item-remove"><i class="fa fa-close"></i></button>
                        </div>
                        <div class="cart-dropdown-item">
                            <div class="cart-item-img"><i class="fa fa-shopping-bag"></i></div>
                            <div class="cart-item-info">
                                <div class="cart-item-name">Batik Pekalongan Motif Modern</div>
                                <div class="cart-item-qty">1x <span class="cart-item-price">Rp 250.000</span></div>
                            </div>
                            <button class="cart-item-remove"><i class="fa fa-close"></i></button>
                        </div>
                        <div class="cart-dropdown-item">
                            <div class="cart-item-img"><i class="fa fa-fire"></i></div>
                            <div class="cart-item-info">
                                <div class="cart-item-name">Sambal Matah Bali Asli</div>
                                <div class="cart-item-qty">1x <span class="cart-item-price">Rp 35.000</span></div>
                            </div>
                            <button class="cart-item-remove"><i class="fa fa-close"></i></button>
                        </div>
                    </div>
                    <div class="cart-dropdown-summary">
                        <div class="cart-dropdown-count">3 Item(s) dipilih</div>
                        <div class="cart-dropdown-subtotal">SUBTOTAL: <span>Rp 380.000</span></div>
                    </div>
                    <div class="cart-dropdown-actions">
                        <a href="#" class="cart-btn-view">Lihat Keranjang</a>
                        <a href="#" class="cart-btn-checkout">Checkout <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</header>
