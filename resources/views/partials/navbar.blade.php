<!-- Navigation -->
<style>
.nav-menu a::after { display: none !important; }
.nav-user-dropdown { display: none !important; }

/* Category Button & Dropdown Styles */
.nav-categories-btn {
    background: none;
    border: none;
    color: #fff;
    padding: 12px 16px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    transition: all 0.2s;
}
.nav-categories-btn:hover {
    background: rgba(255,255,255,0.08);
    border-radius: 6px;
}
.nav-categories-btn.active {
    background: rgba(209,0,36,0.2);
    border-radius: 6px;
}

.nav-categories-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    display: none;
    min-width: 240px;
    z-index: 1000;
    overflow: hidden;
}
.nav-categories-dropdown.active { display: block; }

.nav-dropdown-header {
    padding: 12px 16px;
    background: #f9f9f9;
    border-bottom: 1px solid #f0f0f0;
    font-size: 12px;
    font-weight: 700;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.nav-dropdown-items {
    display: flex;
    flex-direction: column;
    gap: 0;
    max-height: 400px;
    overflow-y: auto;
}

.nav-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    text-decoration: none;
    color: #444;
    font-size: 13px;
    transition: all 0.2s;
    border-left: 3px solid transparent;
}
.nav-dropdown-item:hover {
    background: #f9f9f9;
    border-left-color: #D10024;
}
.nav-dropdown-item.active {
    background: rgba(209,0,36,0.08);
    border-left-color: #D10024;
    color: #D10024;
    font-weight: 600;
}
.nav-dropdown-item-icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    color: #fff;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .nav-user-dropdown { display: block !important; position: relative; border-top: 1px solid rgba(255,255,255,0.07); }
    .nav-user-dropdown .user-dropdown-toggle { color: #fff; padding: 12px 20px; display: flex; align-items: center; gap: 6px; text-decoration: none; }
    .nav-user-dropdown .user-dropdown-menu { position: absolute; left: 10px; right: 10px; top: 100%; z-index: 9999; background: #fff; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.18); display: none; overflow: hidden; }
    .nav-user-dropdown.open .user-dropdown-menu { display: block; }
    .nav-user-dropdown .user-dropdown-menu a { display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: #333 !important; }
    .nav-user-dropdown .user-dropdown-menu a:hover { background: #f6f6f6; }
    .nav-user-dropdown .dropdown-logout-btn { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 16px; font-size: 13px; color: #D10024; background: none; border: none; cursor: pointer; font-family: inherit; }
}
</style>
<nav class="main-nav" id="mainNav">
    <div class="container">
        <div style="position: relative;">
            <button class="nav-categories-btn" id="navCategoryBtn"><i class="fa fa-bars"></i> Kategori</button>
            <div class="nav-categories-dropdown" id="navCategoryDropdown">
                <div class="nav-dropdown-header">Kategori Produk</div>
                <div class="nav-dropdown-items">
                    <a href="#" class="nav-dropdown-item" data-category="all" onclick="filterByCategory(null, 'all'); return false;">
                        <div class="nav-dropdown-item-icon" style="background: #666;">
                            <i class="fa fa-th"></i>
                        </div>
                        <span>Semua Kategori</span>
                    </a>
                    <a href="#" class="nav-dropdown-item" data-category="makanan" onclick="filterByCategory(this); return false;">
                        <div class="nav-dropdown-item-icon" style="background: #e74c3c;">
                            <i class="fa fa-cutlery"></i>
                        </div>
                        <span>Makanan</span>
                    </a>
                    <a href="#" class="nav-dropdown-item" data-category="minuman" onclick="filterByCategory(this); return false;">
                        <div class="nav-dropdown-item-icon" style="background: #3498db;">
                            <i class="fa fa-coffee"></i>
                        </div>
                        <span>Minuman</span>
                    </a>
                    <a href="#" class="nav-dropdown-item" data-category="fashion" onclick="filterByCategory(this); return false;">
                        <div class="nav-dropdown-item-icon" style="background: #9b59b6;">
                            <i class="fa fa-shopping-bag"></i>
                        </div>
                        <span>Fashion</span>
                    </a>
                    <a href="#" class="nav-dropdown-item" data-category="kerajinan" onclick="filterByCategory(this); return false;">
                        <div class="nav-dropdown-item-icon" style="background: #e67e22;">
                            <i class="fa fa-paint-brush"></i>
                        </div>
                        <span>Kerajinan</span>
                    </a>
                    <a href="#" class="nav-dropdown-item" data-category="kesehatan" onclick="filterByCategory(this); return false;">
                        <div class="nav-dropdown-item-icon" style="background: #27ae60;">
                            <i class="fa fa-leaf"></i>
                        </div>
                        <span>Kesehatan</span>
                    </a>
                    <a href="#" class="nav-dropdown-item" data-category="pertanian" onclick="filterByCategory(this); return false;">
                        <div class="nav-dropdown-item-icon" style="background: #16a085;">
                            <i class="fa fa-pagelines"></i>
                        </div>
                        <span>Pertanian</span>
                    </a>
                    <a href="#" class="nav-dropdown-item" data-category="rumah-tangga" onclick="filterByCategory(this); return false;">
                        <div class="nav-dropdown-item-icon" style="background: #f39c12;">
                            <i class="fa fa-home"></i>
                        </div>
                        <span>Rumah Tangga</span>
                    </a>
                    <a href="#" class="nav-dropdown-item" data-category="souvenir" onclick="filterByCategory(this); return false;">
                        <div class="nav-dropdown-item-icon" style="background: #e91e8c;">
                            <i class="fa fa-gift"></i>
                        </div>
                        <span>Souvenir</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="nav-menu">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            @auth
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Pengguna</a>
            @elseif(auth()->user()->role == 'penjual')
            @else
            @endif
            @endauth
            <a href="{{ route('page.bantuan') }}" class="{{ request()->routeIs('page.bantuan') ? 'active' : '' }}">Bantuan</a>

            {{-- User dropdown hanya tampil di mobile (top-bar tersembunyi) --}}
            @auth
            <div class="user-dropdown nav-user-dropdown">
                <a href="#" class="user-dropdown-toggle" onclick="this.parentElement.classList.toggle('open');return false;"><i class="fa fa-user-o"></i> {{ auth()->user()->username }} <i class="fa fa-caret-down"></i></a>
                <div class="user-dropdown-menu">
                    <a href="{{ route('profile') }}"><i class="fa fa-user"></i> Akun Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-logout-btn"><i class="fa fa-sign-out"></i> Logout</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</nav>

<script>
// Category dropdown in navbar
(function() {
    var categoryBtn = document.getElementById('navCategoryBtn');
    var categoryDropdown = document.getElementById('navCategoryDropdown');

    if (categoryBtn) {
        categoryBtn.addEventListener('click', function() {
            categoryDropdown.classList.toggle('active');
            categoryBtn.classList.toggle('active');
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (categoryBtn && !categoryBtn.contains(e.target) && !categoryDropdown.contains(e.target)) {
            categoryDropdown.classList.remove('active');
            categoryBtn.classList.remove('active');
        }
    });
})();
</script>
