<!-- Navigation -->
<style>
.nav-categories-btn{background:none!important;border:1px solid rgba(255,255,255,0.3)!important;color:#fff;padding:10px 16px;font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;white-space:nowrap;border-radius:6px;transition:all .2s}
.nav-categories-btn:hover,.nav-categories-btn.active{background:rgba(255,255,255,0.1)!important;border-color:rgba(255,255,255,0.5)!important}
.nav-pengaturan-btn{background:none!important;border:none!important;color:#fff!important;padding:10px 14px!important;font-size:14px!important;font-weight:600!important;cursor:pointer!important;display:flex!important;align-items:center!important;gap:7px!important;white-space:nowrap!important;transition:all .2s!important;text-decoration:none!important;border-radius:8px!important}
.nav-pengaturan-btn:hover,.nav-pengaturan-btn.active{background:rgba(255,255,255,0.12)!important;color:#fff!important}
.nav-pengaturan-btn .caret-icon{transition:transform .25s ease!important;font-size:10px!important}
.nav-pengaturan-btn.active .caret-icon{transform:rotate(180deg)!important}
#navCategoryDropdown{display:none!important}#navCategoryDropdown.active{display:block!important}
#navPengaturanDropdown{display:none!important;opacity:0;transform:translateY(-6px);transition:opacity .2s ease,transform .2s ease!important}#navPengaturanDropdown.active{display:block!important;opacity:1!important;transform:translateY(0)!important}
.npd-header{padding:12px 16px 10px;border-bottom:1px solid #f3f3f6;margin-bottom:4px}
.npd-header-title{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.7px;color:#bbb}
.npd-item{display:flex;align-items:center;gap:12px;padding:10px 16px;color:#333;text-decoration:none;font-size:13.5px;font-weight:600;transition:background .15s,color .15s;border-radius:0;position:relative}
.npd-item:hover{background:#fef2f2;color:#D10024}
.npd-item.active{background:#fef2f2;color:#D10024}
.npd-item.active::before{content:'';position:absolute;left:0;top:20%;height:60%;width:3px;background:#D10024;border-radius:0 3px 3px 0}
.npd-icon{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;transition:transform .15s}
.npd-item:hover .npd-icon{transform:scale(1.1)}
.npd-icon.red{background:linear-gradient(135deg,#ffd6d6,#ffefef);color:#D10024}
.npd-icon.blue{background:linear-gradient(135deg,#c9e9ff,#edf6ff);color:#1565c0}
.npd-icon.green{background:linear-gradient(135deg,#c8f7d6,#edfff3);color:#1a9e50}
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
                    <i class="fa fa-cog"></i> Pengaturan <i class="fa fa-caret-down caret-icon"></i>
                </button>
                <div class="nav-pengaturan-dropdown" id="navPengaturanDropdown" style="position:absolute;top:calc(100% + 8px);left:0;background:#fff;border-radius:14px;box-shadow:0 12px 40px rgba(0,0,0,0.16);min-width:210px;z-index:1000;overflow:hidden;padding:6px 0">
                    <a href="{{ route('admin.categories') }}" class="npd-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <div class="npd-icon red"><i class="fa fa-tags"></i></div>
                        <div>
                            <div style="font-size:13.5px;font-weight:700">Kategori</div>
                            <div style="font-size:11px;color:#aaa;font-weight:500">Kelola kategori produk</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.users') }}" class="npd-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <div class="npd-icon blue"><i class="fa fa-users"></i></div>
                        <div>
                            <div style="font-size:13.5px;font-weight:700">Pengguna</div>
                            <div style="font-size:11px;color:#aaa;font-weight:500">Kelola akun pengguna</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.couriers') }}" class="npd-item {{ request()->routeIs('admin.couriers*') ? 'active' : '' }}">
                        <div class="npd-icon green"><i class="fa fa-truck"></i></div>
                        <div>
                            <div style="font-size:13.5px;font-weight:700">Kurir</div>
                            <div style="font-size:11px;color:#aaa;font-weight:500">Kelola layanan kurir</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.promos') }}" class="npd-item {{ request()->routeIs('admin.promos*') ? 'active' : '' }}" style="margin-bottom:6px">
                        <div class="npd-icon" style="background:#fff0e6;color:#e67e22;"><i class="fa fa-tag"></i></div>
                        <div>
                            <div style="font-size:13.5px;font-weight:700">Promo</div>
                            <div style="font-size:11px;color:#aaa;font-weight:500">Monitor promo penjual</div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endauth
            @auth
            @if(auth()->user()->role === 'penjual')
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') || request()->routeIs('seller.*') ? 'active' : '' }}">Dashboard</a>
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
