<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['medical_history'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function hmos()
    {
        return $this->hasMany(PatientHmo::class);
    }

    public function insurances()
    {
        return $this->hasMany(PatientInsurance::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
