{{-- ============ ADMIN DASHBOARD ============ --}}

<!-- Admin Stats -->
<section class="container">
    <div class="seller-stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Total Pengguna</div>
            <div class="stat-change" style="color:#8d8d8d;">Semua role</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa fa-shopping-bag"></i></div>
            <div class="stat-value">{{ $totalBuyers }}</div>
            <div class="stat-label">Pembeli</div>
            <div class="stat-change" style="color:#8d8d8d;">Terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa fa-building-o"></i></div>
            <div class="stat-value">{{ $totalSellers }}</div>
            <div class="stat-label">Penjual</div>
            <div class="stat-change" style="color:#8d8d8d;">Terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa fa-shield"></i></div>
            <div class="stat-value">{{ $totalAdmins }}</div>
            <div class="stat-label">Admin</div>
            <div class="stat-change" style="color:#8d8d8d;">Aktif</div>
        </div>
    </div>
</section>

<!-- Role Breakdown -->
<section class="container" style="padding-bottom: 24px;">
    <div class="orders-card">
        <div class="card-header">
            <h3><i class="fa fa-pie-chart"></i> Distribusi Pengguna</h3>
        </div>
        <div style="padding: 20px;">
            <div class="role-bar">
                @php $total = $totalUsers ?: 1; @endphp
                <div class="role-bar-segment bar-admin" style="width: {{ ($totalAdmins / $total) * 100 }}%"></div>
                <div class="role-bar-segment bar-seller" style="width: {{ ($totalSellers / $total) * 100 }}%"></div>
                <div class="role-bar-segment bar-buyer" style="width: {{ ($totalBuyers / $total) * 100 }}%"></div>
            </div>
            <div class="role-legend">
                <span><i class="fa fa-circle" style="color: #D10024;"></i> Admin ({{ $totalAdmins }})</span>
                <span><i class="fa fa-circle" style="color: #2196f3;"></i> Penjual ({{ $totalSellers }})</span>
                <span><i class="fa fa-circle" style="color: #27ae60;"></i> Pembeli ({{ $totalBuyers }})</span>
            </div>
        </div>
    </div>
</section>

<!-- Recent Users + System Info -->
<section class="orders-section">
    <div class="container">
        <div class="two-col-grid">
            <div class="orders-card">
                <div class="card-header">
                    <h3><i class="fa fa-user-plus"></i> Pengguna Terbaru</h3>
                    <a href="{{ route('admin.users') }}" class="view-all">Lihat Semua <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                <div class="table-responsive" style="overflow-x:auto;-webkit-overflow-scrolling:touch">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                <div style="font-size:11px; color:#8d8d8d;">{{ '@' . $user->username }}</div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td><span class="status-badge {{ $user->role === 'admin' ? 'status-cancel' : ($user->role === 'penjual' ? 'status-process' : 'status-success') }}">{{ ucfirst($user->role) }}</span></td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="activity-card">
                <div class="card-header">
                    <h3><i class="fa fa-info-circle"></i> Informasi Sistem</h3>
                </div>
                <ul class="activity-list">
                    <li>
                        <span class="activity-dot dot-red"></span>
                        <div class="activity-text">
                            <strong>Laravel</strong>
                            <span class="time">{{ app()->version() }}</span>
                        </div>
                    </li>
                    <li>
                        <span class="activity-dot dot-blue"></span>
                        <div class="activity-text">
                            <strong>PHP</strong>
                            <span class="time">{{ phpversion() }}</span>
                        </div>
                    </li>
                    <li>
                        <span class="activity-dot dot-green"></span>
                        <div class="activity-text">
                            <strong>Database</strong>
                            <span class="time">MySQL</span>
                        </div>
                    </li>
                    <li>
                        <span class="activity-dot dot-orange"></span>
                        <div class="activity-text">
                            <strong>Timezone</strong>
                            <span class="time">{{ config('app.timezone') }}</span>
                        </div>
                    </li>
                    <li>
                        <span class="activity-dot dot-blue"></span>
                        <div class="activity-text">
                            <strong>URL</strong>
                            <span class="time">{{ config('app.url') }}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
