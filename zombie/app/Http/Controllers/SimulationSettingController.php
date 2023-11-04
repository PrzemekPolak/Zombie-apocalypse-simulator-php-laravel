<?php

namespace App\Http\Controllers;

use App\Application\Service\SimulationRunningService;
use App\Http\Requests\StartSimulationRequest;
use App\Models\SimulationSetting;
use App\Models\SimulationTurn;
use App\Services\SimulationSettingService;
use App\Services\SimulationTurnService;
use Illuminate\Http\Request;

class SimulationSettingController extends Controller
{

    public function __construct(
        private readonly SimulationTurnService    $simulationTurnService,
        private readonly SimulationRunningService $simulationRunningService,
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
            return view('simulation.end', $this->simulationTurnService->getSimulationEndStatistics());
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
        $settings = SimulationSetting::all();
        return view('simulation.settings',
            [
                'settings' => $settings,
                'rules' => $this->service->prepareRulesForFrontend(),
                'simulationOngoing' => SimulationTurn::simulationIsOngoing()
            ]);
    }
}
