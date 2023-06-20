<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimulationSettingController extends Controller
{
    public function store(Request $request)
    {
        // TODO: use request and save received settings
    }

    public function index(Request $request)
    {
        return view('simulation.settings');
    }
}
