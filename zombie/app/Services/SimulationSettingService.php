<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SimulationSettingService
{
    public function clearSimulationTables(): void
    {
        DB::table('human_bites')->truncate();
        DB::table('human_injuries')->truncate();
        DB::table('zombies')->truncate();
        DB::table('humans')->truncate();
        DB::table('resources')->truncate();
        DB::table('simulation_turns')->truncate();
    }
}
