<?php

namespace App\Http\Controllers;

use App\Models\HumanBite;
use App\Models\SimulationSetting;
use App\Services\SimulationSettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimulationSettingController extends Controller
{

    public function __construct()
    {
        $this->service = new SimulationSettingService();
    }

    public function store(Request $request)
    {
        $this->service->updateAllSettings($request);
        $this->service->populateDbWithInitialData($request);
        $this->service->createFirstTurn();

        return response()->redirectTo('/dashboard');
    }

    public function clearSimulation(Request $request)
    {
        DB::table('human_bites')->truncate();
        DB::table('human_injuries')->truncate();
        DB::table('zombies')->truncate();
        DB::table('humans')->truncate();
        DB::table('resources')->truncate();
        DB::table('simulation_turns')->truncate();

        return response()->redirectTo('/settings');
    }

    public function index(Request $request)
    {
        $settings = SimulationSetting::all();
        return view('simulation.settings', ['settings' => $settings]);
    }
}
