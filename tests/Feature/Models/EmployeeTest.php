<?php

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Invoice;

it('can create an employee', function () {
    $employee = Employee::factory()->create();

    $this->assertDatabaseHas('employees', ['id' => $employee->id]);
});

it('can retrieve an employee', function () {
    $employee = Employee::factory()->create();
    $retrievedEmployee = Employee::find($employee->id);

    expect($retrievedEmployee)->not->toBeNull();
    expect($retrievedEmployee->id)->toBe($employee->id);
});

it('can update an employee', function () {
    $employee = Employee::factory()->create();
    $employee->update(['name' => 'John Doe']);

    expect($employee->refresh()->name)->toBe('John Doe');
    $this->assertDatabaseHas('employees', ['id' => $employee->id, 'name' => 'John Doe']);
});

it('can delete an employee', function () {
    $employee = Employee::factory()->create();
    $employee->delete();

    $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
});

it('has many appointments', function () {
    $employee = Employee::factory()
        ->has(Appointment::factory()->count(5))
        ->create();

    expect($employee->appointments)->toHaveCount(5);
    expect($employee->appointments->first())->toBeInstanceOf(Appointment::class);
});

it('has many invoices', function () {
    $employee = Employee::factory()
        ->has(Invoice::factory()->count(4))
        ->create();

    expect($employee->invoices)->toHaveCount(4);
    expect($employee->invoices->first())->toBeInstanceOf(Invoice::class);
});
