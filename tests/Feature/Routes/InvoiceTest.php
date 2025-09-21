<?php

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Service;

it('can view a list of invoices', function () {
    Invoice::factory()->count(2)->create();

    $this->get(route('invoices.index'))
        ->assertStatus(200)
        ->assertSee('Rechnungen');
});

it('can create an invoice', function () {
    $customer = Customer::factory()->create();
    $employee = Employee::factory()->create();
    $services = Service::factory()->count(2)->create();

    $invoiceData = [
        'customer_id' => $customer->id,
        'employee_id' => $employee->id,
        'invoice_number' => 'INV-'.time(),
        'issued_at' => now(),
        'total_amount' => 125.50,
        'status' => 'open', // Explicitly add this field
        'services' => $services->pluck('id')->toArray(),
    ];

    $this->post(route('invoices.store'), $invoiceData)
        ->assertRedirect(route('invoices.index'));

    $this->assertDatabaseHas('invoices', [
        'invoice_number' => $invoiceData['invoice_number'],
    ]);

    // Test, ob die Pivot-Tabelle korrekt gefüllt wurde
    foreach ($services as $service) {
        $this->assertDatabaseHas('invoice_service', [
            'invoice_id' => Invoice::where('invoice_number', $invoiceData['invoice_number'])->first()->id,
            'service_id' => $service->id,
        ]);
    }
});

it('can update an invoice', function () {
    $invoice = Invoice::factory()->create();
    $updatedData = [
        'customer_id' => $invoice->customer_id, // Add this line
        'employee_id' => $invoice->employee_id, // Add this line
        'invoice_number' => $invoice->invoice_number, // Add this line
        'issued_at' => $invoice->issued_at->toDateTimeString(), // Add this line
        'status' => 'paid',
        'paid_at' => now()->toDateTimeString(),
    ];

    $this->put(route('invoices.update', $invoice), $updatedData)
        ->assertRedirect(route('invoices.index'));

    $this->assertDatabaseHas('invoices', [
        'id' => $invoice->id,
        'status' => 'paid',
    ]);
});

it('can delete an invoice', function () {
    $invoice = Invoice::factory()->create();

    $this->delete(route('invoices.destroy', $invoice))
        ->assertRedirect(route('invoices.index'));

    $this->assertDatabaseMissing('invoices', [
        'id' => $invoice->id,
    ]);
});
