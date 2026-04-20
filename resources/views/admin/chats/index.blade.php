@extends('layouts.admin')

@section('title', 'Live Chat - Admin NusaMart')

@section('content')
<style>
/* ── HERO ── */
.lci-hero {
    background: linear-gradient(135deg, #0f0519 0%, #1a0a2e 40%, #D10024 100%);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    position: relative;
    overflow: hidden;
}
.lci-hero::before {
    content: '';
    position: absolute; top: -70px; right: -50px;
    width: 280px; height: 280px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.lci-hero::after {
    content: '';
    position: absolute; bottom: -50px; left: 30%;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(255,255,255,.03); pointer-events: none;
}
.lci-hero-icon {
    width: 58px; height: 58px; border-radius: 18px;
    background: rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; color: #fff; flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(0,0,0,.2);
    backdrop-filter: blur(6px);
}
.lci-hero-text h1 {
    margin: 0 0 4px; font-size: 22px; font-weight: 800; color: #fff;
}
.lci-hero-text p { margin: 0; font-size: 13px; color: rgba(255,255,255,.6); }
.lci-hero-stats { display: flex; gap: 10px; flex-shrink: 0; }
.lci-hs {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 14px; padding: 14px 18px;
    text-align: center; min-width: 80px;
    backdrop-filter: blur(4px);
    transition: background .2s;
}
.lci-hs:hover { background: rgba(255,255,255,.17); }
.lci-hs-num { font-size: 24px; font-weight: 800; color: #fff; line-height: 1; }
.lci-hs-lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: rgba(255,255,255,.5); margin-top: 4px; }

/* ── FILTER BAR ── */
.lci-filter {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    padding: 13px 18px;
    margin-bottom: 20px;
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
}
.lci-filter-lbl { font-size: 12px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .5px; margin-right: 4px; }
.lci-tab {
    padding: 7px 18px; border: 1.5px solid #e5e7eb;
    border-radius: 99px; background: #fff;
    font-size: 12px; font-weight: 700; color: #6b7280;
    cursor: pointer; text-decoration: none;
    transition: all .18s; white-space: nowrap;
    display: inline-flex; align-items: center; gap: 5px;
}
.lci-tab:hover { border-color: #D10024; color: #D10024; }
.lci-tab.active { background: #D10024; border-color: #D10024; color: #fff; }
.lci-refresh {
    margin-left: auto;
    padding: 7px 14px; border: 1.5px solid #e5e7eb;
    border-radius: 8px; background: #fff;
    font-size: 12px; font-weight: 700; color: #9ca3af;
    cursor: pointer; text-decoration: none;
    display: inline-flex; align-items: center; gap: 5px;
    transition: all .18s; font-family: inherit;
}
.lci-refresh:hover { border-color: #D10024; color: #D10024; }

/* ── LIST CARD ── */
.lci-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 14px rgba(0,0,0,.07);
    overflow: hidden;
}
.lci-card-header {
    padding: 16px 22px;
    border-bottom: 1px solid #f3f4f6;
    display: flex; align-items: center; justify-content: space-between;
}
.lci-card-title { font-size: 14px; font-weight: 800; color: #1e1f29; }
.lci-card-count { font-size: 12px; color: #9ca3af; }

/* ── ROW ── */
.lci-list { display: flex; flex-direction: column; }
.lci-row {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 22px;
    border-bottom: 1px solid #f7f8fa;
    text-decoration: none; color: inherit;
    transition: background .12s;
    position: relative;
}
.lci-row::before {
    content: '';
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 3px; background: transparent;
    transition: background .18s;
    border-radius: 0 3px 3px 0;
}
.lci-row:hover { background: #fef7f7; }
.lci-row:hover::before { background: #D10024; }
.lci-row:last-child { border-bottom: none; }
.lci-row.has-unread { background: #fffbfb; }
.lci-row.has-unread::before { background: #D10024; }

/* Avatar */
.lci-av {
    width: 46px; height: 46px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; font-weight: 800; color: #fff;
    text-transform: uppercase;
    position: relative;
}
.lci-av-online {
    position: absolute; bottom: 1px; right: 1px;
    width: 11px; height: 11px; border-radius: 50%;
    background: #22c55e; border: 2px solid #fff;
}

/* Info */
.lci-info { flex: 1; min-width: 0; }
.lci-name {
    font-size: 14px; font-weight: 700; color: #1e1f29;
    display: flex; align-items: center; gap: 7px;
    margin-bottom: 3px;
}
.lci-preview {
    font-size: 12px; color: #9ca3af;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 400px;
}
.lci-preview.bold { color: #374151; font-weight: 700; }

/* Status pills */
.lci-pill {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 9px; border-radius: 99px;
    font-size: 10.5px; font-weight: 800;
}
.lci-pill.open   { background: #dcfce7; color: #15803d; }
.lci-pill.closed { background: #f3f4f6; color: #9ca3af; }

/* Right */
.lci-right { display: flex; flex-direction: column; align-items: flex-end; gap: 5px; flex-shrink: 0; }
.lci-time { font-size: 11px; color: #c4c4c4; }
.lci-unread-badge {
    background: linear-gradient(135deg, #D10024, #ff4d4d);
    color: #fff; padding: 2px 8px; border-radius: 99px;
    font-size: 11px; font-weight: 800;
    box-shadow: 0 2px 8px rgba(209,0,36,.3);
    animation: lciBadgePop .3s ease;
}
@keyframes lciBadgePop {
    0%   { transform: scale(.5); opacity: 0; }
    70%  { transform: scale(1.15); }
    100% { transform: scale(1); opacity: 1; }
}

/* Empty */
.lci-empty {
    text-align: center; padding: 72px 24px;
    display: flex; flex-direction: column; align-items: center; gap: 12px;
}
.lci-empty-icon {
    width: 88px; height: 88px; border-radius: 50%;
    background: linear-gradient(135deg, #fff0f0, #ffe4e6);
    display: flex; align-items: center; justify-content: center;
    font-size: 36px; color: #D10024;
}
.lci-empty h3 { margin: 0; font-size: 17px; font-weight: 800; color: #1e1f29; }
.lci-empty p  { margin: 0; font-size: 13px; color: #9ca3af; }

/* Pagination */
.lci-paging { padding: 16px 22px; border-top: 1px solid #f3f4f6; display: flex; justify-content: flex-end; }

@media(max-width:640px) {
    .lci-hero { flex-direction: column; align-items: flex-start; }
    .lci-hero-stats { flex-wrap: wrap; }
    .lci-filter { flex-wrap: wrap; }
    .lci-preview { max-width: 200px; }
}
</style>

@php
    $totalOpen   = \App\Models\Chat::where('status','open')->count();
    $totalClosed = \App\Models\Chat::where('status','closed')->count();
    $avatarColors = ['#D10024','#7c3aed','#0369a1','#059669','#d97706','#db2777','#0891b2','#65a30d'];
@endphp

<div style="max-width:960px;margin:0 auto;">

{{-- HERO --}}
<div class="lci-hero">
    <div style="display:flex;align-items:center;gap:18px;flex:1;min-width:0;">
        <div class="lci-hero-icon"><i class="fa fa-comments"></i></div>
        <div class="lci-hero-text">
            <h1>Live Chat Support</h1>
            <p>Kelola semua percakapan pengguna secara real-time</p>
        </div>
    </div>
    <div class="lci-hero-stats">
        <div class="lci-hs">
            <div class="lci-hs-num" style="color:#ff6b6b;">{{ $totalUnread }}</div>
            <div class="lci-hs-lbl">Belum Dibaca</div>
        </div>
        <div class="lci-hs">
            <div class="lci-hs-num" style="color:#4ade80;">{{ $totalOpen }}</div>
            <div class="lci-hs-lbl">Aktif</div>
        </div>
        <div class="lci-hs">
            <div class="lci-hs-num" style="color:#9ca3af;">{{ $totalClosed }}</div>
            <div class="lci-hs-lbl">Selesai</div>
        </div>
    </div>
</div>

{{-- FILTER BAR --}}
<div class="lci-filter">
    <span class="lci-filter-lbl"><i class="fa fa-filter"></i> Filter</span>
    <a href="{{ route('admin.chats') }}" class="lci-tab {{ !request('status') ? 'active' : '' }}">
        Semua <span style="opacity:.6;">({{ $totalOpen + $totalClosed }})</span>
    </a>
    <a href="{{ route('admin.chats', ['status'=>'open']) }}" class="lci-tab {{ request('status')==='open' ? 'active' : '' }}">
        <span style="width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block;"></span> Open
    </a>
    <a href="{{ route('admin.chats', ['status'=>'closed']) }}" class="lci-tab {{ request('status')==='closed' ? 'active' : '' }}">
        <i class="fa fa-check" style="font-size:9px;"></i> Selesai
    </a>
    <a href="{{ route('admin.chats') }}" class="lci-refresh"><i class="fa fa-refresh"></i> Refresh</a>
</div>

{{-- CHAT LIST CARD --}}
<div class="lci-card">
    <div class="lci-card-header">
        <span class="lci-card-title">
            @if(request('status') === 'open')   Chat Aktif
            @elseif(request('status') === 'closed') Chat Selesai
            @else Semua Chat
            @endif
        </span>
        <span class="lci-card-count">{{ $chats->total() }} percakapan</span>
    </div>

    @if($chats->isEmpty())
        <div class="lci-empty">
            <div class="lci-empty-icon"><i class="fa fa-comment-o"></i></div>
            <h3>Tidak ada chat</h3>
            <p>{{ request('status') ? 'Tidak ada chat dengan filter ini.' : 'Belum ada pengguna yang memulai chat.' }}</p>
        </div>
    @else
        <div class="lci-list">
            @foreach($chats as $idx => $chat)
            @php
                $unread  = $chat->unreadByAdmin();
                $lastMsg = $chat->latestMessage;
                $color   = $avatarColors[($chat->user_id ?? $idx) % count($avatarColors)];
            @endphp
            <a href="{{ route('admin.chats.show', $chat) }}" class="lci-row {{ $unread ? 'has-unread' : '' }}">
                <div class="lci-av" style="background:{{ $color }};">
                    {{ strtoupper(substr($chat->user->name ?? '?', 0, 1)) }}
                    @if($chat->status === 'open')
                        <div class="lci-av-online"></div>
                    @endif
                </div>

                <div class="lci-info">
                    <div class="lci-name">
                        {{ $chat->user->name ?? '(Akun Dihapus)' }}
                        <span class="lci-pill {{ $chat->status }}">
                            @if($chat->status === 'open')
                                <span style="width:5px;height:5px;border-radius:50%;background:#15803d;display:inline-block;"></span> Open
                            @else
                                <i class="fa fa-check" style="font-size:8px;"></i> Selesai
                            @endif
                        </span>
                    </div>
                    <div class="lci-preview {{ $unread ? 'bold' : '' }}">
                        @if($lastMsg)
                            @if($lastMsg->sender_type === 'admin')<span style="color:#D10024;font-weight:700;">Anda:</span> @endif{{ Str::limit($lastMsg->body, 65) }}
                        @else
                            <em>Belum ada pesan</em>
                        @endif
                    </div>
                </div>

                <div class="lci-right">
                    <span class="lci-time">
                        {{ ($lastMsg ? $lastMsg->created_at : $chat->created_at)->diffForHumans() }}
                    </span>
                    @if($unread)
                        <span class="lci-unread-badge">{{ $unread > 99 ? '99+' : $unread }}</span>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @if($chats->hasPages())
            <div class="lci-paging">{{ $chats->links() }}</div>
        @endif
    @endif
</div>

</div>
@endsection
