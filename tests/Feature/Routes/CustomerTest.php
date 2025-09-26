<?php

use App\Models\Customer;
use App\Models\User;

// Erstelle einen Testbenutzer, um die Authentifizierung zu simulieren, falls benötigt.
// Für diesen Test wird das nicht verwendet, ist aber eine gute Praxis für gesicherte Routen.
// User::factory()->create();

it('can view a list of customers', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    Customer::factory()->count(3)->create();

    $this->get(route('customers.index'))
        ->assertStatus(200)
        ->assertSee('Neuen Kunden erstellen'); // Ersetzen Sie dies mit dem tatsächlichen Text auf der Seite
});

it('can view the create customer page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $this->get(route('customers.create'))
        ->assertStatus(200);
});

it('can create a customer', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $customerData = Customer::factory()->make()->toArray();

    $this->post(route('customers.store'), $customerData)
        ->assertRedirect(route('customers.index'));

    $this->assertDatabaseHas('customers', [
        'email' => $customerData['email'],
    ]);
});

it('can view a specific customer', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $customer = Customer::factory()->create();

    $this->get(route('customers.show', $customer))
        ->assertStatus(200)
        ->assertSee($customer->name);
});

it('can update a customer', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $customer = Customer::factory()->create();
    $updatedData = [
        'name' => 'Neuer Name',
        'email' => 'neue.email@example.com',
    ];

    $this->put(route('customers.update', $customer), $updatedData)
        ->assertRedirect(route('customers.index'));

    $this->assertDatabaseHas('customers', [
        'id' => $customer->id,
        'email' => 'neue.email@example.com',
    ]);
});

it('can delete a customer', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $customer = Customer::factory()->create();

    $this->delete(route('customers.destroy', $customer))
        ->assertRedirect(route('customers.index'));

    $this->assertDatabaseMissing('customers', [
        'id' => $customer->id,
    ]);
});
