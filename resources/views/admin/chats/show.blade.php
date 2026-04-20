@extends('layouts.admin')

@section('title', 'Chat dengan ' . ($chat->user->name ?? '?') . ' - Admin NusaMart')

@section('content')
<style>
/* ── LAYOUT ── */
.lcs-wrap { max-width: 860px; margin: 0 auto; }

/* ── BACK + USER CARD TOP ── */
.lcs-topbar {
    display: flex; align-items: center; gap: 14px;
    margin-bottom: 20px;
}
.lcs-back {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 16px;
    background: #fff; border: 1.5px solid #e5e7eb; border-radius: 10px;
    font-size: 12px; font-weight: 700; color: #555;
    text-decoration: none; transition: all .18s; flex-shrink: 0;
}
.lcs-back:hover { border-color: #D10024; color: #D10024; }
.lcs-user-pill {
    flex: 1; background: #fff; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
    padding: 10px 18px;
    display: flex; align-items: center; gap: 12px;
    overflow: hidden;
}
.lcs-ua {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 800; color: #fff;
    text-transform: uppercase;
}
.lcs-uname { font-size: 14px; font-weight: 800; color: #1e1f29; }
.lcs-uemail { font-size: 11px; color: #9ca3af; }
.lcs-status-dot {
    width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0;
}
.lcs-status-open   { background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.2); }
.lcs-status-closed { background: #9ca3af; }

/* ── CHAT CARD ── */
.lcs-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0,0,0,.09);
    overflow: hidden;
    display: flex; flex-direction: column;
    height: calc(100vh - 230px); min-height: 500px;
}

/* Header */
.lcs-header {
    background: linear-gradient(135deg, #0f0519 0%, #1a0a2e 45%, #D10024 100%);
    padding: 16px 22px;
    display: flex; align-items: center; gap: 14px;
    position: relative; overflow: hidden; flex-shrink: 0;
}
.lcs-header::before {
    content: ''; position: absolute; top: -50px; right: -30px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.lcs-h-av {
    width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; font-weight: 800; color: #fff;
    text-transform: uppercase;
    border: 2px solid rgba(255,255,255,.3);
    position: relative;
}
.lcs-h-online {
    position: absolute; bottom: 1px; right: 1px;
    width: 12px; height: 12px; border-radius: 50%;
    background: #22c55e; border: 2px solid #fff;
}
.lcs-h-name { font-size: 14.5px; font-weight: 800; color: #fff; }
.lcs-h-meta { font-size: 11px; color: rgba(255,255,255,.6); margin-top: 2px; }
.lcs-h-actions { margin-left: auto; display: flex; gap: 8px; }
.btn-lcs-close {
    padding: 7px 16px; border-radius: 99px; border: none; cursor: pointer;
    font-size: 12px; font-weight: 700; font-family: inherit;
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(255,255,255,.15); color: #fff;
    transition: background .18s;
    backdrop-filter: blur(4px);
}
.btn-lcs-close:hover { background: rgba(255,255,255,.25); }
.btn-lcs-reopen {
    padding: 7px 16px; border-radius: 99px; border: none; cursor: pointer;
    font-size: 12px; font-weight: 700; font-family: inherit;
    display: inline-flex; align-items: center; gap: 5px;
    background: #4ade80; color: #052e16;
    transition: opacity .18s;
}
.btn-lcs-reopen:hover { opacity: .85; }

/* Date separator */
.lcs-date-sep {
    display: flex; align-items: center; gap: 12px;
    margin: 8px 0;
}
.lcs-date-sep span {
    font-size: 11px; font-weight: 700; color: #c4c4c4;
    background: #f0f1f4; padding: 3px 12px; border-radius: 99px;
    white-space: nowrap;
}
.lcs-date-sep::before, .lcs-date-sep::after {
    content: ''; flex: 1; height: 1px; background: #eee;
}

/* Messages */
.lcs-messages {
    flex: 1; overflow-y: auto; padding: 20px 24px;
    background: #f5f6fa;
    display: flex; flex-direction: column; gap: 4px;
    scroll-behavior: smooth;
}
.lcs-messages::-webkit-scrollbar { width: 5px; }
.lcs-messages::-webkit-scrollbar-track { background: transparent; }
.lcs-messages::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 99px; }

/* Message groups */
.lcs-msg-group {
    display: flex; flex-direction: column;
    max-width: 72%; margin-bottom: 14px;
}
.lcs-msg-group.from-user  { align-self: flex-start; align-items: flex-start; }
.lcs-msg-group.from-admin { align-self: flex-end;   align-items: flex-end; }

.lcs-sender-tag {
    font-size: 11px; font-weight: 700; color: #9ca3af;
    margin-bottom: 4px; display: flex; align-items: center; gap: 5px;
}
.from-admin .lcs-sender-tag { display: none; }

.lcs-bubble {
    padding: 11px 15px;
    border-radius: 18px;
    font-size: 13.5px; line-height: 1.55;
    word-break: break-word; position: relative;
    margin-bottom: 2px;
}
.from-user .lcs-bubble {
    background: #fff;
    border: 1px solid #eaeaea;
    border-bottom-left-radius: 5px;
    color: #1e1f29;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.from-admin .lcs-bubble {
    background: linear-gradient(135deg, #D10024, #ff4d6d);
    color: #fff;
    border-bottom-right-radius: 5px;
    box-shadow: 0 3px 12px rgba(209,0,36,.25);
}

.lcs-bubble-meta {
    font-size: 10.5px; color: #c4c4c4; margin-top: 3px;
    display: flex; align-items: center; gap: 5px;
}
.from-admin .lcs-bubble-meta { justify-content: flex-end; color: rgba(255,255,255,.5); }

/* Empty messages */
.lcs-no-msg {
    text-align: center; padding: 50px 20px;
    display: flex; flex-direction: column; align-items: center; gap: 10px;
    color: #c4c4c4;
}
.lcs-no-msg i { font-size: 42px; }
.lcs-no-msg p { margin: 0; font-size: 13px; }

/* Closed banner */
.lcs-closed-banner {
    background: linear-gradient(90deg, #f3f4f6, #f9fafb);
    border-top: 1px solid #e5e7eb;
    padding: 14px 22px;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    font-size: 13px; color: #9ca3af; flex-shrink: 0;
}
.lcs-closed-banner i { color: #D10024; }

/* Reply area */
.lcs-reply {
    border-top: 1px solid #f0f0f0;
    padding: 14px 20px;
    background: #fff;
    display: flex; gap: 10px; align-items: flex-end;
    flex-shrink: 0;
}
#adminReplyInput {
    flex: 1; border: 1.5px solid #e5e7eb; border-radius: 14px;
    padding: 11px 16px; font-size: 13px; font-family: inherit;
    resize: none; outline: none; line-height: 1.5;
    max-height: 120px; min-height: 44px;
    transition: border-color .18s, box-shadow .18s;
    color: #1e1f29; background: #fafafa;
}
#adminReplyInput:focus {
    border-color: #D10024;
    box-shadow: 0 0 0 3px rgba(209,0,36,.1);
    background: #fff;
}
#adminReplyInput::placeholder { color: #c4c4c4; }
#adminSendBtn {
    padding: 11px 22px;
    background: linear-gradient(135deg, #D10024, #ff4d6d);
    border: none; border-radius: 14px; color: #fff;
    font-size: 13px; font-weight: 800; font-family: inherit;
    cursor: pointer; white-space: nowrap;
    display: flex; align-items: center; gap: 7px;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(209,0,36,.3);
}
#adminSendBtn:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(209,0,36,.4); }
#adminSendBtn:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; }

/* Typing indicator */
.lcs-typing {
    display: flex; align-items: center; gap: 4px; padding: 10px 14px;
    background: #fff; border-radius: 18px; border-bottom-left-radius: 5px;
    border: 1px solid #eaeaea; width: fit-content;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.lcs-typing span {
    width: 6px; height: 6px; border-radius: 50%; background: #ccc;
    animation: lcsDot 1.2s infinite ease-in-out;
}
.lcs-typing span:nth-child(2) { animation-delay: .2s; }
.lcs-typing span:nth-child(3) { animation-delay: .4s; }
@keyframes lcsDot {
    0%, 80%, 100% { transform: scale(.7); opacity: .4; }
    40%            { transform: scale(1);  opacity: 1; }
}

@media(max-width:600px) {
    .lcs-topbar { flex-wrap: wrap; }
    .lcs-card { height: calc(100vh - 280px); }
}
</style>

@php
    $userColor = ['#D10024','#7c3aed','#0369a1','#059669','#d97706'][($chat->user_id ?? 0) % 5];
@endphp

<div class="lcs-wrap">

{{-- TOP BAR: back + user pill --}}
<div class="lcs-topbar">
    <a href="{{ route('admin.chats') }}" class="lcs-back">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>
    <div class="lcs-user-pill">
        <div class="lcs-ua" style="background:{{ $userColor }};">
            {{ strtoupper(substr($chat->user->name ?? '?', 0, 1)) }}
        </div>
        <div style="flex:1;min-width:0;">
            <div class="lcs-uname">{{ $chat->user->name ?? '(Akun Dihapus)' }}</div>
            <div class="lcs-uemail">{{ $chat->user->email ?? '' }}</div>
        </div>
        <div class="lcs-status-dot {{ $chat->status === 'open' ? 'lcs-status-open' : 'lcs-status-closed' }}"></div>
        <div style="font-size:12px;font-weight:700;color:{{ $chat->status==='open'?'#15803d':'#9ca3af' }};">
            {{ $chat->status === 'open' ? 'Open' : 'Selesai' }}
        </div>
    </div>
</div>

{{-- CHAT CARD --}}
<div class="lcs-card">

    {{-- Header --}}
    <div class="lcs-header">
        <div class="lcs-h-av" style="background:{{ $userColor }};">
            {{ strtoupper(substr($chat->user->name ?? '?', 0, 1)) }}
            @if($chat->status === 'open')
                <div class="lcs-h-online"></div>
            @endif
        </div>
        <div>
            <div class="lcs-h-name">{{ $chat->user->name ?? '(Akun Dihapus)' }}</div>
            <div class="lcs-h-meta">
                <i class="fa fa-clock-o" style="margin-right:4px;"></i>Dibuka {{ $chat->created_at->diffForHumans() }}
                &nbsp;·&nbsp;
                {{ $chat->messages->count() }} pesan
            </div>
        </div>
        <div class="lcs-h-actions">
            @if($chat->status === 'open')
                <form method="POST" action="{{ route('admin.chats.close', $chat) }}">
                    @csrf @method('PATCH')
                    <button class="btn-lcs-close" type="submit">
                        <i class="fa fa-check-circle"></i> Tutup Chat
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.chats.reopen', $chat) }}">
                    @csrf @method('PATCH')
                    <button class="btn-lcs-reopen" type="submit">
                        <i class="fa fa-refresh"></i> Buka Kembali
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Messages --}}
    <div class="lcs-messages" id="lcMessages">
        @if($chat->messages->isEmpty())
            <div class="lcs-no-msg">
                <i class="fa fa-comments-o"></i>
                <p>Belum ada pesan dalam percakapan ini.</p>
            </div>
        @else
            @php $prevDate = null; @endphp
            @foreach($chat->messages as $msg)
                @php
                    $msgDate = $msg->created_at->format('Y-m-d');
                    $isNewDate = $msgDate !== $prevDate;
                    $prevDate = $msgDate;
                @endphp

                @if($isNewDate)
                <div class="lcs-date-sep">
                    <span>{{ $msg->created_at->isToday() ? 'Hari ini' : ($msg->created_at->isYesterday() ? 'Kemarin' : $msg->created_at->format('d M Y')) }}</span>
                </div>
                @endif

                <div class="lcs-msg-group from-{{ $msg->sender_type }}" data-id="{{ $msg->id }}">
                    @if($msg->sender_type === 'user')
                        <div class="lcs-sender-tag">
                            <div style="width:18px;height:18px;border-radius:50%;background:{{ $userColor }};display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;color:#fff;">
                                {{ strtoupper(substr($chat->user->name ?? '?', 0, 1)) }}
                            </div>
                            {{ $chat->user->name ?? '?' }}
                        </div>
                    @endif
                    <div class="lcs-bubble">{{ $msg->body }}</div>
                    <div class="lcs-bubble-meta">
                        @if($msg->sender_type === 'admin')<i class="fa fa-check" style="font-size:9px;"></i>@endif
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Footer: closed banner OR reply area --}}
    @if($chat->status === 'closed')
        <div class="lcs-closed-banner">
            <i class="fa fa-lock"></i>
            Chat ini sudah ditutup · Buka kembali untuk membalas
        </div>
    @else
        <div class="lcs-reply">
            <textarea id="adminReplyInput" rows="1" placeholder="Tulis balasan… (Enter kirim, Shift+Enter baris baru)"></textarea>
            <button id="adminSendBtn" onclick="adminSend()">
                <i class="fa fa-paper-plane"></i> Kirim
            </button>
        </div>
    @endif

