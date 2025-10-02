<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionRemark extends Model
{
    protected $fillable = [
        'prescription_id',
        'remark'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
