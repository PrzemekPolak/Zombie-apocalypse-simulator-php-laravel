<?php

namespace App\Services;

use App\Models\Human;
use App\Models\Resource;
use App\Models\Zombie;
use Illuminate\Support\Facades\DB;


class SimulationSettingService
{
    public function populateDbWithInitialData($request): void
    {
        $humansNumber = $request->humanNumber;
        Human::factory()->count($humansNumber)->create();
        Zombie::factory()->count($request->zombieNumber)->create();
        Resource::setResourceQuantity('health', $humansNumber * 1);
        Resource::setResourceQuantity('food', $humansNumber * 10);
        Resource::setResourceQuantity('weapon', $humansNumber * 1);
    }

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
