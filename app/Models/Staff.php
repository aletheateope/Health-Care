<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
