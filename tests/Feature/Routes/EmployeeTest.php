<?php

use App\Models\Employee;
use App\Models\User;

it('can view a list of employees', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    Employee::factory()->count(2)->create();

    $this->get(route('employees.index'))
        ->assertStatus(200)
        ->assertSee('Mitarbeiterliste');
});

it('can create an employee', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $employeeData = Employee::factory()->make()->toArray();

    $this->post(route('employees.store'), $employeeData)
        ->assertRedirect(route('employees.index'));

    $this->assertDatabaseHas('employees', [
        'email' => $employeeData['email'],
    ]);
});

it('can view a specific employee', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $employee = Employee::factory()->create();

    $this->get(route('employees.show', $employee))
        ->assertStatus(200)
        ->assertSee($employee->name);
});

it('can update an employee', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $employee = Employee::factory()->create();
    $updatedData = [
        'name' => 'Neuer Mitarbeitername',
        'email' => 'neuer.mitarbeiter@example.com',
    ];

    $this->put(route('employees.update', $employee), $updatedData)
        ->assertRedirect(route('employees.index'));

    $this->assertDatabaseHas('employees', [
        'id' => $employee->id,
        'email' => 'neuer.mitarbeiter@example.com',
    ]);
});

it('can delete an employee', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $employee = Employee::factory()->create();

    $this->delete(route('employees.destroy', $employee))
        ->assertRedirect(route('employees.index'));

    $this->assertDatabaseMissing('employees', [
        'id' => $employee->id,
    ]);
});
