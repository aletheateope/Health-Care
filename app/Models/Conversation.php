<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'date_created',
    ];

    public function messages()
    {
        return $this->hasMany(ConversationMessage::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'conversation_participants', 'conversation_id', 'user_id');
    }
}
