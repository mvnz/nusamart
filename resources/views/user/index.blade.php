@extends('layouts.app')

@section('title', 'Manajemen Pengguna - NusaMart')

@section('content')
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
<div class="user-modal-overlay" id="userModal" onclick="if(event.target===this)closeUserModal()">
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

        document.getElementById('userModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeUserModal() {
        document.getElementById('userModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeUserModal();
    });
</script>
@endsection
