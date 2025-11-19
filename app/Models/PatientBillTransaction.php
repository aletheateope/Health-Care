<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientBillTransaction extends Model
{
    protected $fillable = [
        'patient_bill_id',
        'amount',
        'payment_method_id',
    ];

    public function bill()
    {
        return $this->belongsTo(PatientBill::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
