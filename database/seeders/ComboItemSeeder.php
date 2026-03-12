<?php

namespace Database\Seeders;

use App\Models\ComboItem;
use Illuminate\Database\Seeder;

class ComboItemSeeder extends Seeder
{
    public function run(): void
    {
        ComboItem::factory(5)->create();
    }
}
