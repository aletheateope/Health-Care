<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientHmo extends Model
{
    protected $fillable = [
            'patient_id',
            'hmo_id',
            'hmo_number'
        ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }
}
