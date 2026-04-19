{{-- Chat Widget — hanya tampil untuk user yang login (bukan admin) --}}
@auth
@if(auth()->user()->role !== 'admin')
<style>
/* ══ CHAT WIDGET ══ */
#chatWidget {
    position: fixed;
    bottom: 24px; right: 24px;
    z-index: 9999;
    font-family: 'Montserrat', sans-serif;
}

/* Bubble button */
#chatBubble {
    width: 58px; height: 58px;
    border-radius: 50%;
    background: linear-gradient(135deg, #D10024, #ff6b35);
    box-shadow: 0 6px 24px rgba(209,0,36,.45);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .22s;
    position: relative;
}
#chatBubble:hover { transform: scale(1.12); box-shadow: 0 10px 32px rgba(209,0,36,.55); }
#chatBubble .fa { font-size: 22px; color: #fff; }
#chatBubble .chat-open-icon  { display: block; }
#chatBubble .chat-close-icon { display: none; }
#chatWidget.open #chatBubble .chat-open-icon  { display: none; }
#chatWidget.open #chatBubble .chat-close-icon { display: block; }

/* Unread badge on bubble */
#chatUnreadBadge {
    position: absolute; top: -4px; right: -4px;
    background: #ff3d3d;
    color: #fff; font-size: 10px; font-weight: 800;
    min-width: 18px; height: 18px;
    border-radius: 9px; padding: 0 5px;
    display: none; align-items: center; justify-content: center;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,.2);
}
#chatUnreadBadge.show { display: flex; }

/* Chat window */
#chatWindow {
    position: absolute;
    bottom: 70px; right: 0;
    width: 360px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: chatSlideIn .28s cubic-bezier(.34,1.56,.64,1);
    max-height: 520px;
}
#chatWidget.open #chatWindow { display: flex; }
@keyframes chatSlideIn {
    from { opacity:0; transform:translateY(20px) scale(.95); }
    to   { opacity:1; transform:translateY(0) scale(1); }
}
@media(max-width:400px) {
    #chatWindow { width: calc(100vw - 32px); right: -8px; }
}

/* Header */
#chatHeader {
    background: linear-gradient(135deg, #1a0533, #D10024);
    padding: 16px 18px;
    display: flex; align-items: center; gap: 12px;
}
.chat-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #fff; flex-shrink: 0;
}
.chat-header-info { flex: 1; min-width: 0; }
.chat-header-name { font-size: 14px; font-weight: 800; color: #fff; }
.chat-header-status {
    font-size: 11px; color: rgba(255,255,255,.7);
    display: flex; align-items: center; gap: 5px;
}
.chat-status-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #4ade80;
    animation: statusPulse 2s ease-in-out infinite;
}
@keyframes statusPulse { 0%,100%{opacity:1} 50%{opacity:.4} }

/* Messages area */
#chatMessages {
    flex: 1;
    overflow-y: auto;
    padding: 16px 14px;
    display: flex; flex-direction: column; gap: 10px;
    min-height: 200px; max-height: 320px;
    background: #f8f9fc;
    scroll-behavior: smooth;
}
#chatMessages::-webkit-scrollbar { width: 4px; }
#chatMessages::-webkit-scrollbar-track { background: transparent; }
#chatMessages::-webkit-scrollbar-thumb { background: #ddd; border-radius: 2px; }

