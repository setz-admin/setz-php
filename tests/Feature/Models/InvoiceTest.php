<?php

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Service;

it('can create an invoice', function () {
    $invoice = Invoice::factory()->create();

    $this->assertDatabaseHas('invoices', ['id' => $invoice->id]);
});

it('can retrieve an invoice', function () {
    $invoice = Invoice::factory()->create();
    $retrievedInvoice = Invoice::find($invoice->id);

    expect($retrievedInvoice)->not->toBeNull();
    expect($retrievedInvoice->id)->toBe($invoice->id);
});

it('can update an invoice', function () {
    $invoice = Invoice::factory()->create();
    $invoice->update(['status' => 'paid']);

    expect($invoice->refresh()->status)->toBe('paid');
    $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'status' => 'paid']);
});

it('can delete an invoice', function () {
    $invoice = Invoice::factory()->create();
    $invoice->delete();

    $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
});

it('belongs to a customer', function () {
    $customer = Customer::factory()->create();
    $invoice = Invoice::factory()->for($customer)->create();

    expect($invoice->customer)->not->toBeNull();
    expect($invoice->customer->is($customer))->toBeTrue();
});

it('belongs to an employee', function () {
    $employee = Employee::factory()->create();
    $invoice = Invoice::factory()->for($employee)->create();

    expect($invoice->employee)->not->toBeNull();
    expect($invoice->employee->is($employee))->toBeTrue();
});

it('has many services', function () {
    $services = Service::factory()->count(3)->create();
    $invoice = Invoice::factory()->create();
    $invoice->services()->attach($services);

    expect($invoice->services)->toHaveCount(3);
    expect($invoice->services->first())->toBeInstanceOf(Service::class);
});

it('has an initial status of "open"', function () {
    $invoice = Invoice::factory()->create();

    expect($invoice->status)->toBe('open');
});