</div><!-- .lcs-card -->
</div><!-- .lcs-wrap -->

<script>
// Scroll to bottom
(function() {
    var box = document.getElementById('lcMessages');
    if (box) box.scrollTop = box.scrollHeight;
})();

var _lastId = {{ $chat->messages->max('id') ?? 0 }};
var _userColor = '{{ $userColor }}';
var _userName  = @json($chat->user->name ?? '?');

// Poll new messages every 4s
@if($chat->status === 'open')
setInterval(function() {
    fetch('{{ route("admin.chats.poll", $chat) }}?after=' + _lastId, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(function(r){ return r.json(); })
    .then(function(d) {
        d.messages.forEach(function(m) {
            appendAdminMsg(m);
            _lastId = m.id;
        });
    });
}, 4000);
@endif

function adminSend() {
    var input = document.getElementById('adminReplyInput');
    var body  = input.value.trim();
    if (!body) return;

    var btn = document.getElementById('adminSendBtn');
    btn.disabled = true;
    input.value = '';
    input.style.height = '';

    fetch('{{ route("admin.chats.reply", $chat) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ body: body })
    })
    .then(function(r){ return r.json(); })
    .then(function(m) {
        appendAdminMsg(m);
        _lastId = m.id;
        btn.disabled = false;
    })
    .catch(function() { btn.disabled = false; });
}

