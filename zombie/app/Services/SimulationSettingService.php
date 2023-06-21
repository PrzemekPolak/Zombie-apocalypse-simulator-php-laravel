<?php

namespace App\Services;

use App\Models\SimulationSetting;


class SimulationSettingService
{

    public function updateAllSettings($request): string
    {
        $events = SimulationSetting::all()->pluck('event')->toArray();
        foreach ($events as $event) {
            SimulationSetting::where('event', $event)->update(['chance' => $request->input($event)]);
        }
        return response()->json(['message' => 'ok'], 200);
    }

}
