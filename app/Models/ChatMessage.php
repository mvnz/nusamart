<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['chat_id', 'sender_type', 'sender_id', 'body', 'is_read'];

    protected $casts = [
        'chat_id' => 'integer',
        'sender_id' => 'integer',
        'is_read' => 'boolean',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