function appendAdminMsg(m) {
    var box = document.getElementById('lcMessages');
    var empty = box.querySelector('.lcs-no-msg');
    if (empty) empty.remove();
    if (box.querySelector('[data-id="' + m.id + '"]')) return;

    var group = document.createElement('div');
    group.className = 'lcs-msg-group from-' + m.sender_type;
    group.setAttribute('data-id', m.id);

    var nameHtml = '';
    if (m.sender_type === 'user') {
        nameHtml = '<div class="lcs-sender-tag">'
            + '<div style="width:18px;height:18px;border-radius:50%;background:' + _userColor + ';display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;color:#fff;">' + escHtml(_userName.charAt(0).toUpperCase()) + '</div>'
            + escHtml(_userName)
            + '</div>';
    }

    var checkIcon = m.sender_type === 'admin' ? '<i class="fa fa-check" style="font-size:9px;"></i> ' : '';

    group.innerHTML = nameHtml
        + '<div class="lcs-bubble">' + escHtml(m.body) + '</div>'
        + '<div class="lcs-bubble-meta">' + checkIcon + escHtml(m.time) + '</div>';

    box.appendChild(group);
    box.scrollTop = box.scrollHeight;
}

function escHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\n/g, '<br>');
}

// Auto-resize textarea + Enter to send
var inp = document.getElementById('adminReplyInput');
if (inp) {
    inp.addEventListener('input', function() {
        this.style.height = '';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
    inp.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); adminSend(); }
    });
}
</script>
@endsection
