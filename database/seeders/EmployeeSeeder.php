<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Fülle die Employees-Tabelle mit Daten.
     */
    public function run(): void
    {
        // Erstelle 10 Mitarbeiter.
        Employee::factory()->count(10)->create();
    }
}
