<?php
declare(strict_types=1);

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

// Resource routes for the models
Route::resource('customers', CustomerController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('appointments', AppointmentController::class);
Route::resource('services', ServiceController::class);
Route::resource('invoices', InvoiceController::class);
