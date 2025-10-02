<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'service_id',
        'start_date',
        'end_date',
        'patient_hmo_id',
        'patient_insurance_id',
        'chief_complaint',
        'status',
        'appointment_type',
        'date_booked'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function patientHmo()
    {
        return $this->belongsTo(PatientHmo::class);
    }

    public function patientInsurance()
    {
        return $this->belongsTo(PatientInsurance::class);
    }

    public function testResult()
    {
        return $this->hasOne(TestResult::class);
    }
}
