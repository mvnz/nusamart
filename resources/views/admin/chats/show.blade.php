@extends('layouts.admin')

@section('title', 'Chat dengan ' . ($chat->user->name ?? '?') . ' - Admin NusaMart')

@section('content')
<style>
.lc-show-wrap { max-width: 780px; margin: 0 auto; }

/* Back link */
.lc-back { display:inline-flex; align-items:center; gap:7px; font-size:13px; font-weight:700; color:#666; text-decoration:none; margin-bottom:18px; transition:color .15s; }
.lc-back:hover { color:#D10024; }

/* Chat card */
.lc-chat-card { background:#fff; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,.08); overflow:hidden; display:flex; flex-direction:column; height:calc(100vh - 220px); min-height:480px; }

/* Chat header */
.lc-chat-header { background:linear-gradient(135deg,#1a0533,#D10024); padding:16px 20px; display:flex; align-items:center; gap:12px; }
.lc-chat-avatar { width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:800; color:#fff; text-transform:uppercase; flex-shrink:0; }
.lc-chat-hname { font-size:14px; font-weight:800; color:#fff; }
.lc-chat-hmeta { font-size:11px; color:rgba(255,255,255,.7); margin-top:2px; }
.lc-chat-actions { margin-left:auto; display:flex; gap:8px; }
.btn-close-chat, .btn-reopen-chat {
    padding:6px 14px; border-radius:20px; border:none; cursor:pointer;
    font-size:12px; font-weight:700; font-family:inherit;
    display:inline-flex; align-items:center; gap:5px;
    transition:opacity .18s;
}
.btn-close-chat  { background:rgba(255,255,255,.18); color:#fff; }
.btn-close-chat:hover  { background:rgba(255,255,255,.28); }
.btn-reopen-chat { background:#4ade80; color:#052e16; }
.btn-reopen-chat:hover { opacity:.85; }

/* Messages */
.lc-messages {
    flex:1; overflow-y:auto; padding:18px 20px;
    background:#f8f9fc; display:flex; flex-direction:column; gap:12px;
    scroll-behavior:smooth;
}
.lc-messages::-webkit-scrollbar { width:5px; }
.lc-messages::-webkit-scrollbar-thumb { background:#ddd; border-radius:3px; }

.lc-msg { display:flex; flex-direction:column; max-width:75%; }
.lc-msg.from-user  { align-self:flex-start; align-items:flex-start; }
.lc-msg.from-admin { align-self:flex-end; align-items:flex-end; }

.lc-bubble { padding:10px 14px; border-radius:16px; font-size:13px; line-height:1.5; word-break:break-word; }
.from-user  .lc-bubble { background:#fff; border:1px solid #eee; color:#1e1f29; border-bottom-left-radius:4px; box-shadow:0 2px 6px rgba(0,0,0,.05); }
.from-admin .lc-bubble { background:linear-gradient(135deg,#D10024,#ff4d4d); color:#fff; border-bottom-right-radius:4px; }

.lc-msg-meta { font-size:10.5px; color:#bbb; margin-top:4px; }
.from-admin .lc-msg-meta { color:rgba(255,255,255,.55); }

.lc-sender-name { font-size:10.5px; font-weight:700; color:#888; margin-bottom:3px; }
.from-admin .lc-sender-name { display:none; }

/* Empty messages */
.lc-no-messages { text-align:center; padding:40px; color:#bbb; }
.lc-no-messages i { font-size:36px; display:block; margin-bottom:10px; }

/* Closed banner */
.lc-closed-banner { background:#f3f4f6; border-top:1px solid #e5e7eb; padding:12px 20px; text-align:center; font-size:12px; color:#9ca3af; }

/* Reply area */
.lc-reply { border-top:1px solid #f0f0f0; padding:14px 16px; background:#fff; display:flex; gap:10px; align-items:flex-end; }
#adminReplyInput {
    flex:1; border:1.5px solid #e5e7eb; border-radius:12px;
    padding:10px 14px; font-size:13px; font-family:inherit;
    resize:none; outline:none; line-height:1.4; max-height:110px; min-height:42px;
    transition:border-color .18s; color:#1e1f29;
}
#adminReplyInput:focus { border-color:#D10024; }
#adminReplyInput::placeholder { color:#bbb; }
#adminSendBtn {
    padding:10px 20px; background:linear-gradient(135deg,#D10024,#ff4d4d);
    border:none; border-radius:12px; color:#fff;
    font-size:13px; font-weight:700; font-family:inherit;
    cursor:pointer; white-space:nowrap;
    display:flex; align-items:center; gap:6px;
    transition:transform .18s, opacity .18s;
}
#adminSendBtn:hover { transform:scale(1.04); }
#adminSendBtn:disabled { opacity:.5; cursor:not-allowed; transform:none; }
</style>

<div class="lc-show-wrap">
    <a href="{{ route('admin.chats') }}" class="lc-back">
        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Chat
    </a>

    <div class="lc-chat-card">
        {{-- Header --}}
        <div class="lc-chat-header">
            <div class="lc-chat-avatar">{{ strtoupper(substr($chat->user->name ?? '?', 0, 1)) }}</div>
            <div>
                <div class="lc-chat-hname">{{ $chat->user->name ?? '(Akun Dihapus)' }}</div>
                <div class="lc-chat-hmeta">
                    {{ $chat->user->email ?? '' }} &nbsp;·&nbsp;
                    Dibuka {{ $chat->created_at->diffForHumans() }}
                </div>
            </div>
            <div class="lc-chat-actions">
                @if($chat->status === 'open')
                    <form method="POST" action="{{ route('admin.chats.close', $chat) }}">
                        @csrf @method('PATCH')
                        <button class="btn-close-chat" type="submit">
                            <i class="fa fa-check"></i> Tutup Chat
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.chats.reopen', $chat) }}">
                        @csrf @method('PATCH')
                        <button class="btn-reopen-chat" type="submit">
                            <i class="fa fa-refresh"></i> Buka Kembali
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Messages --}}
        <div class="lc-messages" id="lcMessages">
            @if($chat->messages->isEmpty())
                <div class="lc-no-messages">
                    <i class="fa fa-comment-o"></i>
                    Belum ada pesan.
                </div>
            @else
                @foreach($chat->messages as $msg)
                <div class="lc-msg from-{{ $msg->sender_type }}" data-id="{{ $msg->id }}">
                    @if($msg->sender_type === 'user')
                        <div class="lc-sender-name">{{ $chat->user->name ?? '?' }}</div>
                    @endif
                    <div class="lc-bubble">{{ $msg->body }}</div>
                    <div class="lc-msg-meta">{{ $msg->created_at->format('d M Y, H:i') }}</div>
                </div>
                @endforeach
            @endif
        </div>

        {{-- Closed banner or reply area --}}
        @if($chat->status === 'closed')
            <div class="lc-closed-banner">
                <i class="fa fa-lock" style="margin-right:5px;"></i>
                Chat ini sudah ditutup. Buka kembali untuk membalas.
            </div>
        @else
            <div class="lc-reply">
                <textarea id="adminReplyInput" rows="1" placeholder="Tulis balasan..."></textarea>
                <button id="adminSendBtn" onclick="adminSend()">
                    <i class="fa fa-paper-plane"></i> Kirim
                </button>
            </div>
        @endif
    </div>
</div>

<script>
// Scroll to bottom on load
(function() {
    var box = document.getElementById('lcMessages');
    if (box) box.scrollTop = box.scrollHeight;
})();

var _lastId = {{ $chat->messages->max('id') ?? 0 }};

// Poll new messages every 4s
@if($chat->status === 'open')
setInterval(function() {
    fetch('{{ route("admin.chats.poll", $chat) }}?after=' + _lastId, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(d => {
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

    document.getElementById('adminSendBtn').disabled = true;
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
    .then(r => r.json())
    .then(m => {
        appendAdminMsg(m);
        _lastId = m.id;
        document.getElementById('adminSendBtn').disabled = false;
    })
    .catch(() => { document.getElementById('adminSendBtn').disabled = false; });
}

function appendAdminMsg(m) {
    var box = document.getElementById('lcMessages');
    // Remove empty state if present
    var empty = box.querySelector('.lc-no-messages');
    if (empty) empty.remove();

    // Avoid duplicate
    if (box.querySelector('[data-id="' + m.id + '"]')) return;

    var div = document.createElement('div');
    div.className = 'lc-msg from-' + m.sender_type;
    div.setAttribute('data-id', m.id);
    var nameHtml = m.sender_type === 'user'
        ? '<div class="lc-sender-name">' + escHtml(m.sender_name) + '</div>'
        : '';
    div.innerHTML = nameHtml +
        '<div class="lc-bubble">' + escHtml(m.body) + '</div>' +
        '<div class="lc-msg-meta">' + m.time + '</div>';
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
}

// Auto-resize textarea
var inp = document.getElementById('adminReplyInput');
if (inp) {
    inp.addEventListener('input', function() {
        this.style.height = '';
        this.style.height = Math.min(this.scrollHeight, 108) + 'px';
    });
    inp.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); adminSend(); }
    });
}
</script>
@endsection
