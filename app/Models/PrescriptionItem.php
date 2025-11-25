<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    protected $fillable = [
        'prescription_id',
        'item',
        'quantity',
        'sig',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
