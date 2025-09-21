<?php

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;

it('can view a list of appointments', function () {
    Appointment::factory()->count(2)->create();

    $this->get(route('appointments.index'))
        ->assertStatus(200)
        ->assertSee('Termine');
});

it('can create an appointment', function () {
    $customer = Customer::factory()->create();
    $employee = Employee::factory()->create();

    $appointmentData = [
        'customer_id' => $customer->id,
        'employee_id' => $employee->id,
        'scheduled_at' => now()->addDays(2),
        'duration_minutes' => 60,
        'status' => 'pending',
    ];

    $this->post(route('appointments.store'), $appointmentData)
        ->assertRedirect(route('appointments.index'));

    $this->assertDatabaseHas('appointments', [
        'customer_id' => $customer->id,
        'employee_id' => $employee->id,
    ]);
});

it('can view a specific appointment', function () {
    $appointment = Appointment::factory()->create();

    $this->get(route('appointments.show', $appointment))
        ->assertStatus(200)
        // Assert that the formatted date string is present in the response
        ->assertSee($appointment->scheduled_at->format('Y-m-d H:i'));
});

it('can update an appointment', function () {
    $appointment = Appointment::factory()->create();
    $updatedData = [
        'customer_id' => $appointment->customer_id,
        'employee_id' => $appointment->employee_id,
        'scheduled_at' => $appointment->scheduled_at->format('Y-m-d H:i:s'),
        'duration_minutes' => $appointment->duration_minutes,
        'status' => 'confirmed',
    ];

    $this->put(route('appointments.update', $appointment), $updatedData)
        ->assertRedirect(route('appointments.index'));

    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'status' => 'confirmed',
    ]);
});

it('can delete an appointment', function () {
    $appointment = Appointment::factory()->create();

    $this->delete(route('appointments.destroy', $appointment))
        ->assertRedirect(route('appointments.index'));

    $this->assertDatabaseMissing('appointments', [
        'id' => $appointment->id,
    ]);
});
