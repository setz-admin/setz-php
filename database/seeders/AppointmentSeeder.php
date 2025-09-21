<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Fülle die Appointments-Tabelle mit Daten.
     */
    public function run(): void
    {
        // Erstelle 50 Termine.
        Appointment::factory()->count(50)->create();
    }
}
