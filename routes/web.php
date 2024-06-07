<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', [LoginController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index']);
