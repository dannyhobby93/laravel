<?php

namespace Database\Factories;

use App\Models\UuidOnly;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UuidOnly>
 */
class UuidOnlyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
