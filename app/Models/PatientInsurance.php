<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientInsurance extends Model
{
    protected $fillable = [
        'patient_id',
        'insurance_id',
        'policy_number',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }
}
