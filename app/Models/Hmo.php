<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hmo extends Model
{
    protected $fillable = [
        'name',
    ];
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_hmos', 'hmo_id', 'doctor_id');
    }

    public function patientHmos()
    {
        return $this->hasMany(PatientHmo::class);
    }
}
