<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConsignmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

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
    
    Route::resource('vehicles', VehicleController::class);
    
    Route::resource('categories', CategoryController::class);
    
    Route::resource('consignments', ConsignmentController::class);
    
    Route::resource('sales', SaleController::class);

    Route::post('vendors/quick-store', [VendorController::class, 'storeQuick'])->name('vendors.quick-store');
    Route::post('vehicles/quick-store', [VehicleController::class, 'storeQuick'])->name('vehicles.quick-store');
    
    Route::get('consignments/{consignment}/receipt', [ConsignmentController::class, 'receipt'])->name('consignments.receipt');

   
});

Route::middleware('auth')->prefix('invoices')->group(function () {
    Route::get('/', [InvoiceController::class, 'index'])->name('invoices');
    Route::get('/{invoice}', [InvoiceController::class, 'show']);
    Route::get('/{invoice}/print', [InvoiceController::class, 'invoice']);

});
