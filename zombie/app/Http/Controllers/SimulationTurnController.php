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
        $leftPanelData = [
            ['label' => 'Obecna tura', 'value' => SimulationTurn::latest()->first()->id, 'icon' => 'clock-solid.svg'],
            ['label' => 'Żywi ludzie', 'value' => Human::alive()->count(), 'icon' => 'person-solid.svg'],
            ['label' => 'Zombie', 'value' => Zombie::stillWalking()->count(), 'icon' => 'biohazard-solid.svg'],
            ['label' => 'Jedzenie', 'value' => Resource::where('type', 'food')->first()->quantity, 'icon' => 'utensils-solid.svg'],
            ['label' => 'Lekarstwa', 'value' => Resource::where('type', 'health')->first()->quantity, 'icon' => 'briefcase-medical-solid.svg'],
            ['label' => 'Broń', 'value' => Resource::where('type', 'weapon')->first()->quantity, 'icon' => 'gun-solid.svg'],
        ];
        return view('simulation.dashboard', ['leftPanelData' => $leftPanelData,
            'randomHumans' => Human::alive()->inRandomOrder()->limit(3)->get(),
            'randomZombies' => Zombie::stillWalking()->inRandomOrder()->limit(3)->get()]);
    }
}
