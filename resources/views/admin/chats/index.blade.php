@extends('layouts.admin')

@section('title', 'Live Chat - Admin NusaMart')

@section('content')
<style>
.lc-wrap { max-width: 1000px; margin: 0 auto; }

/* Page header */
.lc-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; flex-wrap:wrap; gap:12px; }
.lc-title { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.lc-title i { color:#D10024; }

/* Stats bar */
.lc-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:22px; }
@media(max-width:600px){ .lc-stats { grid-template-columns:1fr; } }
.lc-stat { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:18px 20px; display:flex; align-items:center; gap:14px; }
.lc-si { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.lc-si.red  { background:linear-gradient(135deg,#fee2e2,#fecaca); color:#D10024; }
.lc-si.green{ background:linear-gradient(135deg,#c8f7d6,#edfff3); color:#059669; }
.lc-si.grey { background:linear-gradient(135deg,#e5e7eb,#f3f4f6); color:#6b7280; }
.lc-sv { font-size:24px; font-weight:800; color:#1e1f29; line-height:1; }
.lc-sl { font-size:12px; color:#888; margin-top:2px; }

/* Card + Table */
.lc-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }
.lc-toolbar { display:flex; align-items:center; gap:10px; padding:16px 20px; border-bottom:1px solid #f0f0f0; flex-wrap:wrap; }
.lc-filter-btn { padding:7px 16px; border:1.5px solid #e5e7eb; border-radius:20px; background:#fff; font-size:12px; font-weight:700; color:#666; cursor:pointer; font-family:inherit; transition:all .18s; display:inline-flex; align-items:center; gap:5px; white-space:nowrap; }
.lc-filter-btn:hover { border-color:#D10024; color:#D10024; }
.lc-filter-btn.active { background:#D10024; border-color:#D10024; color:#fff; }

/* Chat list */
.lc-list { display:flex; flex-direction:column; }
.lc-row {
    display:flex; align-items:center; gap:14px;
    padding:14px 20px;
    border-bottom:1px solid #f7f7f9;
    text-decoration:none; color:inherit;
    transition:background .14s;
}
.lc-row:hover { background:#fafbfc; }
.lc-row:last-child { border-bottom:none; }

.lc-avatar {
    width:44px; height:44px; border-radius:50%; flex-shrink:0;
    background: linear-gradient(135deg,#D10024,#ff6b35);
    display:flex; align-items:center; justify-content:center;
    font-size:17px; font-weight:800; color:#fff;
    text-transform:uppercase;
}
.lc-info { flex:1; min-width:0; }
.lc-user-name { font-size:13.5px; font-weight:700; color:#1e1f29; display:flex; align-items:center; gap:7px; }
.lc-last-msg { font-size:12px; color:#999; margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:380px; }
.lc-last-msg.unread { color:#555; font-weight:600; }

.lc-right { display:flex; flex-direction:column; align-items:flex-end; gap:5px; flex-shrink:0; }
.lc-time { font-size:11px; color:#bbb; white-space:nowrap; }
.lc-badge { padding:3px 9px; border-radius:12px; font-size:11px; font-weight:800; white-space:nowrap; }
.lc-badge.unread { background:linear-gradient(135deg,#D10024,#ff4d4d); color:#fff; }
.lc-badge.open   { background:#d1fae5; color:#065f46; }
.lc-badge.closed { background:#f3f4f6; color:#9ca3af; }

/* Empty */
.lc-empty { text-align:center; padding:60px 20px; }
.lc-empty i { font-size:48px; color:#e0e0e0; display:block; margin-bottom:14px; }
.lc-empty p { font-size:14px; color:#999; }

/* Pagination */
.lc-paging { padding:14px 20px; border-top:1px solid #f0f0f0; display:flex; justify-content:flex-end; }
</style>

<div class="lc-wrap">
    <div class="lc-header">
        <h1 class="lc-title"><i class="fa fa-comments"></i> Live Chat Support</h1>
    </div>

    {{-- Stats --}}
    @php
        $totalOpen   = \App\Models\Chat::where('status','open')->count();
        $totalClosed = \App\Models\Chat::where('status','closed')->count();
    @endphp
    <div class="lc-stats">
        <div class="lc-stat">
            <div class="lc-si red"><i class="fa fa-comments"></i></div>
            <div>
                <div class="lc-sv">{{ $totalUnread }}</div>
                <div class="lc-sl">Pesan Belum Dibaca</div>
            </div>
        </div>
        <div class="lc-stat">
            <div class="lc-si green"><i class="fa fa-comment"></i></div>
            <div>
                <div class="lc-sv">{{ $totalOpen }}</div>
                <div class="lc-sl">Chat Aktif</div>
            </div>
        </div>
        <div class="lc-stat">
            <div class="lc-si grey"><i class="fa fa-check-circle"></i></div>
            <div>
                <div class="lc-sv">{{ $totalClosed }}</div>
                <div class="lc-sl">Chat Selesai</div>
            </div>
        </div>
    </div>

    {{-- List --}}
    <div class="lc-card">
        <div class="lc-toolbar">
            <a href="{{ route('admin.chats') }}" class="lc-filter-btn {{ !request('status') ? 'active' : '' }}">
                Semua
            </a>
            <a href="{{ route('admin.chats', ['status'=>'open']) }}" class="lc-filter-btn {{ request('status')==='open' ? 'active' : '' }}">
                <i class="fa fa-circle" style="font-size:8px;color:#4ade80;"></i> Open
            </a>
            <a href="{{ route('admin.chats', ['status'=>'closed']) }}" class="lc-filter-btn {{ request('status')==='closed' ? 'active' : '' }}">
                Selesai
            </a>
        </div>

        @if($chats->isEmpty())
            <div class="lc-empty">
                <i class="fa fa-comment-o"></i>
                <p>Belum ada chat masuk.</p>
            </div>
        @else
            <div class="lc-list">
                @foreach($chats as $chat)
                @php
                    $unread  = $chat->unreadByAdmin();
                    $lastMsg = $chat->latestMessage;
                @endphp
                <a href="{{ route('admin.chats.show', $chat) }}" class="lc-row">
                    <div class="lc-avatar">{{ strtoupper(substr($chat->user->name ?? '?', 0, 1)) }}</div>
                    <div class="lc-info">
                        <div class="lc-user-name">
                            {{ $chat->user->name ?? '(Akun Dihapus)' }}
                            <span class="lc-badge {{ $chat->status }}">{{ $chat->status === 'open' ? 'Open' : 'Selesai' }}</span>
                        </div>
                        <div class="lc-last-msg {{ $unread ? 'unread' : '' }}">
                            @if($lastMsg)
                                {{ $lastMsg->sender_type === 'admin' ? 'Anda: ' : '' }}{{ Str::limit($lastMsg->body, 60) }}
                            @else
                                <em>Belum ada pesan</em>
                            @endif
                        </div>
                    </div>
                    <div class="lc-right">
                        <div class="lc-time">{{ $lastMsg ? $lastMsg->created_at->diffForHumans() : $chat->created_at->diffForHumans() }}</div>
                        @if($unread)
                            <div class="lc-badge unread">{{ $unread > 9 ? '9+' : $unread }}</div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
            @if($chats->hasPages())
                <div class="lc-paging">{{ $chats->links() }}</div>
            @endif
        @endif
    </div>
</div>
@endsection
