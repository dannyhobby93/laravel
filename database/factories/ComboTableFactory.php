<?php

namespace Database\Factories;

use App\Models\ComboTable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComboTable>
 */
class ComboTableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
