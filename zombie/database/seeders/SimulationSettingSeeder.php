<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'description' => 'Szansa, że dojdzie do walki z zombie',
        ]);
        DB::table('simulation_settings')->insert([
            'event' => 'chanceForBite',
            'chance' => 40,
            'description' => 'Podstawowa szansa, że człowiek zostanie ugryziony przez zombie podczas walki',
        ]);
        DB::table('simulation_settings')->insert([
            'event' => 'injuryChance',
            'chance' => 1,
            'description' => 'Szansa na przypadkowe zranienie się przez człowieka',
        ]);
        DB::table('simulation_settings')->insert([
            'event' => 'immuneChance',
            'chance' => 10,
            'description' => 'Szansa że człowiek nie zostanie zarażony w przypadku ugryzienia',
        ]);
    }
}
