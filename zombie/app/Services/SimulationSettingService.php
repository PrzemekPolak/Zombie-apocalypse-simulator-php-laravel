<?php

namespace App\Services;

use App\Models\Human;
use App\Models\SimulationSetting;
use App\Models\Zombie;
use Illuminate\Http\JsonResponse;


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
        return response()->json(['message' => 'ok'], 200);
    }

}
