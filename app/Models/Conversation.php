<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'ref_id',
        'last_message_id',
    ];

    public function messages()
    {
        return $this->hasMany(ConversationMessage::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants', 'conversation_id', 'user_id');
    }

    public function latestMessage()
    {
        return $this->belongsTo(ConversationMessage::class, 'last_message_id')
            ->with('user');
    }
}
