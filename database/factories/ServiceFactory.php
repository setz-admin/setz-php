<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::factory(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 50, 500),
            'payment_status' => 'open', // Default status for new services
            'invoiced_at' => null, // Initially null
        ];
    }
}
