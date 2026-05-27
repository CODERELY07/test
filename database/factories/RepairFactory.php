<?php

namespace Database\Factories;

use App\Models\Repair;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Repair>
 */
class RepairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_number' => 'TKT-' . $this->faker->unique()->numberBetween(100000, 999999),
        ];
    }
}
