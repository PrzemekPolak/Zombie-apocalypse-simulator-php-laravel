<?php

namespace App\Http\Controllers;

use App\Services\SimulationTurnService;
use Illuminate\Http\Request;

class SimulationTurnController extends Controller
{
    public function __construct()
    {
        $this->service = new SimulationTurnService();
    }

    public function store(Request $request)
    {
        $this->service->generateResources();
        $this->service->humansEatFood();
        $this->service->checkWhoDiedFromStarvation();
        $this->service->healHumanInjuries();
        $this->service->checkWhoBleedOut();
        $this->service->checkWhoTurnIntoZombie();
        $this->service->zombieEncounters();
        $this->service->humanNonBiteInjuries();

        // TODO: Add conditions for simulation to end
        if (true) {
            $this->service->nextTurn();
        } else {
            $this->service->endSimulation();
        }
    }

    public function index(Request $request)
    {
        return view('simulation.dashboard');
    }
}
