<?php

namespace App\Services;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\SimulationRunningService;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Models\Human;
use App\Models\HumanBite;
use App\Models\HumanInjury;
use App\Models\Resource;
use App\Models\SimulationTurn;
use App\Models\Zombie;

class SimulationTurnService
{
    public function __construct(
        private readonly Humans                   $humans,
        private readonly Resources                $resources,
        private readonly SimulationTurns          $simulationTurns,
        private readonly SimulationSettings       $simulationSettings,
        private readonly HumanInjuries            $humanInjuries,
        private readonly HumanBites               $humanBites,
        private readonly Zombies                  $zombies,
        private readonly ProbabilityService       $probabilityService,
        private readonly SimulationRunningService $simulationRunningService,
    )
    {
    }

    public function conductTurn(): void
    {
        $this->simulationRunningService->runSimulation();
    }

    /**
     * Checks different rules for simulation to end. If all are false then returns false.
     * If some condition is met, returns string with information about it
     * @return bool|string
     */
    public function checkIfSimulationShouldEnd(): bool|string
    {
        $endReason = false;
        if (Human::alive()->count() <= 0) {
            $endReason = 'Ludzie wygineli';
        } else if (Zombie::stillWalking()->count() <= 0) {
            $endReason = 'Zombie wygineły';
        } else if (Resource::where('type', 'food')->first()->quantity <= 0) {
            $endReason = 'Jedzenie się skończyło';
        } else if (SimulationTurn::all()->sortByDesc('id')->first()->id >= 20) {
            $endReason = 'Wynaleziono szczepionkę';
        }
        return $endReason;
    }

    public function getFrontendDataForDashboard(): array
    {
        return [
            ['label' => 'Obecna tura', 'value' => $this->simulationTurns->currentTurn(), 'icon' => 'clock-solid.svg'],
            ['label' => 'Żywi ludzie', 'value' => Human::alive()->count(), 'icon' => 'person-solid.svg'],
            ['label' => 'Zombie', 'value' => Zombie::stillWalking()->count(), 'icon' => 'biohazard-solid.svg'],
            ['label' => 'Jedzenie', 'value' => Resource::where('type', 'food')->first()->quantity, 'icon' => 'utensils-solid.svg'],
            ['label' => 'Lekarstwa', 'value' => Resource::where('type', 'health')->first()->quantity, 'icon' => 'briefcase-medical-solid.svg'],
            ['label' => 'Broń', 'value' => Resource::where('type', 'weapon')->first()->quantity, 'icon' => 'gun-solid.svg'],
        ];
    }

    public function getSimulationEndStatistics(): array
    {
        return [
            'turns' => SimulationTurn::all()->count(),
            'reasonForEnding' => $this->checkIfSimulationShouldEnd(),
            'zombieNumber' => Zombie::stillWalking()->count(),
            'deadZombies' => Zombie::where('health', 'dead')->count(),
            'humanNumber' => Human::alive()->count(),
            'deadHumans' => Human::where('health', 'dead')->count(),
            'turnedHumans' => Human::where('health', 'turned')->count(),
            'allBites' => HumanBite::all()->count(),
            'allInjuries' => HumanInjury::all()->count(),
        ];
    }
}
