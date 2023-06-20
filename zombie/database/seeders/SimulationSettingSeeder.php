<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SimulationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('simulation_settings')->insert([
            'event' => 'encounterChance',
            'chance' => 20,
        ]);
        DB::table('simulation_settings')->insert([
            'event' => 'chanceForBite',
            'chance' => 40,
        ]);
        DB::table('simulation_settings')->insert([
            'event' => 'injuryChance',
            'chance' => 1,
        ]);
        DB::table('simulation_settings')->insert([
            'event' => 'immuneChance',
            'chance' => 10,
        ]);
    }
}
