{{-- ============ ADMIN DASHBOARD ============ --}}
<style>
.admin-stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px 20px;
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    border: 1px solid #f0f0f0;
    transition: transform .2s, box-shadow .2s;
    flex: 1;
    min-width: 0;
}
.admin-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.10); }
.admin-stat-icon {
    width: 56px; height: 56px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff; flex-shrink: 0;
}
.admin-stat-icon.bg-red    { background: linear-gradient(135deg,#D10024,#ff6b6b); }
.admin-stat-icon.bg-blue   { background: linear-gradient(135deg,#2196f3,#64b5f6); }
.admin-stat-icon.bg-green  { background: linear-gradient(135deg,#27ae60,#66bb6a); }
.admin-stat-icon.bg-purple { background: linear-gradient(135deg,#9b59b6,#ce93d8); }
.admin-stat-info { flex: 1; min-width: 0; }
.admin-stat-value { font-size: 28px; font-weight: 800; color: #1e1f29; line-height: 1; }
.admin-stat-label { font-size: 13px; font-weight: 600; color: #555; margin-top: 4px; }
.admin-stat-sub { font-size: 11px; color: #aaa; margin-top: 2px; }

.admin-donut-wrap { display: flex; align-items: center; gap: 32px; padding: 20px 24px; flex-wrap: wrap; }
.admin-donut-svg { flex-shrink: 0; }
.admin-donut-legend { display: flex; flex-direction: column; gap: 12px; }
.admin-donut-item { display: flex; align-items: center; gap: 10px; font-size: 13px; }
.admin-donut-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
.admin-donut-name { color: #555; font-weight: 500; }
.admin-donut-count { font-weight: 700; color: #1e1f29; margin-left: auto; min-width: 30px; text-align: right; }

.admin-user-row { display: flex; align-items: center; gap: 12px; padding: 12px 20px; border-bottom: 1px solid #f5f5f5; transition: background .15s; }
.admin-user-row:last-child { border-bottom: none; }
.admin-user-row:hover { background: #fafafa; }
.admin-user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; flex-shrink: 0; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: #fff; }
.admin-user-info { flex: 1; min-width: 0; }
.admin-user-name { font-size: 13px; font-weight: 700; color: #1e1f29; }
.admin-user-uname { font-size: 11px; color: #aaa; }
.admin-user-email { font-size: 12px; color: #888; margin-top: 1px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 180px; }
.admin-user-meta { text-align: right; flex-shrink: 0; }
.admin-user-time { font-size: 11px; color: #bbb; margin-top: 4px; }

.admin-stat-bar-item { margin-bottom: 16px; }
.admin-stat-bar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
.admin-stat-bar-label { font-size: 13px; font-weight: 600; color: #444; }
.admin-stat-bar-val { font-size: 12px; font-weight: 700; color: #888; }
.admin-stat-bar-track { height: 8px; background: #f0f0f0; border-radius: 8px; overflow: hidden; }
.admin-stat-bar-fill { height: 100%; border-radius: 8px; transition: width .6s ease; }

.admin-welcome-banner {
    background: linear-gradient(135deg, #D10024 0%, #8B0000 100%);
    border-radius: 16px;
    padding: 24px 28px;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    overflow: hidden;
    position: relative;
}
.admin-welcome-banner::after {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
}
.admin-welcome-banner::before {
    content: '';
    position: absolute;
    right: 60px; bottom: -60px;
    width: 160px; height: 160px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
}
.admin-welcome-title { font-size: 20px; font-weight: 800; margin-bottom: 4px; }
.admin-welcome-sub { font-size: 13px; opacity: .85; }
.admin-welcome-icon { font-size: 48px; opacity: .25; position: relative; z-index: 1; }
</style>

<!-- Welcome Banner -->
<section class="container" style="padding-top:24px;padding-bottom:0">
    <div class="admin-welcome-banner">
        <div>
            <div class="admin-welcome-title">Selamat Datang, {{ auth()->user()->name }} 👋</div>
            <div class="admin-welcome-sub">{{ now()->translatedFormat('l, d F Y') }} &mdash; Panel Administrator NusaMart</div>
        </div>
        <i class="fa fa-shield admin-welcome-icon"></i>
    </div>
</section>

<!-- Stat Cards -->
<section class="container" style="padding-bottom:0">
    <div style="display:flex;gap:16px;flex-wrap:wrap">
        <div class="admin-stat-card">
            <div class="admin-stat-icon bg-red"><i class="fa fa-users"></i></div>
            <div class="admin-stat-info">
                <div class="admin-stat-value">{{ $totalUsers }}</div>
                <div class="admin-stat-label">Total Pengguna</div>
                <div class="admin-stat-sub">Semua role</div>
            </div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-icon bg-blue"><i class="fa fa-shopping-bag"></i></div>
            <div class="admin-stat-info">
                <div class="admin-stat-value">{{ $totalBuyers }}</div>
                <div class="admin-stat-label">Pembeli</div>
                <div class="admin-stat-sub">Terdaftar</div>
            </div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-icon bg-purple"><i class="fa fa-building-o"></i></div>
            <div class="admin-stat-info">
                <div class="admin-stat-value">{{ $totalSellers }}</div>
                <div class="admin-stat-label">Penjual</div>
                <div class="admin-stat-sub">Terdaftar</div>
            </div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-icon bg-green"><i class="fa fa-shield"></i></div>
            <div class="admin-stat-info">
                <div class="admin-stat-value">{{ $totalAdmins }}</div>
                <div class="admin-stat-label">Admin</div>
                <div class="admin-stat-sub">Aktif</div>
            </div>
        </div>
    </div>
</section>

<!-- Distribusi + Pengguna Terbaru -->
<section class="orders-section" style="padding-top:24px">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
            <!-- Donut Chart Penjualan -->
            <div class="orders-card">
                <div class="card-header">
                    <h3><i class="fa fa-pie-chart"></i> Distribusi Penjualan</h3>
                </div>
                @php
                    $salesTotal = $totalSales ?: 1;
                    $deliveredPct  = round(($salesDelivered  / $salesTotal) * 100);
                    $processingPct = round(($salesProcessing / $salesTotal) * 100);
                    $shippedPct    = round(($salesShipped    / $salesTotal) * 100);
                    $pendingPct    = round(($salesPending    / $salesTotal) * 100);
                    $cancelledPct  = 100 - $deliveredPct - $processingPct - $shippedPct - $pendingPct;
                    $r = 54; $cx = 70; $cy = 70;
                    $circ = 2 * M_PI * $r;
                    $seg = [
                        ['pct'=>$deliveredPct,  'color'=>'#10b981'],
                        ['pct'=>$processingPct, 'color'=>'#3b82f6'],
                        ['pct'=>$shippedPct,    'color'=>'#8b5cf6'],
                        ['pct'=>$pendingPct,    'color'=>'#f59e0b'],
                        ['pct'=>$cancelledPct,  'color'=>'#ef4444'],
                    ];
                    $offset = 0;
                    // format total
                    if ($totalSales >= 1000000000) {
                        $totalShort = 'Rp '.number_format($totalSales/1000000000,1,',','.').'M';
                    } elseif ($totalSales >= 1000000) {
                        $totalShort = 'Rp '.number_format($totalSales/1000000,1,',','.').'jt';
                    } elseif ($totalSales >= 1000) {
                        $totalShort = 'Rp '.number_format($totalSales/1000,0,',','.').'rb';
                    } else {
                        $totalShort = $totalSales > 0 ? 'Rp '.number_format($totalSales,0,',','.') : '0';
                    }
                @endphp
                <div class="admin-donut-wrap">
                    <svg class="admin-donut-svg" width="140" height="140" viewBox="0 0 140 140">
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#f0f0f0" stroke-width="16"/>
                        @foreach($seg as $s)
                            @if($s['pct'] > 0)
                            @php $dash = ($s['pct']/100)*$circ; @endphp
                            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="{{ $s['color'] }}" stroke-width="16"
                                stroke-dasharray="{{ $dash }} {{ $circ - $dash }}"
                                stroke-dashoffset="{{ -$offset }}" transform="rotate(-90 {{ $cx }} {{ $cy }})"/>
                            @php $offset += $dash; @endphp
                            @endif
                        @endforeach
                        <text x="{{ $cx }}" y="{{ $cy - 8 }}" text-anchor="middle" font-size="11" font-weight="800" fill="#1e1f29">{{ $totalShort }}</text>
                        <text x="{{ $cx }}" y="{{ $cy + 10 }}" text-anchor="middle" font-size="10" fill="#aaa">total</text>
                    </svg>
                    <div class="admin-donut-legend">
                        <div class="admin-donut-item">
                            <div class="admin-donut-dot" style="background:#10b981"></div>
                            <span class="admin-donut-name">Selesai</span>
                            <span class="admin-donut-count" style="font-size:11px">Rp {{ number_format($salesDelivered,0,',','.') }}</span>
                        </div>
                        <div class="admin-donut-item">
                            <div class="admin-donut-dot" style="background:#3b82f6"></div>
                            <span class="admin-donut-name">Diproses</span>
                            <span class="admin-donut-count" style="font-size:11px">Rp {{ number_format($salesProcessing,0,',','.') }}</span>
                        </div>
                        <div class="admin-donut-item">
                            <div class="admin-donut-dot" style="background:#8b5cf6"></div>
                            <span class="admin-donut-name">Dikirim</span>
                            <span class="admin-donut-count" style="font-size:11px">Rp {{ number_format($salesShipped,0,',','.') }}</span>
                        </div>
                        <div class="admin-donut-item">
                            <div class="admin-donut-dot" style="background:#f59e0b"></div>
                            <span class="admin-donut-name">Menunggu</span>
                            <span class="admin-donut-count" style="font-size:11px">Rp {{ number_format($salesPending,0,',','.') }}</span>
                        </div>
                        <div class="admin-donut-item">
                            <div class="admin-donut-dot" style="background:#ef4444"></div>
                            <span class="admin-donut-name">Batal</span>
                            <span class="admin-donut-count" style="font-size:11px">Rp {{ number_format($salesCancelled,0,',','.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengguna Terbaru -->
            <div class="orders-card">
                <div class="card-header">
                    <h3><i class="fa fa-user-plus"></i> Pengguna Terbaru</h3>
                    <a href="{{ route('admin.users') }}" class="view-all">Lihat Semua <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                @foreach($recentUsers as $user)
                @php
                    $colors = ['admin'=>'#D10024','penjual'=>'#2196f3','pembeli'=>'#27ae60'];
                    $initials = strtoupper(substr($user->name, 0, 1));
                    $color = $colors[$user->role] ?? '#999';
                @endphp
                <div class="admin-user-row">
                    <div class="admin-user-avatar" style="background:{{ $color }}">
                        @if($user->photo)
                            <img src="{{ asset('storage/'.$user->photo) }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover">
                        @else
                            {{ $initials }}
                        @endif
                    </div>
                    <div class="admin-user-info">
                        <div class="admin-user-name">{{ $user->name }}</div>
                        <div class="admin-user-uname">{{ '@' . $user->username }}</div>
                        <div class="admin-user-email">{{ $user->email }}</div>
                    </div>
                    <div class="admin-user-meta">
                        <span class="status-badge {{ $user->role === 'admin' ? 'status-cancel' : ($user->role === 'penjual' ? 'status-process' : 'status-success') }}">{{ ucfirst($user->role) }}</span>
                        <div class="admin-user-time">{{ $user->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

