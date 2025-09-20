<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientBill extends Model
{
    protected $fillable = [
        'appointment_id',
        'total_amount',
        'discount_amount',
        'hmo_amount_coverage',
        'insurance_amount_coverage',
        'balance',
        'status',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function transactions()
    {
        return $this->hasMany(PatientBillTransaction::class);
    }
}
