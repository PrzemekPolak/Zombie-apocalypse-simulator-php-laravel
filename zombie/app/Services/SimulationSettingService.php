<?php

namespace App\Services;

use App\Http\Requests\StartSimulationRequest;
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
        $humansNumber = $request->humanNumber;
        Human::factory()->count($humansNumber)->create();
        Zombie::factory()->count($request->zombieNumber)->create();
        DB::table('resources')->insert([
            'type' => 'health',
            'quantity' => $humansNumber * 1,
        ]);
        DB::table('resources')->insert([
            'type' => 'food',
            'quantity' => $humansNumber * 10,
        ]);
        DB::table('resources')->insert([
            'type' => 'weapon',
            'quantity' => $humansNumber * 1,
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
//            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('human_bites')->truncate();
        DB::table('human_injuries')->truncate();
        DB::table('zombies')->truncate();
        DB::table('humans')->truncate();
        DB::table('resources')->truncate();
        DB::table('simulation_turns')->truncate();
//            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return response()->json(['message' => 'ok'], 200);
    }

    public function prepareRulesForFrontend()
    {
        $rules = [];
        $rulesFromRequest = (new StartSimulationRequest())->rules();
        foreach ($rulesFromRequest as $key => $value) {
            $rules[$key] = explode('|', str_replace('required|', '', $value));
            $rules[$key][0] = (int)str_replace('min:', '', $rules[$key][0]);
            $rules[$key][1] = (int)str_replace('max:', '', $rules[$key][1]);
        }
        return $rules;
    }

}
