<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-left">
            <span><i class="fa fa-phone"></i> +62 21-1000-000</span>
            <span><i class="fa fa-envelope-o"></i> cs@tokonusamart.com</span>
        </div>
        <div class="top-bar-right">
            @auth
            @if(auth()->user()->role == 'penjual')
            <a href="{{ route('products.my-products') }}" class="topbar-link" style="margin-right: 20px;"><i class="fa fa-cube"></i> Produk Saya</a>
            @endif
            <div class="user-dropdown">
                <a href="#" class="user-dropdown-toggle" id="userDropdownToggle"><i class="fa fa-user-o"></i> {{ auth()->user()->username }} <i class="fa fa-caret-down"></i></a>
                <div class="user-dropdown-menu" id="userDropdownMenu">
                    <a href="{{ route('profile') }}"><i class="fa fa-user"></i> Akun Saya</a>
                    <!-- @if(auth()->user()->role == 'pembeli')
                        <a href="#"><i class="fa fa-shopping-bag"></i> Pesanan Saya</a>
                    @elseif(auth()->user()->role == 'penjual')
                        <a href="#"><i class="fa fa-cube"></i> Pesanan</a>
                    @endif
                    <div class="dropdown-divider"></div> -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-logout-btn"><i class="fa fa-sign-out"></i> Logout</button>
                    </form>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" style="color: #fff; text-decoration: none;"><i class="fa fa-sign-in"></i> Masuk</a>
            @endauth
        </div>
    </div>
</div>
