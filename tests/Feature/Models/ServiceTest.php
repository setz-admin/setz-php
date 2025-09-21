<?php

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\User;

it('can create a service', function () {
    $service = Service::factory()->create();

    $this->assertDatabaseHas('services', ['id' => $service->id]);
});

it('can retrieve a service', function () {
    $service = Service::factory()->create();
    $retrievedService = Service::find($service->id);

    expect($retrievedService)->not->toBeNull();
    expect($retrievedService->id)->toBe($service->id);
});

it('can update a service', function () {
    $service = Service::factory()->create();
    $service->update(['price' => 250.00]);

    expect($service->refresh()->price)->toBe(250.00);
    $this->assertDatabaseHas('services', ['id' => $service->id, 'price' => 250.00]);
});

it('can delete a service', function () {
    $service = Service::factory()->create();
    $service->delete();

    $this->assertDatabaseMissing('services', ['id' => $service->id]);
});

it('belongs to an appointment', function () {
    $appointment = Appointment::factory()->create();
    $service = Service::factory()->for($appointment)->create();

    expect($service->appointment)->not->toBeNull();
    expect($service->appointment->is($appointment))->toBeTrue();
});

it('can be part of many invoices', function () {
    $service = Service::factory()
        ->has(Invoice::factory()->count(2))
        ->create();

    expect($service->invoices)->toHaveCount(2);
    expect($service->invoices->first())->toBeInstanceOf(Invoice::class);
});

it('has an initial status of "open"', function () {
    $service = Service::factory()->create();

    expect($service)->toHavePaymentStatusOpen();
});
