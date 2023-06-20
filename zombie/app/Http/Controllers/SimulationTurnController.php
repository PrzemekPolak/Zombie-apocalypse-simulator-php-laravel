<?php

namespace App\Http\Controllers;

use App\Models\SimulationTurn;
use Illuminate\Http\Request;

class SimulationTurnController extends Controller
{
    public function store(Request $request)
    {
        $turn = new SimulationTurn();
        $turn->status = 'active';
        $turn->save();
    }

    public function index(Request $request)
    {
        return view('simulation.dashboard');
    }
}
