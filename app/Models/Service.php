<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service_category_id',
        'name',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
