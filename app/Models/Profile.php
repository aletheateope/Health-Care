<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone_number',
        'contact_email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
}
