<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Center - NusaMart')</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/seller.css') }}">
    @stack('styles')
</head>
<body>
<div class="sc-wrapper">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="sc-sidebar" id="scSidebar">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="sc-sidebar-logo">
            <div class="sc-logo-icon">N</div>
            <span class="sc-logo-text">Nusa<span>Mart</span></span>
        </a>

        {{-- Store Info --}}
        <div class="sc-store-info">
            <div class="sc-store-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="sc-store-name">{{ auth()->user()->name }}</div>
                <div class="sc-store-role">Seller Center</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sc-nav">
            <ul style="list-style:none;">
                <li class="sc-nav-item">
                    <a href="{{ route('dashboard') }}" class="sc-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa fa-home"></i> <span>Beranda</span>
                    </a>
                </li>

                <li class="sc-nav-item sc-nav-section">Produk</li>
                <li class="sc-nav-item">
                    <a href="#" class="sc-nav-link {{ request()->routeIs('products.*') ? 'active open' : '' }}" onclick="toggleSubmenu('submenuProduk', this); return false;">
                        <i class="fa fa-cube"></i>
                        <span>Produk</span>
                        <i class="fa fa-chevron-right sc-nav-arrow"></i>
                    </a>
                    <ul class="sc-submenu {{ request()->routeIs('products.*') ? 'open' : '' }}" id="submenuProduk">
                        <li><a href="{{ route('products.my-products') }}" class="sc-nav-link {{ request()->routeIs('products.my-products') ? 'active' : '' }}"><i class="fa fa-list"></i> <span>Daftar Produk</span></a></li>
                        <li><a href="{{ route('products.my-products') }}#tambah" class="sc-nav-link"><i class="fa fa-plus"></i> <span>Tambah Produk</span></a></li>
                    </ul>
                </li>

                <li class="sc-nav-item sc-nav-section">Transaksi</li>
                <li class="sc-nav-item">
                    <a href="{{ route('seller.orders') }}" class="sc-nav-link {{ request()->routeIs('seller.orders*') ? 'active' : '' }}">
                        <i class="fa fa-shopping-bag"></i> <span>Pesanan</span>
                    </a>
                </li>

                <li class="sc-nav-item sc-nav-section">Akun</li>
                <li class="sc-nav-item">
                    <a href="{{ route('profile') }}" class="sc-nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="fa fa-user"></i> <span>Profil</span>
                    </a>
                </li>
                <li class="sc-nav-item">
                    <a href="{{ route('home') }}" class="sc-nav-link">
                        <i class="fa fa-shopping-cart"></i> <span>Lihat Toko</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Bottom --}}
        <div class="sc-sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sc-nav-link" style="width:100%;cursor:pointer;background:none;border:none;font-family:inherit;">
                    <i class="fa fa-sign-out"></i> <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ══ MAIN ══ --}}
    <div class="sc-main" id="scMain">

        {{-- Topbar --}}
        <div class="sc-topbar">
            <button class="sc-topbar-toggle" id="sidebarToggle" title="Toggle sidebar">
                <i class="fa fa-bars"></i>
            </button>
            <div class="sc-topbar-breadcrumb">
                {!! $__env->yieldContent('breadcrumb', '<strong>Beranda</strong>') !!}
            </div>
            <div class="sc-topbar-actions">
                <div class="sc-topbar-dropdown" id="topbarDropdown">
                    <div style="display:flex;align-items:center;gap:8px;cursor:pointer;" onclick="document.getElementById('topbarMenu').classList.toggle('open')">
                        <div class="sc-topbar-avatar">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="sc-topbar-user" style="display:none;">
                            <strong>{{ auth()->user()->name }}</strong>
                            <span>Penjual</span>
                        </div>
                    </div>
                    <div class="sc-topbar-dropdown-menu" id="topbarMenu">
                        <a href="{{ route('profile') }}"><i class="fa fa-user-o"></i> Profil Saya</a>
                        <a href="{{ route('profile.password') }}"><i class="fa fa-lock"></i> Ganti Password</a>
                        <div class="divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="danger"><i class="fa fa-sign-out"></i> Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <main class="sc-content">
            @yield('content')
        </main>
    </div>
</div>

<script>
// Sidebar toggle
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('scSidebar').classList.toggle('collapsed');
    document.getElementById('scMain').classList.toggle('expanded');
});

// Submenu toggle
function toggleSubmenu(id, link) {
    const menu = document.getElementById(id);
    menu.classList.toggle('open');
    link.classList.toggle('open');
}

// Close dropdown on outside click
document.addEventListener('click', function (e) {
    const dd = document.getElementById('topbarDropdown');
    if (!dd.contains(e.target)) {
        document.getElementById('topbarMenu').classList.remove('open');
    }
});
</script>
@stack('scripts')
</body>
</html>
