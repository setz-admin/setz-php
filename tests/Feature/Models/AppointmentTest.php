<?php

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an appointment', function () {
    $appointment = Appointment::factory()->create();

    $this->assertDatabaseHas('appointments', ['id' => $appointment->id]);
});

it('can retrieve an appointment', function () {
    $appointment = Appointment::factory()->create();
    $retrievedAppointment = Appointment::find($appointment->id);

    expect($retrievedAppointment)->not->toBeNull();
    expect($retrievedAppointment->id)->toBe($appointment->id);
});

it('can update an appointment', function () {
    $appointment = Appointment::factory()->create();
    $appointment->update(['status' => 'completed']);

    expect($appointment->refresh()->status)->toBe('completed');
    $this->assertDatabaseHas('appointments', ['id' => $appointment->id, 'status' => 'completed']);
});

it('can delete an appointment', function () {
    $appointment = Appointment::factory()->create();
    $appointment->delete();

    $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
});

it('belongs to a customer', function () {
    $customer = Customer::factory()->create();
    $appointment = Appointment::factory()->for($customer)->create();

    expect($appointment->customer)->not->toBeNull();
    expect($appointment->customer->is($customer))->toBeTrue();
});

it('belongs to an employee', function () {
    $employee = Employee::factory()->create();
    $appointment = Appointment::factory()->for($employee)->create();

    expect($appointment->employee)->not->toBeNull();
    expect($appointment->employee->is($employee))->toBeTrue();
});

it('has many services', function () {
    $appointment = Appointment::factory()
        ->has(Service::factory()->count(2))
        ->create();

    expect($appointment->services)->toHaveCount(2);
    expect($appointment->services->first())->toBeInstanceOf(Service::class);
});
