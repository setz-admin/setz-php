<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Eloquent factory relationships automatically create the models.
            'customer_id' => Customer::factory(),
            'employee_id' => Employee::factory(),
            'scheduled_at' => fake()->dateTimeBetween('now', '+1 month'),
            'duration_minutes' => fake()->numberBetween(30, 120),
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed']),
            'notes' => fake()->sentence(),
        ];
    }
}
