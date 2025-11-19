<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    public function patientInsurances()
    {
        return $this->hasMany(PatientInsurance::class);
    }
}
