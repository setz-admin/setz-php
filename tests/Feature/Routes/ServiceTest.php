<?php

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;

it('can view a list of services', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    Service::factory()->count(3)->create();

    $this->get(route('services.index'))
        ->assertStatus(200)
        ->assertSee('Dienstleistungen');
});

it('can create a service', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $appointment = Appointment::factory()->create();

    $serviceData = [
        'appointment_id' => $appointment->id,
        'description' => 'Beratungsgespräch',
        'price' => 120.00,
        'payment_status' => 'open',
    ];

    $this->post(route('services.store'), $serviceData)
        ->assertRedirect(route('services.index'));

    $this->assertDatabaseHas('services', [
        'description' => 'Beratungsgespräch',
    ]);
});

it('can update a service', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = Service::factory()->create();
    $updatedData = [
        'appointment_id' => $service->appointment_id,
        'description' => $service->description,
        'price' => $service->price,
        'payment_status' => 'invoiced',
    ];

    $this->put(route('services.update', $service), $updatedData)
        ->assertRedirect(route('services.index'));

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
        'payment_status' => 'invoiced',
    ]);
});

it('can delete a service', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = Service::factory()->create();

    $this->delete(route('services.destroy', $service))
        ->assertRedirect(route('services.index'));

    $this->assertDatabaseMissing('services', [
        'id' => $service->id,
    ]);
});
