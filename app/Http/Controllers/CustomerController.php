<?php
// app/Http/Controllers/CustomerController.php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
/**
* Display a listing of the resource.
*/
public function index()
{
$customers = Customer::all();

return view('customers.index', compact('customers'));
}

/**
* Show the form for creating a new resource.
*/
public function create()
{
return view('customers.create');
}

/**
* Store a newly created resource in storage.
*/
public function store(Request $request)
{
$validated = $request->validate([
'name' => 'required|string|max:255',
'email' => 'required|email|unique:customers,email',
'phone' => 'nullable|string|max:255',
'address' => 'nullable|string|max:255',
]);

Customer::create($validated);

return redirect()->route('customers.index');
}

/**
* Display the specified resource.
*/
public function show(Customer $customer)
{
return view('customers.show', compact('customer'));
}

/**
* Show the form for editing the specified resource.
*/
public function edit(Customer $customer)
{
return view('customers.edit', compact('customer'));
}

/**
* Update the specified resource in storage.
*/
public function update(Request $request, Customer $customer)
{
$validated = $request->validate([
'name' => 'required|string|max:255',
'email' => 'required|email|unique:customers,email,' . $customer->id,
'phone' => 'nullable|string|max:255',
'address' => 'nullable|string|max:255',
]);

$customer->update($validated);

return redirect()->route('customers.index');
}

/**
* Remove the specified resource from storage.
*/
public function destroy(Customer $customer)
{
$customer->delete();

return redirect()->route('customers.index');
}
}
