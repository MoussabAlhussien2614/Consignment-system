<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ConsignmentController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::resource('vendors', VendorController::class);
    // Vehicles
    Route::resource('vehicles', VehicleController::class);
    // Categories
    Route::resource('categories', CategoryController::class);
    // Consignments
    Route::resource('consignments', ConsignmentController::class);
});




Route::middleware('auth')->prefix("invoices")->group(function () {
    Route::get('/', [InvoiceController::class, 'index'])->name('invoices');

});
