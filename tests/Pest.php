<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;

use App\Models\Service;
use function Pest\Expectation;


uses(TestCase::class, RefreshDatabase::class)->in('Feature');
uses(RefreshDatabase::class)->in('Unit');

/**
 * Add checks for toBe assertion.
 */
expect()->pipe('toBe', function (Closure $next, mixed $expected) {

    // compare against a carbon object
    if ($this->value instanceof Carbon) {
        return expect($this->value->toDateTimeString())
            ->toBe(Carbon::parse($expected)->toDateTimeString());
    }

    // compare against a model
    if ($this->value instanceof Model) {
        return expect($this->value->is($expected))
            ->toBe(true);
    }

    return $next();
});

/**
 * Check for a list of array attributes.
 */
expect()->extend('toHaveAttributes', function (array $attributes) {
    foreach ($attributes as $key => $value) {
        expect($this->value->$key)
            ->toBe($value)
            ->not->toBeNull($key);
    }
});

/**
 * Erstellt einen Kunden, Mitarbeiter und Termin.
 * Begründung: Anstatt in jedem Test, der einen Termin mit Beziehungen
 * benötigt, denselben Boilerplate-Code zu schreiben, rufen Sie einfach
 * die Funktion createAppointmentWithRelations() auf. Dies reduziert
 * Redundanz und macht die Tests leichter lesbar.
 */
function createAppointmentWithRelations(): Appointment
{
    $customer = Customer::factory()->create();
    $employee = Employee::factory()->create();

    return Appointment::factory()->for($customer)->for($employee)->create();
}


/*
* Begründung: Diese benutzerdefinierten Assertions machen Tests
*  extrem ausdrucksstark und selbstdokumentierend. Anstelle von
* expect($service->payment_status)->toBe('paid'), können Sie
* expect($service)->toHavePaymentStatusPaid() schreiben. Dies
* verbessert die Lesbarkeit erheblich und fasst die Geschäftslogik
* in den Tests zusammen.
*/
/**
 * Überprüft, ob der Zahlungsstatus der Dienstleistung "offen" ist.
 */
expect()->extend('toHavePaymentStatusOpen', function () {
    /** @var Expectation $this */
    return $this->toHaveKey('payment_status', 'open');
});

/**
 * Überprüft, ob eine Liste von Dienstleistungen vollständig bezahlt ist.
 */
expect()->extend('allBePaid', function () {
    foreach ($this->value as $service) {
        expect($service)->toHavePaymentStatusPaid();
    }
});

/**
 * Überprüft, ob der Zahlungsstatus "bezahlt" ist.
 */
expect()->extend('toHavePaymentStatusPaid', function () {
    /** @var Expectation $this */
    return $this->toHaveKey('payment_status', 'paid');
});
