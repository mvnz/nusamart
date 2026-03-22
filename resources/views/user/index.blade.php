@extends('layouts.app')

@section('title', 'Manajemen Pengguna - NusaMart')

@section('content')
<style>
.btn-toggle-user{border:none;cursor:pointer;font-size:11px;font-weight:600;padding:5px 12px;border-radius:20px;transition:all .2s;text-transform:uppercase;letter-spacing:.5px}
.btn-deactivate{background:#fce4ec;color:#D10024}
.btn-deactivate:hover{background:#D10024;color:#fff}
.btn-activate{background:#e8f5e9;color:#27ae60}
.btn-activate:hover{background:#27ae60;color:#fff}
.btn-detail{background:#e3f2fd;color:#2196f3}
.btn-detail:hover{background:#2196f3;color:#fff}
.user-modal-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:9999;justify-content:center;align-items:center}
.user-modal-overlay.active{display:flex}
.user-modal{background:#fff;border-radius:12px;width:420px;max-width:90vw;max-height:85vh;overflow-y:auto;position:relative;box-shadow:0 20px 60px rgba(0,0,0,.3);animation:modalSlideIn .25s ease}
@keyframes modalSlideIn{from{opacity:0;transform:translateY(-20px)}to{opacity:1;transform:translateY(0)}}
.user-modal-close{position:absolute;top:12px;right:16px;background:none;border:none;font-size:24px;color:#999;cursor:pointer;z-index:1;line-height:1}
.user-modal-close:hover{color:#D10024}
.user-modal-body{padding:30px 24px 24px;text-align:center}
.user-modal-photo{margin-bottom:12px}
.user-modal-photo img{width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #f0f0f0}
.user-modal-avatar{width:90px;height:90px;border-radius:50%;background:#f5f5f5;display:inline-flex;align-items:center;justify-content:center;font-size:36px;color:#ccc;border:3px solid #f0f0f0}
.user-modal-name{font-size:18px;font-weight:700;color:#1e1f29;margin:0}
.user-modal-username{font-size:13px;color:#8d8d8d;margin-bottom:6px}
.user-modal-info{text-align:left;margin-top:16px;border-top:1px solid #f0f0f0;padding-top:16px}
.user-modal-row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f8f8f8;font-size:13px}
.user-modal-label{color:#8d8d8d;font-weight:500}
.user-modal-label i{width:18px;text-align:center;margin-right:6px;color:#D10024}
.user-modal-value{color:#1e1f29;font-weight:500;text-align:right;max-width:55%;word-break:break-word}
</style>
<!-- Stats -->
<section class="container">
    <div class="seller-stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
            <div class="stat-value">{{ $users->count() }}</div>
            <div class="stat-label">Total Pengguna</div>
            <div class="stat-change" style="color:#8d8d8d;">Semua role</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa fa-shopping-bag"></i></div>
            <div class="stat-value">{{ $users->where('role', 'pembeli')->count() }}</div>
            <div class="stat-label">Pembeli</div>
            <div class="stat-change" style="color:#8d8d8d;">Terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa fa-building-o"></i></div>
            <div class="stat-value">{{ $users->where('role', 'penjual')->count() }}</div>
            <div class="stat-label">Penjual</div>
            <div class="stat-change" style="color:#8d8d8d;">Terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa fa-shield"></i></div>
            <div class="stat-value">{{ $users->where('role', 'admin')->count() }}</div>
            <div class="stat-label">Admin</div>
            <div class="stat-change" style="color:#8d8d8d;">Aktif</div>
        </div>
    </div>
</section>

<!-- Users Table -->
<section class="orders-section">
    <div class="container">
        <div class="orders-card">
            <div class="card-header">
                <h3><i class="fa fa-users"></i> Daftar Pengguna</h3>
                <a href="{{ route('dashboard') }}" class="view-all"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>

            @if(session('success'))
                <div style="padding: 12px 20px;">
                    <div class="alert alert-success" style="margin-bottom:0;">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div style="padding: 12px 20px;">
                    <div class="alert alert-danger" style="margin-bottom:0;">
                        <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                </div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            <div style="font-size:11px; color:#8d8d8d;">{{ '@' . $user->username }}</div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            <span class="status-badge {{ $user->role === 'admin' ? 'status-cancel' : ($user->role === 'penjual' ? 'status-process' : 'status-success') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="status-badge status-success">Aktif</span>
                            @else
                                <span class="status-badge status-cancel">Nonaktif</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                <button type="button" class="btn-toggle-user btn-detail" title="Detail" onclick="openUserModal({{ $user->id }})">
                                    Detail
                                </button>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" onsubmit="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} pengguna {{ $user->name }}?')">
                                        @csrf
                                        @method('PATCH')
                                        @if($user->is_active)
                                            <button type="submit" class="btn-toggle-user btn-deactivate" title="Nonaktifkan">
                                                Nonaktifkan
                                            </button>
                                        @else
                                            <button type="submit" class="btn-toggle-user btn-activate" title="Aktifkan">
                                                Aktifkan
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- User Detail Modal -->
<div class="user-modal-overlay" id="userModal" style="display:none" onclick="if(event.target===this)closeUserModal()">
    <div class="user-modal">
        <button class="user-modal-close" onclick="closeUserModal()">&times;</button>
        <div class="user-modal-body">
            <div class="user-modal-photo" id="modalPhoto"></div>
            <h3 class="user-modal-name" id="modalName"></h3>
            <div class="user-modal-username" id="modalUsername"></div>
            <div id="modalStatus" style="margin: 8px 0;"></div>
            <div class="user-modal-info">
                <div class="user-modal-row">
                    <span class="user-modal-label"><i class="fa fa-envelope"></i> Email</span>
                    <span class="user-modal-value" id="modalEmail"></span>
                </div>
                <div class="user-modal-row">
                    <span class="user-modal-label"><i class="fa fa-phone"></i> Telepon</span>
                    <span class="user-modal-value" id="modalPhone"></span>
                </div>
                <div class="user-modal-row">
                    <span class="user-modal-label"><i class="fa fa-tag"></i> Role</span>
                    <span class="user-modal-value" id="modalRole"></span>
                </div>
                <div class="user-modal-row">
                    <span class="user-modal-label"><i class="fa fa-map-marker"></i> Alamat</span>
                    <span class="user-modal-value" id="modalAlamat"></span>
                </div>
                <div class="user-modal-row">
                    <span class="user-modal-label"><i class="fa fa-building"></i> Kota</span>
                    <span class="user-modal-value" id="modalKota"></span>
                </div>
                <div class="user-modal-row">
                    <span class="user-modal-label"><i class="fa fa-globe"></i> Propinsi</span>
                    <span class="user-modal-value" id="modalPropinsi"></span>
                </div>
                <div class="user-modal-row">
                    <span class="user-modal-label"><i class="fa fa-calendar"></i> Terdaftar</span>
                    <span class="user-modal-value" id="modalDate"></span>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $usersJson = $users->mapWithKeys(function($u) {
        return [$u->id => [
            'id' => $u->id,
            'name' => $u->name,
            'username' => $u->username,
            'email' => $u->email,
            'phone' => $u->phone ?? '-',
            'role' => ucfirst($u->role),
            'is_active' => $u->is_active,
            'alamat' => $u->alamat ?? '-',
            'kota' => $u->kota ?? '-',
            'propinsi' => $u->propinsi ?? '-',
            'photo' => $u->photo ? asset('storage/' . $u->photo) : null,
            'date' => $u->created_at->format('d M Y'),
        ]];
    });
@endphp
<script>
    var usersData = {!! $usersJson->toJson() !!};

    function openUserModal(id) {
        var u = usersData[id];
        if (!u) return;

        if (u.photo) {
            document.getElementById('modalPhoto').innerHTML = '<img src="' + u.photo + '" alt="Foto">';
        } else {
            document.getElementById('modalPhoto').innerHTML = '<div class="user-modal-avatar"><i class="fa fa-user"></i></div>';
        }
        document.getElementById('modalName').textContent = u.name;
        document.getElementById('modalUsername').textContent = '@' + u.username;
        document.getElementById('modalEmail').textContent = u.email;
        document.getElementById('modalPhone').textContent = u.phone;
        document.getElementById('modalRole').innerHTML = '<span class="status-badge ' + (u.role === 'Admin' ? 'status-cancel' : (u.role === 'Penjual' ? 'status-process' : 'status-success')) + '">' + u.role + '</span>';
        document.getElementById('modalStatus').innerHTML = u.is_active ? '<span class="status-badge status-success">Aktif</span>' : '<span class="status-badge status-cancel">Nonaktif</span>';
        document.getElementById('modalAlamat').textContent = u.alamat;
        document.getElementById('modalKota').textContent = u.kota;
        document.getElementById('modalPropinsi').textContent = u.propinsi;
        document.getElementById('modalDate').textContent = u.date;

        var modal = document.getElementById('userModal');
        modal.style.display = 'flex';
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeUserModal() {
        var modal = document.getElementById('userModal');
        modal.classList.remove('active');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeUserModal();
    });
</script>
@endsection
