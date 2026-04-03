<!-- Navigation -->
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
