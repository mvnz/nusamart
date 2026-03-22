<!-- Navigation -->
<nav class="main-nav" id="mainNav">
    <div class="container">
        <button class="nav-categories-btn"><i class="fa fa-bars"></i> Kategori</button>
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
            @auth
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.users') }}">Pengguna</a>
                <!--<a href="#">Produk</a>
                <a href="#">Kategori</a>
                <a href="#">Laporan</a> -->
            @elseif(auth()->user()->role == 'penjual')
                <!--<a href="#">Produk Saya</a>
                <a href="#">Pesanan</a>
                <a href="#">Keuangan</a>
                <a href="#">Statistik</a> -->
            @else
                <!--<a href="#">Promo</a>
                <a href="#">Kategori</a>
                <a href="#">Pesanan Saya</a> -->
            @endif
            @endauth
            <a href="{{ route('page.bantuan') }}">Bantuan</a>
        </div>
       
    </div>
</nav>
