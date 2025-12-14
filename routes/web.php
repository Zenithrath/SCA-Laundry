<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;




Route::get('/', [UserController::class, 'index'])->name('landing');

// Halaman Login & Register 
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']); 
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// 2. ORDER (Booking)

Route::middleware('auth')->group(function () {
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
});


// 3. ADMIN PANEL

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Halaman Customers
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    
    // Halaman Services
    Route::get('/services', [AdminController::class, 'services'])->name('services');
    
    // CRUD Service
    Route::post('/service/add', [AdminController::class, 'addService'])->name('service.add');
    Route::post('/service/{id}/update', [AdminController::class, 'updateService'])->name('service.update'); 
    Route::post('/service/{id}/image', [AdminController::class, 'updateServiceImage'])->name('service.image.update'); 
    Route::delete('/service/{id}', [AdminController::class, 'deleteService'])->name('service.delete');
    Route::get('/finance', [AdminController::class, 'finance'])->name('finance');
    Route::post('/order/{id}/status', [AdminController::class, 'updateStatus'])->name('order.status');
});