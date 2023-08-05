<?php

namespace App\Http\Controllers;

use App\Models\Human;
use App\Models\SimulationTurn;
use App\Models\Zombie;
use App\Services\SimulationTurnService;

class SimulationTurnController extends Controller
{
    public function __construct()
    {
        $this->service = new SimulationTurnService();
    }

    public function store()
    {
        $this->service->conductTurn();
        if ($this->service->checkIfSimulationShouldEnd()) {
            return view('simulation.end', $this->service->getSimulationEndStatistics());
        } else {
            SimulationTurn::createNewTurn();
            return response()->redirectTo('/dashboard');
        }

    }

    public function runWholeSimulationOnServer()
    {
        while ($this->service->checkIfSimulationShouldEnd() === false) {
            $this->service->conductTurn();
            SimulationTurn::createNewTurn();
        }
        return view('simulation.end', $this->service->getSimulationEndStatistics());
    }

    public function getStatisticsView()
    {
        return view('simulation.end', $this->service->getSimulationEndStatistics());
    }

    public function index()
    {
        $leftPanelData = $this->service->getFrontendDataForDashboard();
        return view('simulation.dashboard',
            [
                'leftPanelData' => $leftPanelData,
                'simulationStillOngoing' => $this->service->checkIfSimulationShouldEnd() === false,
                'currentTurn' => SimulationTurn::currentTurn(),
                'randomHumans' => Human::alive()->inRandomOrder()->limit(3)->get(),
                'randomZombies' => Zombie::stillWalking()->inRandomOrder()->limit(3)->get()
            ]);
    }
}
