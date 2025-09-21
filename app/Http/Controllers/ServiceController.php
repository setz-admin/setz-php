<?php
// app/Http/Controllers/ServiceController.php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
/**
* Display a listing of the resource.
*/
public function index()
{
$services = Service::with('appointment')->get();
return view('services.index', compact('services'));
}

/**
* Show the form for creating a new resource.
*/
public function create()
{
$appointments = Appointment::all();
return view('services.create', compact('appointments'));
}

/**
* Store a newly created resource in storage.
*/
public function store(Request $request)
{
$validated = $request->validate([
'appointment_id' => 'required|exists:appointments,id',
'description' => 'required|string|max:255',
'price' => 'required|numeric',
'payment_status' => 'required|string',
'invoiced_at' => 'nullable|date',
]);

Service::create($validated);
return redirect()->route('services.index');
}

/**
* Display the specified resource.
*/
public function show(Service $service)
{
$service->load('appointment');
return view('services.show', compact('service'));
}

/**
* Show the form for editing the specified resource.
*/
public function edit(Service $service)
{
$appointments = Appointment::all();
return view('services.edit', compact('service', 'appointments'));
}

/**
* Update the specified resource in storage.
*/
public function update(Request $request, Service $service)
{
$validated = $request->validate([
'appointment_id' => 'required|exists:appointments,id',
'description' => 'required|string|max:255',
'price' => 'required|numeric',
'payment_status' => 'required|string',
'invoiced_at' => 'nullable|date',
]);

$service->update($validated);
return redirect()->route('services.index');
}

/**
* Remove the specified resource from storage.
*/
public function destroy(Service $service)
{
$service->delete();
return redirect()->route('services.index');
}
}
