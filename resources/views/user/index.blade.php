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
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="overlay-btn" style="color:#D10024;" title="Hapus"><i class="fa fa-trash"></i></button>
                                </form>
                            @else
                                <span style="color:#ccc;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
