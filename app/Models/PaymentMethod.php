<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'payment_method_category_id',
        'name',
    ];

    public function category()
    {
        return $this->belongsTo(PaymentMethodCategory::class);
    }
    
    public function transactions()
    {
        return $this->hasMany(PatientBillTransaction::class);
    }
}