/* Welcome message */
.chat-welcome {
    text-align: center; padding: 16px 10px;
}
.chat-welcome-icon {
    width: 52px; height: 52px;
    background: linear-gradient(135deg,#fee2e2,#fecaca);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 22px; color: #D10024; margin-bottom: 10px;
}
.chat-welcome h4 { font-size: 13px; font-weight: 800; color: #1e1f29; margin: 0 0 4px; }
.chat-welcome p  { font-size: 11.5px; color: #888; margin: 0; }

/* Message bubbles */
.chat-msg { display: flex; flex-direction: column; max-width: 82%; }
.chat-msg.from-user  { align-self: flex-end; align-items: flex-end; }
.chat-msg.from-admin { align-self: flex-start; align-items: flex-start; }

.chat-bubble {
    padding: 9px 13px;
    border-radius: 16px;
    font-size: 12.5px; line-height: 1.5;
    word-break: break-word;
}
.from-user  .chat-bubble { background: linear-gradient(135deg,#D10024,#ff6b35); color:#fff; border-bottom-right-radius:4px; }
.from-admin .chat-bubble { background: #fff; color: #1e1f29; border: 1px solid #eee; border-bottom-left-radius:4px; box-shadow: 0 2px 6px rgba(0,0,0,.05); }

.chat-time { font-size: 10px; color: #bbb; margin-top: 3px; }
.from-user .chat-time { color: rgba(255,255,255,.6); }

/* Typing indicator */
.chat-typing { align-self: flex-start; padding: 6px 12px; }
.chat-typing-dots { display: flex; gap: 4px; }
.chat-typing-dots span {
    width: 7px; height: 7px; border-radius: 50%; background: #ccc;
    animation: typingDot 1.2s ease-in-out infinite;
}
.chat-typing-dots span:nth-child(2) { animation-delay: .2s; }
.chat-typing-dots span:nth-child(3) { animation-delay: .4s; }
@keyframes typingDot { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-5px)} }

/* Closed state */
.chat-closed-notice {
    background: #f8f9fa; border-top: 1px solid #eee;
    padding: 10px 14px; text-align: center;
    font-size: 11.5px; color: #999;
}

/* Input area */
#chatInputArea {
    border-top: 1px solid #f0f0f0;
    padding: 10px 12px;
    display: flex; gap: 8px; align-items: flex-end;
    background: #fff;
}
#chatInput {
    flex: 1;
    border: 1.5px solid #e5e7eb; border-radius: 12px;
    padding: 9px 12px;
    font-size: 12.5px; font-family: inherit;
    resize: none; outline: none;
    line-height: 1.4; max-height: 90px; min-height: 38px;
    transition: border-color .18s;
    color: #1e1f29;
}
#chatInput:focus { border-color: #D10024; }
#chatInput::placeholder { color: #bbb; }
#chatSendBtn {
    width: 38px; height: 38px; flex-shrink: 0;
    background: linear-gradient(135deg,#D10024,#ff4d4d);
    border: none; border-radius: 10px;
    color: #fff; font-size: 14px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: transform .18s, opacity .18s;
}
#chatSendBtn:hover { transform: scale(1.08); }
#chatSendBtn:disabled { opacity: .5; cursor: not-allowed; transform: none; }
</style>

<div id="chatWidget">
    {{-- Bubble --}}
    <div id="chatBubble" onclick="chatToggle()" title="Live Chat Support">
        <i class="fa fa-comments chat-open-icon"></i>
        <i class="fa fa-times chat-close-icon"></i>
        <div id="chatUnreadBadge"></div>
    </div>

    {{-- Window --}}
    <div id="chatWindow">
        {{-- Header --}}
        <div id="chatHeader">
            <div class="chat-avatar"><i class="fa fa-headphones"></i></div>
            <div class="chat-header-info">
                <div class="chat-header-name">Support NusaMart</div>
                <div class="chat-header-status">
                    <span class="chat-status-dot"></span> Online · Siap membantu
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div id="chatMessages">
            <div class="chat-welcome" id="chatWelcome">
                <div class="chat-welcome-icon"><i class="fa fa-comments"></i></div>
                <h4>Halo, {{ auth()->user()->name }}! 👋</h4>
                <p>Ada yang bisa kami bantu? Kirim pesan dan tim kami akan segera membalas.</p>
            </div>
        </div>

        {{-- Input --}}
        <div id="chatInputArea">
            <textarea id="chatInput" rows="1" placeholder="Ketik pesan..."></textarea>
            <button id="chatSendBtn" onclick="chatSend()" title="Kirim">
                <i class="fa fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
var _chatId   = null;
var _lastMsgId = 0;
var _pollTimer = null;
var _chatOpen  = false;

function chatToggle() {
    _chatOpen = !_chatOpen;
    var w = document.getElementById('chatWidget');
    if (_chatOpen) {
        w.classList.add('open');
        chatInit();
    } else {
        w.classList.remove('open');
    }
}

function chatInit() {
    if (_chatId) { return; }
    fetch('{{ route("chat.start") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(d => {
        _chatId = d.chat_id;
        chatPollMessages();
        _pollTimer = setInterval(chatPollMessages, 4000);

        if (d.unread > 0) {
            showUnreadBadge(d.unread);
        }
    });
}

function chatPollMessages() {
    if (!_chatId) return;
    fetch('/chat/' + _chatId + '/messages?after=' + _lastMsgId, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(d => {
        d.messages.forEach(m => appendMessage(m));
        if (d.messages.length) {
            _lastMsgId = d.messages[d.messages.length - 1].id;
            clearUnreadBadge();
        }
    });
}

function chatSend() {
    var input = document.getElementById('chatInput');
    var body  = input.value.trim();
    if (!body || !_chatId) return;

    input.value = '';
    input.style.height = '';
    document.getElementById('chatSendBtn').disabled = true;

    fetch('/chat/' + _chatId + '/send', {
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
        appendMessage(m);
        _lastMsgId = m.id;
        document.getElementById('chatSendBtn').disabled = false;
    })
    .catch(() => { document.getElementById('chatSendBtn').disabled = false; });
}

function appendMessage(m) {
    var box = document.getElementById('chatMessages');
    var welcome = document.getElementById('chatWelcome');
    if (welcome) welcome.remove();

    var div = document.createElement('div');
    div.className = 'chat-msg from-' + m.sender_type;
    div.innerHTML =
        '<div class="chat-bubble">' + escHtml(m.body) + '</div>' +
        '<div class="chat-time">' + m.time + '</div>';
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
}

function showUnreadBadge(n) {
    var b = document.getElementById('chatUnreadBadge');
    b.textContent = n > 9 ? '9+' : n;
    b.classList.add('show');
}
function clearUnreadBadge() {
    var b = document.getElementById('chatUnreadBadge');
    b.classList.remove('show');
}

// Auto-resize textarea
document.getElementById('chatInput').addEventListener('input', function() {
    this.style.height = '';
    this.style.height = Math.min(this.scrollHeight, 88) + 'px';
});
// Send on Enter (Shift+Enter = newline)
document.getElementById('chatInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); chatSend(); }
});
</script>
@endif
@endauth
