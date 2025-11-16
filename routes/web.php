<?php

use App\Http\Controllers\AuthController;
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
});



Route::middleware('auth')->prefix("consignments")->group(function () {
    Route::get('/', [ConsignmentController::class, 'index'])->name('consignments');

});



Route::middleware('auth')->prefix("invoices")->group(function () {
    Route::get('/', [InvoiceController::class, 'index'])->name('invoices');

});
