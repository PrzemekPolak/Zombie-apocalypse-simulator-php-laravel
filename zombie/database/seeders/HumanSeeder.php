<?php

namespace Database\Seeders;

use App\Models\Human;
use Illuminate\Database\Seeder;

class HumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Human::factory()->count(100)->create();
    }
}
