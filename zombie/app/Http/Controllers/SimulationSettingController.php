<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartSimulationRequest;
use App\Models\SimulationSetting;
use App\Models\SimulationTurn;
use App\Services\SimulationSettingService;
use Illuminate\Http\Request;

class SimulationSettingController extends Controller
{

    public function __construct()
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
            return (new SimulationTurnController())->runWholeSimulationOnServer();
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
