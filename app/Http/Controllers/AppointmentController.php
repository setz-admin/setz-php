<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the 'customer' relationship to avoid the N+1 query problem.
        $appointments = Appointment::with('customer')->get();

        // Return a view and pass the appointments data to it.
        // We will create this view in the next step.
        return view('appointments.index', compact('appointments'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        // Create the new appointment record
        Appointment::create($validated);

        // Redirect to the index page after creation
        return redirect()->route('appointments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // Eager load the 'customer' relationship for the view
        $appointment->load('customer');

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        // Update the appointment record with the validated data
        $appointment->update($validated);

        // Redirect to the index page after a successful update
        return redirect()->route('appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        // Redirect back to the index page after deletion.
        return redirect()->route('appointments.index');
    }
}
