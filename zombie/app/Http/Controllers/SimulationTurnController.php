<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartSimulationRequest;
use App\Models\Human;
use App\Models\SimulationTurn;
use App\Models\Zombie;
use App\Services\SimulationSettingService;
use App\Services\SimulationTurnService;

class SimulationTurnController extends Controller
{
    public function __construct()
    {
        $this->service = new SimulationTurnService();
    }

    public function store()
    {
        if ($this->service->checkIfSimulationShouldEnd()) {
            return view('simulation.end', [
                'turns' => SimulationTurn::all()->count(),
            ]);
        } else {
            $this->service->conductTurn();
            $this->service->nextTurn('active');
            return response()->redirectTo('/dashboard');
        }


    }

    public function runWholeSimulationOnServer()
    {
        while ($this->service->checkIfSimulationShouldEnd() === false) {
            $this->service->conductTurn();
            $this->service->nextTurn('active');
        }
        return view('simulation.end', [
            'turns' => SimulationTurn::all()->count(),
        ]);
    }

    public function index()
    {
        $leftPanelData = $this->service->getFrontendDataForDashboard();
        return view('simulation.dashboard',
            [
                'leftPanelData' => $leftPanelData,
                'randomHumans' => Human::alive()->inRandomOrder()->limit(3)->get(),
                'randomZombies' => Zombie::stillWalking()->inRandomOrder()->limit(3)->get()
            ]);
    }
}
