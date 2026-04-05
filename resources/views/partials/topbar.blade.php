<!-- Top Bar -->
@php
    $tdUser = auth()->user() ?? null;
    $tdOrderCount = 0;
    if ($tdUser && $tdUser->role === 'pembeli') {
        try { $tdOrderCount = \App\Models\Order::where('user_id', $tdUser->id)->count(); } catch(\Exception $e){}
    }
    $tdInitial = $tdUser ? strtoupper(substr($tdUser->name ?? $tdUser->username, 0, 1)) : '?';
    $tdColors = ['#D10024','#3498db','#9b59b6','#27ae60','#e67e22','#16a085','#e91e63'];
    $tdColor  = $tdUser ? $tdColors[ord($tdInitial) % count($tdColors)] : '#D10024';
    $tdRoleLabel = match($tdUser?->role ?? '') { 'admin' => 'Admin', 'penjual' => 'Penjual', 'pembeli' => 'Pembeli', default => '' };
@endphp
<div class="top-bar">
    <div class="container">
        <div class="top-bar-left">
            <span><i class="fa fa-phone"></i> +62 21-1000-000</span>
            <span><i class="fa fa-envelope-o"></i> cs@tokonusamart.com</span>
        </div>
        <div class="top-bar-right">
            @auth
            <div class="user-dropdown" id="userDropdownWrap">
                <a href="#" class="user-dropdown-toggle" id="userDropdownToggle">
                    @if($tdUser->photo)
                    <span class="td-avatar-sm" style="width:22px;height:22px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;background:#f0f0f0;padding:0;vertical-align:middle">
                        <img src="{{ asset('storage/' . $tdUser->photo) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                    </span>
                    @else
                    <span class="td-avatar-sm" style="width:22px;height:22px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;background:{{ $tdColor }};color:#fff;font-size:11px;font-weight:700;vertical-align:middle">{{ $tdInitial }}</span>
                    @endif
                    {{ auth()->user()->username }} <i class="fa fa-caret-down"></i>
                </a>
                <div class="user-dropdown-menu td-dropdown-wide" id="userDropdownMenu">
                    <div class="td-drop-left">
                        <div class="td-drop-profile">
                            @if($tdUser->photo)
                            <div class="td-avatar-lg" style="width:56px;height:56px;border-radius:50%;overflow:hidden;background:#f0f0f0;padding:0;flex-shrink:0">
                                <img src="{{ asset('storage/' . $tdUser->photo) }}" alt="" style="width:100%;height:100%;object-fit:cover">
                            </div>
                            @else
                            <div class="td-avatar-lg" style="width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:{{ $tdColor }};color:#fff;font-size:22px;font-weight:700;flex-shrink:0">{{ $tdInitial }}</div>
                            @endif
                            <div class="td-drop-username">{{ $tdUser->name ?? $tdUser->username }}</div>
                            @if($tdRoleLabel)
                            <span class="td-role-badge">{{ $tdRoleLabel }}</span>
                            @endif
                        </div>
                        @if($tdUser?->role === 'pembeli')
                        <div class="td-drop-stat">
                            <i class="fa fa-shopping-bag" style="color:#D10024"></i>
                            <span>{{ $tdOrderCount }} Pesanan</span>
                        </div>
                        @endif
                        @if($tdUser?->role === 'penjual')
                        <div class="td-drop-stat">
                            <i class="fa fa-cube" style="color:#3498db"></i>
                            <a href="{{ route('products.my-products') }}" style="color:#333;text-decoration:none">Produk Saya</a>
                        </div>
                        <div class="td-drop-stat">
                            <i class="fa fa-shopping-bag" style="color:#D10024"></i>
                            <a href="{{ route('seller.orders') }}" style="color:#333;text-decoration:none">Pesanan Masuk</a>
                        </div>
                        @endif
                        <div class="td-drop-stat" style="margin-top:8px;border-top:1px solid #f0f0f0;padding-top:10px">
                            <i class="fa fa-map-marker" style="color:#888"></i>
                            <span style="color:#888;font-size:12px">{{ $tdUser?->kota ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="td-drop-right">
                        @if($tdUser?->role === 'pembeli')
                        <a href="{{ route('orders.index') }}" class="td-drop-link"><i class="fa fa-shopping-bag"></i> Pembelian</a>
                        <a href="{{ route('wishlist.index') }}" class="td-drop-link"><i class="fa fa-heart-o"></i> Wishlist</a>
                        <div class="td-drop-divider"></div>
                        @endif
                        @if($tdUser?->role === 'penjual')
                        <a href="{{ route('seller.orders') }}" class="td-drop-link"><i class="fa fa-shopping-bag"></i> Pesanan</a>
                        <a href="{{ route('products.my-products') }}" class="td-drop-link"><i class="fa fa-cube"></i> Produk Saya</a>
                        <div class="td-drop-divider"></div>
                        @endif
                        <a href="{{ route('profile') }}" class="td-drop-link"><i class="fa fa-cog"></i> Pengaturan</a>
                        <div class="td-drop-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0">
                            @csrf
                            <button type="submit" class="td-drop-logout"><i class="fa fa-sign-out"></i> Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" style="color: #fff; text-decoration: none;"><i class="fa fa-sign-in"></i> Masuk</a>
            @endauth
        </div>
    </div>
</div>
