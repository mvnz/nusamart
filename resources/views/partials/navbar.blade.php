<!-- Navigation -->
<nav class="main-nav" id="mainNav">
    <div class="container">
        <button class="nav-categories-btn"><i class="fa fa-bars"></i> Kategori</button>
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
            @auth
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.users') }}">Pengguna</a>
            @elseif(auth()->user()->role == 'penjual')
            @else
            @endif
            @endauth
            <a href="{{ route('page.bantuan') }}">Bantuan</a>

            {{-- User dropdown hanya tampil di mobile (top-bar tersembunyi) --}}
            @auth
            <div class="user-dropdown nav-user-dropdown">
                <a href="#" class="user-dropdown-toggle" id="navUserDropdownToggle" onclick="this.parentElement.classList.toggle('open');return false;"><i class="fa fa-user-o"></i> {{ auth()->user()->username }} <i class="fa fa-caret-down"></i></a>
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
