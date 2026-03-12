<?php

namespace Database\Factories;

use App\Models\UuidItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UuidItem>
 */
class UuidItemFactory extends Factory
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
