<?php

namespace App\Http\Controllers;

use App\Models\SimulationSetting;
use App\Models\SimulationTurn;
use App\Services\SimulationSettingService;
use Database\Seeders\HumanSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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
        $turn = new SimulationTurn();
        $turn->status = 'active';
        $turn->save();

        return response()->redirectTo('/dashboard');
    }

    public function index(Request $request)
    {
        $settings = SimulationSetting::all();
        return view('simulation.settings', ['settings' => $settings]);
    }
}
