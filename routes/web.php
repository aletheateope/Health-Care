<?php

use Illuminate\Support\Facades\Route;

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

route::get('/login', function () {
    return view('login');
})->name('login');

route::get('/register', function () {
    return view('register');
})->name('register');

route::get('/portal/dashboard', function () {
    return view('app');
})->name('portal');
