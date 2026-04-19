<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    /**
     * List all chat sessions for admin.
     */
    public function index()
    {
        $chats = Chat::with(['user', 'latestMessage'])
            ->orderByDesc('last_message_at')
            ->orderByDesc('created_at')
            ->paginate(20);

        $totalUnread = Chat::with('messages')
            ->get()
            ->sum(fn($c) => $c->unreadByAdmin());

        return view('admin.chats.index', compact('chats', 'totalUnread'));
    }

    /**
     * Show a single chat session with full conversation.
     */
    public function show(Chat $chat)
    {
        $chat->load(['user', 'messages.sender']);

        // Mark all user messages as read
        $chat->messages()
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('admin.chats.show', compact('chat'));
    }

    /**
     * Admin sends a reply.
     */
    public function reply(Request $request, Chat $chat)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        if ($chat->status === 'closed') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Chat sudah ditutup.'], 422);
            }
            return back()->withErrors(['message' => 'Chat sudah ditutup.']);
        }

        $message = ChatMessage::create([
            'chat_id'     => $chat->id,
            'sender_type' => 'admin',
            'sender_id'   => auth()->id(),
            'body'        => $request->body,
            'is_read'     => false,
        ]);

        $chat->update(['last_message_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json([
                'id'          => $message->id,
                'body'        => $message->body,
                'sender_type' => 'admin',
                'sender_name' => 'Support NusaMart',
                'time'        => $message->created_at->format('H:i'),
            ]);
        }

        return back();
    }

    /**
     * Close a chat session.
     */
    public function close(Chat $chat)
    {
        $chat->update(['status' => 'closed']);

        if (request()->expectsJson()) {
            return response()->json(['status' => 'closed']);
        }

        return back()->with('success', 'Chat ditutup.');
    }

    /**
     * Reopen a closed chat.
     */
    public function reopen(Chat $chat)
    {
        $chat->update(['status' => 'open']);
        return back()->with('success', 'Chat dibuka kembali.');
    }

    /**
     * JSON: return total unread count (for navbar badge polling).
     */
    public function unreadCount()
    {
        $count = ChatMessage::where('sender_type', 'user')
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * JSON: poll new messages for a chat (admin side).
     */
    public function poll(Chat $chat)
    {
        $afterId = request('after', 0);

        $messages = $chat->messages()
            ->where('id', '>', $afterId)
            ->get()
            ->map(fn($m) => [
                'id'          => $m->id,
                'body'        => $m->body,
                'sender_type' => $m->sender_type,
                'sender_name' => $m->sender_type === 'admin' ? 'Support NusaMart' : $chat->user->name,
                'time'        => $m->created_at->format('H:i'),
            ]);

        // Mark user messages as read
        $chat->messages()
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }
}
