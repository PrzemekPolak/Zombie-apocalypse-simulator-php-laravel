<?php

namespace Database\Factories;

use App\Models\Zombie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Zombie>
 */
class ZombieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(12, 80),
            'profession' => $this->faker->randomElement(['doctor', 'nurse', 'farmer', 'hunter', 'engineer', 'mechanic', 'student', 'programmer']),
            'health' => 'infected',
        ];
    }
}
