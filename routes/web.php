<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

route::get('/', function () {
    return view('home');
})->name('home');

route::get('/about', function () {
    return view('about');
})->name('about');

route::get('/services', function () {
    return view('services');
})->name('services');

route::get('/doctor', function () {
    return view('doctor');
})->name('doctor');

route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/portal/dashboard');
    }
    return view('login');
})->name('login');

Route::get('/register', function () {
    if (Auth::check()) {
        return redirect('/portal/dashboard');
    }
    return view('register');
})->name('register');

route::middleware(['auth'])->get('/portal/dashboard', function () {
    return view('app');
})->name('portal');

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});
