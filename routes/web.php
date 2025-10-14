<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/doctor', function () {
    return view('doctor');
})->name('doctor');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('portal');
    }
    return view('login');
})->name('login');

Route::get('/register', function () {
    if (Auth::check()) {
        return redirect()->route('portal');
    }
    return view('register');
})->name('register');

Route::middleware(['auth'])->prefix('portal')->group(function () {
    Route::get('/{any?}', function () {
        return view('app');
    })->where('any', '.*')->name('portal');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user', [UserController::class, 'currentUser']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/doctor/schedule', [ScheduleController::class, 'store']);
    Route::get('/doctor/schedule', [ScheduleController::class, 'mySchedule']);
    Route::put('/doctor/profile', [DoctorProfileController::class, 'update']);
    Route::post('/appointment', [AppointmentController::class, 'store']);
});

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});



// Route::get('/portal/dashboard', function () {
//     return view('app');
// })->name('portal');
