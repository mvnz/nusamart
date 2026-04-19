<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['user_id', 'status', 'last_message_at'];

    protected $casts = [
        'user_id' => 'integer',
        'last_message_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latestOfMany();
    }

    public function unreadByAdmin()
    {
        return $this->messages()->where('sender_type', 'user')->where('is_read', false)->count();
    }

    public function unreadByUser()
    {
        return $this->messages()->where('sender_type', 'admin')->where('is_read', false)->count();
    }
}
