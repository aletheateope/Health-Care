<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insurance;
use App\Http\Resources\InsuranceResource;

class InsuranceController extends Controller
{
    public function index(Request $request)
    {
        $query = Insurance::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return InsuranceResource::collection($query->orderBy('name')->get());

    }
}
