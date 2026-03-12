<?php

namespace Database\Factories;

use App\Models\ComboItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComboItem>
 */
class ComboItemFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
        ];
    }
}
