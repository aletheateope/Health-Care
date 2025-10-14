<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hmo;
use App\Http\Resources\HmoResource;

class HmoController extends Controller
{
    public function index()
    {
        return HmoResource::collection(Hmo::all());
    }
}
