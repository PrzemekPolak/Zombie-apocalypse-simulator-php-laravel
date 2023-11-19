<?php

namespace App\Http\Controllers;

use App\Application\Service\SimulationEndingService;
use App\Application\Service\SimulationRunningService;
use App\Presentation\View\DashboardView;
use App\Presentation\View\SimulationEndStatisticsView;

class SimulationTurnController extends Controller
{
    public function __construct(
        private readonly SimulationRunningService    $simulationRunningService,
        private readonly SimulationEndingService     $simulationEndingService,
        private readonly DashboardView               $dashboardView,
        private readonly SimulationEndStatisticsView $simulationEndStatisticsView,
    )
    {
    }

    public function store()
    {
        $this->simulationRunningService->runSimulation();
        if ($this->simulationEndingService->checkIfSimulationShouldEnd()) {
            return view('simulation.end', $this->simulationEndStatisticsView->create());
        } else {
            return response()->redirectTo('/dashboard');
        }

    }

    public function getStatisticsView()
    {
        return view('simulation.end', $this->simulationEndStatisticsView->create());
    }

    public function index()
    {
        return view('simulation.dashboard', $this->dashboardView->create());
    }
}
