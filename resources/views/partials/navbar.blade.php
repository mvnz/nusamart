<!-- Navigation -->
<style>
.nav-categories-btn{background:none!important;border:1px solid rgba(255,255,255,0.3)!important;color:#fff;padding:10px 16px;font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;white-space:nowrap;border-radius:6px;transition:all .2s}
.nav-categories-btn:hover,.nav-categories-btn.active{background:rgba(255,255,255,0.1)!important;border-color:rgba(255,255,255,0.5)!important}
.nav-pengaturan-btn{background:none!important;border:none!important;color:#fff!important;padding:12px 16px!important;font-size:14px!important;font-weight:600!important;cursor:pointer!important;display:flex!important;align-items:center!important;gap:6px!important;white-space:nowrap!important;transition:all .2s!important;text-decoration:none!important}
.nav-pengaturan-btn:hover,.nav-pengaturan-btn.active{background:rgba(255,255,255,0.08)!important;border-radius:6px!important;color:#fff!important}
#navCategoryDropdown{display:none!important}#navCategoryDropdown.active{display:block!important}
#navPengaturanDropdown{display:none!important}#navPengaturanDropdown.active{display:block!important}
@media(max-width:768px){.nav-mobile-login{display:flex!important;align-items:center;gap:8px;padding:12px 20px;color:#fff!important;text-decoration:none;border-top:1px solid rgba(255,255,255,.07);font-size:14px;font-weight:600}.nav-mobile-login:hover{background:rgba(255,255,255,.08)}}
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
            <div class="nav-pengaturan" id="navPengaturan" style="position:relative">
                <button class="nav-pengaturan-btn {{ request()->routeIs('admin.*') ? 'active' : '' }}" id="navPengaturanBtn">
                    <i class="fa fa-cog"></i> Pengaturan <i class="fa fa-caret-down" style="font-size:11px"></i>
                </button>
                <div class="nav-pengaturan-dropdown" id="navPengaturanDropdown" style="position:absolute;top:100%;left:0;background:#fff;border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,0.15);min-width:200px;z-index:1000;padding:8px 0">
                    <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;color:#333;text-decoration:none;font-size:14px;font-weight:500">
                        <i class="fa fa-tags" style="color:#D10024;width:16px"></i> Kategori
                    </a>
                    <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;color:#333;text-decoration:none;font-size:14px;font-weight:500">
                        <i class="fa fa-users" style="color:#D10024;width:16px"></i> Pengguna
                    </a>
                    <a href="{{ route('admin.couriers') }}" class="{{ request()->routeIs('admin.couriers*') ? 'active' : '' }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;color:#333;text-decoration:none;font-size:14px;font-weight:500">
                        <i class="fa fa-truck" style="color:#D10024;width:16px"></i> Kurir
                    </a>
                </div>
            </div>
            @endif
            @endauth
            <a href="{{ route('page.bantuan') }}" class="{{ request()->routeIs('page.bantuan') ? 'active' : '' }}">Bantuan</a>

            {{-- Link Masuk hanya tampil di mobile (top-bar tersembunyi) --}}
            @guest
            <a href="{{ route('login') }}" style="display:none" class="nav-mobile-login"><i class="fa fa-sign-in"></i> Masuk</a>
            @endguest

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
