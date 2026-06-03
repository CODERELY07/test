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
            'name'           => $this->faker->name(),
            'description'    => $this->faker->sentence(),
            'model'          => $this->faker->randomElement(['iPhone 15', 'Galaxy S24', 'MacBook Pro', 'iPad Air']),
            'category'       => $this->faker->randomElement(['Screen', 'Battery', 'Water Damage', 'Software']),
            'status'         => $this->faker->randomElement(['pending', 'ongoing', 'completed']),
            'ticket_number'  => 'TKT-' . $this->faker->unique()->numberBetween(100000, 999999),
            'estimated_cost' => $this->faker->randomFloat(2, 50, 500),
            'actual_cost'    => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'      => 'completed',
            'actual_cost' => $this->faker->randomFloat(2, 50, 500),
        ]);
    }
}
