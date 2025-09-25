<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'doctor_specialty_id',
        'license_number',
        'room_number',
        'clinic_phone_number',
        'doctor_note',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function specialty()
    {
        return $this->belongsTo(DoctorSpecialty::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function hmos()
    {
        return $this->belongsToMany(Hmo::class, 'doctor_hmos', 'doctor_id', 'hmo_id');
    }
}
