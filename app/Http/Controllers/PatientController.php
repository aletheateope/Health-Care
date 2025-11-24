<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Resources\PatientResource;

class PatientController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->q;

        if (!$query) {
            return PatientResource::collection([]);
        }

        $patients = Patient::whereHas('profile', function ($q) use ($query) {
            $q->where('first_name', 'LIKE', "%{$query}%")
              ->orWhere('middle_name', 'LIKE', "%{$query}%")
              ->orWhere('last_name', 'LIKE', "%{$query}%");
        })
        ->with('profile')
        ->limit(10)
        ->get();

        return PatientResource::collection($patients);
    }
}
