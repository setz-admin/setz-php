<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Rufe die Seeder in der richtigen Reihenfolge auf.
        $this->call([
            CustomerSeeder::class,
            EmployeeSeeder::class,
            AppointmentSeeder::class,
            // Services, Invoices, etc. können durch die Factories in den anderen Seedern erstellt werden.
        ]);
    }
}
