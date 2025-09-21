<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Fülle die Customers-Tabelle mit Daten.
     */
    public function run(): void
    {
        // Erstelle 100 Kunden.
        Customer::factory()->count(100)->create();
    }
}
