<?php

namespace App\Services;

use App\Models\Human;
use App\Models\SimulationSetting;
use App\Models\SimulationTurn;
use App\Models\Zombie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class SimulationSettingService
{

    public function updateAllSettings($request): JsonResponse
    {
        $events = SimulationSetting::all()->pluck('event')->toArray();
        foreach ($events as $event) {
            SimulationSetting::where('event', $event)->update(['chance' => $request->input($event)]);
        }
        return response()->json(['message' => 'ok'], 200);
    }

    public function populateDbWithInitialData($request): JsonResponse
    {
        Human::factory()->count($request->input('humanNumber'))->create();
        Zombie::factory()->count($request->input('zombieNumber'))->create();
        DB::table('resources')->insert([
            'type' => 'health',
            'quantity' => 1000,
        ]);
        DB::table('resources')->insert([
            'type' => 'food',
            'quantity' => 5000,
        ]);
        DB::table('resources')->insert([
            'type' => 'weapon',
            'quantity' => 500,
        ]);
        return response()->json(['message' => 'ok'], 200);
    }

    public function createFirstTurn(): JsonResponse
    {
        $turn = new SimulationTurn();
        $turn->status = 'active';
        $turn->save();
        return response()->json(['message' => 'ok'], 200);
    }

    public function clearSimulationTables(): JsonResponse
    {
        DB::table('human_bites')->truncate();
        DB::table('human_injuries')->truncate();
        DB::table('zombies')->truncate();
        DB::table('humans')->truncate();
        DB::table('resources')->truncate();
        DB::table('simulation_turns')->truncate();

        return response()->json(['message' => 'ok'], 200);
    }

}
