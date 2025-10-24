<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorSpecialty;
use App\Http\Resources\DoctorSpecialtyResource;

class DoctorSpecialtyController extends Controller
{
    public function index()
    {
        return DoctorSpecialtyResource::collection(DoctorSpecialty::all());
    }
}
