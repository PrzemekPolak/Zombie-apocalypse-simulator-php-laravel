<?php

namespace App\Http\Controllers;

use App\Models\Human;
use App\Models\Resource;
use App\Models\SimulationTurn;
use App\Models\Zombie;
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

        if ($this->service->checkIfSimulationShouldEnd()) {
            $this->service->endSimulation();
        } else {
            $this->service->nextTurn();
        }

        return response()->redirectTo('/dashboard');
    }

    public function index(Request $request)
    {
        return view('simulation.dashboard', ['currentTurn' => SimulationTurn::latest()->first()->id,
            'humansNumber' => Human::alive()->count(),
            'zombieNumber' => Zombie::stillWalking()->count(), 'resources' => Resource::all()]);
    }
}
