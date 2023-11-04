<?php

namespace App\Http\Controllers;

use App\Application\Service\SimulationEndingService;
use App\Application\Service\SimulationRunningService;
use App\Application\SimulationTurns;
use App\Models\Human;
use App\Models\Zombie;
use App\Services\SimulationTurnService;

class SimulationTurnController extends Controller
{
    public function __construct(
        private readonly SimulationTurnService    $service,
        private readonly SimulationTurns          $simulationTurns,
        private readonly SimulationRunningService $simulationRunningService,
        private readonly SimulationEndingService  $simulationEndingService,
    )
    {
    }

    public function store()
    {
        $this->simulationRunningService->runSimulation();
        if ($this->simulationEndingService->checkIfSimulationShouldEnd()) {
            return view('simulation.end', $this->service->getSimulationEndStatistics());
        } else {
            return response()->redirectTo('/dashboard');
        }

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
                'simulationStillOngoing' => $this->simulationEndingService->checkIfSimulationShouldEnd() === false,
                'currentTurn' => $this->simulationTurns->currentTurn(),
                'randomHumans' => Human::alive()->inRandomOrder()->limit(3)->get(),
                'randomZombies' => Zombie::stillWalking()->inRandomOrder()->limit(3)->get()
            ]);
    }
}
