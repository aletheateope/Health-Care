<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'recipient_id',
        'notification_type_id',
        'reference_type',
        'reference_id',
        'seen',
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class);
    }

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }
}
