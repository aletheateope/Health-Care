<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'status',
        'valid_until',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function remarks()
    {
        return $this->hasMany(PrescriptionRemark::class);
    }
}
