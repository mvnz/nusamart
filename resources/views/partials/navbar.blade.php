<!-- Navigation -->
<style>
.nav-user-dropdown { display: none !important; }
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
        <button class="nav-categories-btn"><i class="fa fa-bars"></i> Kategori</button>
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            @auth
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
