<!-- Top Bar -->
<style>
.user-dropdown{position:relative}
.user-dropdown-toggle{cursor:pointer;display:flex;align-items:center;gap:6px}
.user-dropdown-toggle .fa-caret-down{font-size:10px;transition:transform .2s}
.user-dropdown.open .fa-caret-down{transform:rotate(180deg)}
.user-dropdown-menu{position:absolute;top:calc(100% + 12px);right:0;background:#fff;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,.18);z-index:1000;display:none;overflow:hidden;border:1px solid rgba(0,0,0,.06)}
.user-dropdown.open .user-dropdown-menu{display:block}
.td-dropdown-wide{min-width:360px;display:none;flex-direction:row}
.user-dropdown.open .td-dropdown-wide{display:flex}
.td-drop-left{width:180px;background:#fafafa;border-right:1px solid #f0f0f0;padding:20px 16px;display:flex;flex-direction:column;gap:0}
.td-drop-profile{display:flex;flex-direction:column;align-items:center;margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid #f0f0f0;gap:8px}
.td-drop-username{font-size:14px;font-weight:700;color:#1e1f29;text-align:center;word-break:break-word}
.td-role-badge{background:#fff0f0;color:#D10024;font-size:10px;font-weight:700;padding:2px 10px;border-radius:20px}
.td-drop-stat{display:flex;align-items:center;gap:8px;font-size:13px;color:#444;padding:6px 0}
.td-drop-stat .fa{width:14px;text-align:center}
.td-drop-right{flex:1;padding:12px 0;display:flex;flex-direction:column}
.td-drop-link{display:flex;align-items:center;gap:10px;padding:11px 18px;font-size:13px;color:#333!important;text-decoration:none;transition:background .15s,color .15s}
.td-drop-link .fa{width:16px;text-align:center;color:#888}
.td-drop-link:hover{background:#f6f6f6;color:#D10024!important}
.td-drop-link:hover .fa{color:#D10024}
.td-drop-divider{height:1px;background:#f0f0f0;margin:4px 0}
.td-drop-logout{display:flex;align-items:center;gap:10px;width:100%;padding:11px 18px;font-size:13px;color:#D10024;background:none;border:none;cursor:pointer;font-family:inherit;font-weight:600;transition:background .15s}
.td-drop-logout .fa{width:16px;text-align:center}
.td-drop-logout:hover{background:#fff0f0}
</style>
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
                        <img src="{{ asset('uploads/' . $tdUser->photo) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
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
                                <img src="{{ asset('uploads/' . $tdUser->photo) }}" alt="" style="width:100%;height:100%;object-fit:cover">
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
                        <a href="{{ route('dashboard') }}" class="td-drop-link"><i class="fa fa-tachometer"></i> Dashboard</a>
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
