<?php

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;

it('can create a customer', function () {
    $customer = Customer::factory()->create();

    $this->assertDatabaseHas('customers', ['id' => $customer->id]);
});

it('can retrieve a customer', function () {
    $customer = Customer::factory()->create();
    $retrievedCustomer = Customer::find($customer->id);

    expect($retrievedCustomer)->not->toBeNull();
    expect($retrievedCustomer->id)->toBe($customer->id);
});

it('can update a customer', function () {
    $customer = Customer::factory()->create();
    $customer->update(['name' => 'Jane Doe']);

    expect($customer->refresh()->name)->toBe('Jane Doe');
    $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Jane Doe']);
});

it('can delete a customer', function () {
    $customer = Customer::factory()->create();
    $customer->delete();

    $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
});

it('has many appointments', function () {
    $customer = Customer::factory()
        ->has(Appointment::factory()->count(3))
        ->create();

    expect($customer->appointments)->toHaveCount(3);
    expect($customer->appointments->first())->toBeInstanceOf(Appointment::class);
});

it('has many invoices', function () {
    $customer = Customer::factory()
        ->has(Invoice::factory()->count(2))
        ->create();

    expect($customer->invoices)->toHaveCount(2);
    expect($customer->invoices->first())->toBeInstanceOf(Invoice::class);
});
