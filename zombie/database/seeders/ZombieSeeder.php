<?php

namespace Database\Seeders;

use App\Models\Zombie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZombieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Zombie::factory()->count(100)->create();
    }
}
