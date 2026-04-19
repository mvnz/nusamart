<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Get or create the user's active chat session.
     * Returns chat_id + any unread message count from admin.
     */
    public function start()
    {
        $user = auth()->user();

        $chat = Chat::where('user_id', $user->id)
            ->where('status', 'open')
            ->latest()
            ->first();

        if (!$chat) {
            $chat = Chat::create([
                'user_id' => $user->id,
                'status'  => 'open',
            ]);
        }

        return response()->json([
            'chat_id'        => $chat->id,
            'unread'         => $chat->unreadByUser(),
            'status'         => $chat->status,
        ]);
    }

    /**
     * Fetch messages for the user's chat (optionally after a given message id).
     */
    public function messages(Chat $chat)
    {
        $this->authorizeChat($chat);

        $afterId = request('after', 0);

        $messages = $chat->messages()
            ->where('id', '>', $afterId)
            ->get()
            ->map(fn($m) => [
                'id'          => $m->id,
                'body'        => $m->body,
                'sender_type' => $m->sender_type,
                'sender_name' => $m->sender_type === 'admin' ? 'Support NusaMart' : auth()->user()->name,
                'time'        => $m->created_at->format('H:i'),
            ]);

        // Mark admin messages as read
        $chat->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }

    /**
     * Send a message from the user.
     */
    public function send(Request $request, Chat $chat)
    {
        $this->authorizeChat($chat);

        if ($chat->status === 'closed') {
            return response()->json(['error' => 'Chat sudah ditutup.'], 422);
        }

        $request->validate(['body' => 'required|string|max:2000']);

        $message = ChatMessage::create([
            'chat_id'     => $chat->id,
            'sender_type' => 'user',
            'sender_id'   => auth()->id(),
            'body'        => $request->body,
            'is_read'     => false,
        ]);

        $chat->update(['last_message_at' => now()]);

        return response()->json([
            'id'          => $message->id,
            'body'        => $message->body,
            'sender_type' => 'user',
            'time'        => $message->created_at->format('H:i'),
        ]);
    }

    private function authorizeChat(Chat $chat): void
    {
        abort_if((int)$chat->user_id !== (int)auth()->id(), 403);
    }
}
