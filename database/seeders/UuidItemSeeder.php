<?php

namespace Database\Seeders;

use App\Models\UuidItem;
use Illuminate\Database\Seeder;

class UuidItemSeeder extends Seeder
{
    public function run(): void
    {
        UuidItem::factory(5)->create();
    }
}
