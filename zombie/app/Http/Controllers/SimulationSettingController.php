<?php

namespace App\Http\Controllers;

use App\Models\SimulationSetting;
use App\Services\SimulationSettingService;
use Illuminate\Http\Request;

class SimulationSettingController extends Controller
{

    public function __construct()
    {
        $this->service = new SimulationSettingService();
    }

    public function store(Request $request)
    {
        $this->service->updateAllSettings($request);
        // TODO: generate initial values in db

        return response()->redirectTo('/dashboard');
    }

    public function index(Request $request)
    {
        $settings = SimulationSetting::all();
        return view('simulation.settings', ['settings' => $settings]);
    }
}
