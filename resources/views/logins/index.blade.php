@extends('layouts.app')

@section('title', 'Riwayat Login Pengguna - NusaMart Admin')

@section('content')
<style>
.ck-wrap         { max-width:1140px; margin:0 auto; padding:28px 16px 48px; }
.ck-page-header  { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.ck-page-title   { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.ck-page-title i { color:#D10024; font-size:20px; }
.ck-back-btn     { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:background .15s; }
.ck-back-btn:hover { background:#e5e7eb; color:#1e1f29; }

.ck-card  { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }
.ck-card-header { display:flex; align-items:center; justify-content:space-between; padding:18px 22px; border-bottom:1px solid #f2f2f5; }
.ck-card-title  { font-size:14px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:8px; margin:0; }
.ck-card-title i { color:#D10024; }

.ck-table { width:100%; border-collapse:collapse; font-size:13px; }
.ck-table th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:11px 20px; text-align:left; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.ck-table td { padding:13px 20px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.ck-table tbody tr:last-child td { border-bottom:none }
.ck-table tbody tr:hover td { background:#fafbfc }

.pagination { justify-content:center; margin:16px 0 4px }
</style>

<div class="ck-wrap">
    <div class="ck-page-header">
        <h1 class="ck-page-title"><i class="fa fa-sign-in"></i> Riwayat Login Pengguna</h1>
        <a href="{{ route('dashboard') }}" class="ck-back-btn"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>

    <div class="ck-card">
        <div class="ck-card-header">
            <h2 class="ck-card-title"><i class="fa fa-users"></i> Semua Pengguna</h2>
            <span style="font-size:12px;color:#aaa">{{ number_format($allLogins->total()) }} pengguna dengan data login</span>
        </div>

        @if($allLogins->isEmpty())
            <div style="text-align:center;padding:48px;color:#bbb;font-size:13px">
                <i class="fa fa-clock-o" style="font-size:32px;margin-bottom:12px;display:block"></i>
                Belum ada data login
            </div>
        @else
        <table class="ck-table">
            <thead>
                <tr>
                    <th style="width:44px">#</th>
                    <th>Pengguna</th>
                    <th style="width:90px">Role</th>
                    <th style="width:160px">Login Terakhir</th>
                    <th style="width:120px">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allLogins as $u)
                @php
                    $colors = ['admin'=>'#D10024','penjual'=>'#2196f3','pembeli'=>'#27ae60'];
                    $uc     = $colors[$u->role] ?? '#999';
                    $rank   = ($allLogins->currentPage() - 1) * $allLogins->perPage() + $loop->iteration;
                @endphp
                <tr>
                    <td style="color:#ccc;font-weight:800;font-size:12px">{{ $rank }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px">
                            <div style="width:38px;height:38px;border-radius:50%;background:{{ $uc }};display:flex;align-items:center;justify-content:center;font-weight:800;color:#fff;font-size:14px;flex-shrink:0;overflow:hidden">
                                @if($u->photo)
                                    <img src="{{ asset('storage/'.$u->photo) }}" style="width:38px;height:38px;object-fit:cover">
                                @else
                                    {{ strtoupper(substr($u->name,0,1)) }}
                                @endif
                            </div>
                            <div>
                                <div style="font-weight:700;color:#1e1f29;font-size:13px">{{ $u->name }}</div>
                                <div style="font-size:11px;color:#aaa">{{ '@'.$u->username }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge {{ $u->role === 'admin' ? 'status-cancel' : ($u->role === 'penjual' ? 'status-process' : 'status-success') }}">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#444;white-space:nowrap">
                        {{ $u->last_login_at->format('d M Y, H:i') }}
                    </td>
                    <td style="font-size:12px;color:#aaa;white-space:nowrap">
                        {{ $u->last_login_at->diffForHumans() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:12px 20px">
            {{ $allLogins->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
