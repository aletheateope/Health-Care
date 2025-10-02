<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'appointment_id',
        'file_path',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
