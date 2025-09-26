<?php
declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

// This route group is for authenticated users.
// It uses the `auth` middleware to protect all routes within it.
Route::middleware(['auth'])->group(function () {
    // The dashboard route, accessible only when logged in.
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // All resource routes for the models are now protected.
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);
    Route::resource('services', \App\Http\Controllers\ServiceController::class);
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
});




// These routes, from Laravel Breeze, are also protected.
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
