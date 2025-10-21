<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HmoController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\DoctorSpecialtyController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/hmos', [HmoController::class, 'index']);
Route::get('/insurances', [InsuranceController::class, 'index']);
Route::get('/doctors', [DoctorController::class, 'index']);
Route::get('/doctor/specialties', [DoctorSpecialtyController::class, 'index']);
Route::get('/available-time-slots', [AppointmentController::class, 'getAvailableTimes']);
