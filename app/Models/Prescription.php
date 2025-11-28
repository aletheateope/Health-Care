<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'ref_id',
        'doctor_id',
        'patient_id',
        'status',
        'valid_until',
    ];

    protected $casts = [
    'valid_until' => 'datetime',
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

    public function getRouteKeyName()
    {
        return 'ref_id';
    }
}
