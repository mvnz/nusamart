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

.nav-pengaturan { position: relative; }
.nav-pengaturan-btn {
    background: none;
    border: none;
    color: #fff;
    padding: 12px 16px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    transition: all 0.2s;
    text-decoration: none;
}
.nav-pengaturan-btn:hover, .nav-pengaturan-btn.active {
    background: rgba(255,255,255,0.08);
    border-radius: 6px;
    color: #fff;
}
.nav-pengaturan-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    display: none;
    min-width: 200px;
    z-index: 1000;
    overflow: hidden;
    margin-top: 4px;
}
.nav-pengaturan-dropdown.active { display: block; }
.nav-pengaturan-dropdown a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 16px;
    text-decoration: none;
    color: #444;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
    border-left: 3px solid transparent;
}
.nav-pengaturan-dropdown a:hover {
    background: #f9f9f9;
    border-left-color: #D10024;
    color: #D10024;
}
.nav-pengaturan-dropdown a i { color: #D10024; width: 16px; text-align: center; }

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
            @if(!auth()->check() || auth()->user()->role !== 'admin')
            @php
            $navIconColors = ['#e74c3c','#3498db','#9b59b6','#27ae60','#e67e22','#16a085','#f39c12','#e91e8c','#1abc9c','#2c3e50'];
            @endphp
            <button class="nav-categories-btn" id="navCategoryBtn"><i class="fa fa-bars"></i> Kategori</button>
            <div class="nav-categories-dropdown" id="navCategoryDropdown">
                <div class="nav-dropdown-header">Kategori Produk</div>
                <div class="nav-dropdown-items">
                    <a href="{{ route('categories.index') }}" class="nav-dropdown-item {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                        <div class="nav-dropdown-item-icon" style="background: #666;">
                            <i class="fa fa-th"></i>
                        </div>
                        <span>Semua Kategori</span>
                    </a>
                    @foreach($navCategories as $navIdx => $navCat)
                    <a href="{{ route('products.index', ['category_id' => $navCat->id]) }}" class="nav-dropdown-item {{ request('category_id') == $navCat->id ? 'active' : '' }}">
                        <div class="nav-dropdown-item-icon" style="background: {{ $navIconColors[$navIdx % count($navIconColors)] }};">
                            <i class="fa fa-tag"></i>
                        </div>
                        <span>{{ $navCat->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="nav-menu">
            @auth
            @if(auth()->user()->role == 'admin')
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <div class="nav-pengaturan" id="navPengaturan">
                <button class="nav-pengaturan-btn {{ request()->routeIs('admin.*') ? 'active' : '' }}" id="navPengaturanBtn">
                    <i class="fa fa-cog"></i> Pengaturan <i class="fa fa-caret-down" style="font-size:11px"></i>
                </button>
                <div class="nav-pengaturan-dropdown" id="navPengaturanDropdown">
                    <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fa fa-tags"></i> Kategori
                    </a>
                    <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i> Pengguna
                    </a>
                    <a href="{{ route('admin.couriers') }}" class="{{ request()->routeIs('admin.couriers*') ? 'active' : '' }}">
                        <i class="fa fa-truck"></i> Kurir
                    </a>
                </div>
            </div>
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

// Pengaturan dropdown
(function() {
    var btn = document.getElementById('navPengaturanBtn');
    var dropdown = document.getElementById('navPengaturanDropdown');
    if (!btn) return;
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('active');
        btn.classList.toggle('active');
    });
    document.addEventListener('click', function(e) {
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
            btn.classList.remove('active');
        }
    });
})();
</script>
