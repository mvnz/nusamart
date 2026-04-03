<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Center - NusaMart')</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @stack('styles')
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Montserrat', sans-serif; background: #f4f5f7; color: #1e1f29; }

    /* ─── Layout shell ─── */
    .sc-wrapper { display: flex; min-height: 100vh; }

    /* ─── Sidebar ─── */
    .sc-sidebar {
        width: 240px; flex-shrink: 0; background: #1a1f2e;
        display: flex; flex-direction: column;
        position: fixed; top: 0; left: 0; height: 100vh; z-index: 200;
        transition: width .25s ease;
        overflow: hidden;
    }
    .sc-sidebar.collapsed { width: 62px; }

    .sc-sidebar-logo {
        display: flex; align-items: center; gap: 10px;
        padding: 18px 16px; border-bottom: 1px solid rgba(255,255,255,.07);
        text-decoration: none; overflow: hidden; white-space: nowrap;
    }
    .sc-logo-icon {
        width: 34px; height: 34px; background: #D10024; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-weight: 800; font-size: 16px; flex-shrink: 0;
    }
    .sc-logo-text { color: #fff; font-size: 15px; font-weight: 800; }
    .sc-logo-text span { color: #D10024; }

    .sc-store-info {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 16px 10px; border-bottom: 1px solid rgba(255,255,255,.07);
        overflow: hidden; white-space: nowrap;
    }
    .sc-store-avatar {
        width: 34px; height: 34px; background: linear-gradient(135deg,#D10024,#ff5c73);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        color: #fff; font-weight: 700; font-size: 14px; flex-shrink: 0;
    }
    .sc-store-name { font-size: 13px; font-weight: 700; color: #fff; }
    .sc-store-role { font-size: 11px; color: #8892a4; }

    /* Nav */
    .sc-nav { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 10px 0; }
    .sc-nav::-webkit-scrollbar { width: 3px; }
    .sc-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 2px; }

    .sc-nav-item { list-style: none; }
    .sc-nav-link {
        display: flex; align-items: center; gap: 12px; padding: 11px 16px;
        color: #8892a4; text-decoration: none; font-size: 13px; font-weight: 500;
        transition: background .15s, color .15s; white-space: nowrap; overflow: hidden;
        border-left: 3px solid transparent;
    }
    .sc-nav-link i { font-size: 16px; flex-shrink: 0; width: 20px; text-align: center; }
    .sc-nav-link:hover { background: rgba(255,255,255,.05); color: #fff; }
    .sc-nav-link.active { background: rgba(209,0,36,.12); color: #ff4060; border-left-color: #D10024; }

    .sc-nav-section { padding: 16px 16px 6px; font-size: 10px; font-weight: 700; color: #4a5568; text-transform: uppercase; letter-spacing: .8px; white-space: nowrap; overflow: hidden; }
    .sc-sidebar.collapsed .sc-nav-section { opacity: 0; }

    /* Submenu */
    .sc-submenu { display: none; background: rgba(0,0,0,.15); }
    .sc-submenu.open { display: block; }
    .sc-submenu .sc-nav-link { padding: 9px 16px 9px 48px; font-size: 12px; }
    .sc-sidebar.collapsed .sc-submenu { display: none; }

    .sc-nav-arrow { margin-left: auto; font-size: 11px; transition: transform .2s; flex-shrink: 0; }
    .sc-nav-link.open .sc-nav-arrow { transform: rotate(90deg); }

    /* Sidebar bottom */
    .sc-sidebar-bottom { border-top: 1px solid rgba(255,255,255,.07); padding: 10px 0; }

    /* ─── Main ─── */
    .sc-main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; transition: margin-left .25s ease; }
    .sc-main.expanded { margin-left: 62px; }

    /* Topbar */
    .sc-topbar {
        position: sticky; top: 0; z-index: 100;
        height: 56px; background: #fff; border-bottom: 1px solid #e8eaf0;
        display: flex; align-items: center; gap: 14px; padding: 0 24px;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }
    .sc-topbar-toggle {
        background: none; border: none; cursor: pointer;
        color: #555; font-size: 18px; padding: 4px; border-radius: 6px;
        transition: background .15s;
    }
    .sc-topbar-toggle:hover { background: #f4f5f7; }
    .sc-topbar-breadcrumb { font-size: 13px; color: #888; flex: 1; }
    .sc-topbar-breadcrumb strong { color: #1e1f29; }
    .sc-topbar-actions { display: flex; align-items: center; gap: 12px; }
    .sc-topbar-btn {
        width: 34px; height: 34px; background: #f4f5f7; border: none; border-radius: 8px;
        cursor: pointer; color: #555; font-size: 15px;
        display: flex; align-items: center; justify-content: center; position: relative;
        transition: background .15s;
    }
    .sc-topbar-btn:hover { background: #e8eaf0; }
    .sc-notif-dot {
        position: absolute; top: 6px; right: 6px; width: 7px; height: 7px;
        background: #D10024; border-radius: 50%; border: 1.5px solid #fff;
    }
    .sc-topbar-avatar {
        width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg,#D10024,#ff5c73);
        display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 13px; cursor: pointer;
        overflow: hidden; flex-shrink: 0;
    }
    .sc-topbar-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .sc-topbar-user { font-size: 13px; }
    .sc-topbar-user strong { display: block; font-weight: 700; color: #1e1f29; font-size: 13px; }
    .sc-topbar-user span { font-size: 11px; color: #888; }

    .sc-topbar-dropdown { position: relative; }
    .sc-topbar-dropdown-menu {
        display: none; position: absolute; top: 44px; right: 0;
        background: #fff; border-radius: 10px; box-shadow: 0 8px 30px rgba(0,0,0,.12);
        min-width: 180px; z-index: 999; overflow: hidden;
    }
    .sc-topbar-dropdown-menu.open { display: block; }
    .sc-topbar-dropdown-menu a, .sc-topbar-dropdown-menu button {
        display: flex; align-items: center; gap: 10px;
        width: 100%; padding: 11px 16px; font-size: 13px; color: #333;
        text-decoration: none; background: none; border: none; cursor: pointer; font-family: inherit;
        transition: background .15s;
    }
    .sc-topbar-dropdown-menu a:hover, .sc-topbar-dropdown-menu button:hover { background: #f9f9f9; }
    .sc-topbar-dropdown-menu .divider { height: 1px; background: #f0f0f0; margin: 4px 0; }
    .sc-topbar-dropdown-menu .danger { color: #D10024; }

    /* Content */
    .sc-content { flex: 1; padding: 28px 28px 48px; }
    @media(max-width:900px) { .sc-content { padding: 16px; } }
    </style>
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
                <button class="sc-topbar-btn" title="Notifikasi">
                    <i class="fa fa-bell-o"></i>
                    <span class="sc-notif-dot"></span>
                </button>
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
