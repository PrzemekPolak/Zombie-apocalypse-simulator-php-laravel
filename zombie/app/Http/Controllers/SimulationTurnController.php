<?php

namespace App\Http\Controllers;

use App\Application\SimulationTurns;
use App\Models\Human;
use App\Models\Zombie;
use App\Services\SimulationTurnService;

class SimulationTurnController extends Controller
{
    public function __construct(
        private readonly SimulationTurnService $service,
        private readonly SimulationTurns       $simulationTurns,
    )
    {
    }

    public function store()
    {
        $this->service->conductTurn();
        if ($this->service->checkIfSimulationShouldEnd()) {
            return view('simulation.end', $this->service->getSimulationEndStatistics());
        } else {
            $this->simulationTurns->createNewTurn();
            return response()->redirectTo('/dashboard');
        }

    }

    public function runWholeSimulationOnServer()
    {
        while ($this->service->checkIfSimulationShouldEnd() === false) {
            $this->service->conductTurn();
            $this->simulationTurns->createNewTurn();
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
                'currentTurn' => $this->simulationTurns->currentTurn(),
                'randomHumans' => Human::alive()->inRandomOrder()->limit(3)->get(),
                'randomZombies' => Zombie::stillWalking()->inRandomOrder()->limit(3)->get()
            ]);
    }
}
