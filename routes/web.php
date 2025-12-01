<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('user');
});


Route::get('/login', function () {
    return view('login');
});


Route::get('/admin', function () {
    return view('admin');
});


Route::get('/api/landing-data', [UserController::class, 'getLandingData']);

// Auth
Route::post('/login-process', [AuthController::class, 'login']);
Route::post('/register-process', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// Admin API
Route::prefix('api/admin')->group(function () {
    Route::get('/data', [AdminController::class, 'getData']);
    Route::post('/order/{id}/status', [AdminController::class, 'updateStatus']);
    Route::post('/service/{id}/update', [AdminController::class, 'updateService']);
    Route::post('/service/add', [AdminController::class, 'addService']);
    Route::delete('/service/{id}', [AdminController::class, 'deleteService']);
});

Route::middleware('auth')->post('/api/order/store', [OrderController::class, 'store']);