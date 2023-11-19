<?php

namespace App\Http\Controllers;

use App\Application\Service\SimulationRunningService;
use App\Http\Requests\StartSimulationRequest;
use App\Models\SimulationSetting;
use App\Models\SimulationTurn;
use App\Presentation\View\SimulationEndStatisticsView;
use App\Presentation\View\SimulationSettingsView;
use App\Services\SimulationSettingService;
use Illuminate\Http\Request;

class SimulationSettingController extends Controller
{

    public function __construct(
        private readonly SimulationRunningService    $simulationRunningService,
        private readonly SimulationEndStatisticsView $simulationEndStatisticsView,
        private readonly SimulationSettingsView      $simulationSettingsView,
    )
    {
        $this->service = new SimulationSettingService();
    }

    public function store(StartSimulationRequest $request)
    {
        SimulationSetting::updateAllSettings($request);
        // do only if starting a new simulation
        if (!SimulationTurn::simulationIsOngoing()) {
            $this->service->populateDbWithInitialData($request);
            SimulationTurn::createNewTurn();
        }

        if ($request->shouldLoop === 'on') {
            $this->simulationRunningService->runWholeSimulationOnServer();
            return view('simulation.end', $this->simulationEndStatisticsView->create());
        } else {
            return response()->redirectTo('/dashboard');
        }
    }

    public function clearSimulation(Request $request)
    {
        $this->service->clearSimulationTables();
        return response()->redirectTo('/settings');
    }

    public function index(Request $request)
    {
        return view('simulation.settings', $this->simulationSettingsView->create());
    }
}
