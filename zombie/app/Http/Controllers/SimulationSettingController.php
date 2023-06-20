<?php

namespace App\Http\Controllers;

use App\Models\SimulationSetting;
use Illuminate\Http\Request;

class SimulationSettingController extends Controller
{
    public function store(Request $request)
    {
        // TODO: use request and save received settings
    }

    public function index(Request $request)
    {
        $settings = SimulationSetting::all();
        return view('simulation.settings', ['settings' => $settings]);
    }
}
