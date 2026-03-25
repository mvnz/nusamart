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
        @elseif(!auth()->check())
        {{-- Tampilkan logo lebih besar untuk halaman utama (guest) --}}
        @endif
    </div>
</header>
