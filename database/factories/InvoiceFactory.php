<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'employee_id' => Employee::factory(),
            'invoice_number' => fake()->unique()->randomNumber(6),
            'status' => 'open', // Default status
            'total_amount' => fake()->randomFloat(2, 100, 1000),
            'issued_at' => now(),
            'paid_at' => null,
        ];
    }
}
