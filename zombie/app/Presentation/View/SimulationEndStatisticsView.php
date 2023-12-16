<?php

namespace App\Presentation\View;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Service\SimulationEndingService;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Domain\Enum\HealthStatus;

class SimulationEndStatisticsView
{
    public function __construct(
        private readonly Humans                  $humans,
        private readonly SimulationTurns         $simulationTurns,
        private readonly HumanInjuries           $humanInjuries,
        private readonly HumanBites              $humanBites,
        private readonly Zombies                 $zombies,
        private readonly SimulationEndingService $simulationEndingService
    )
    {
    }

    public function create(): array
    {
        return [
            'turns' => count($this->simulationTurns->all()),
            'reasonForEnding' => implode(' ', $this->simulationEndingService->getReasonsWhySimulationIsFinished()),
            'zombieNumber' => count($this->zombies->stillWalking()),
            'deadZombies' => count($this->zombies->all()) - count($this->zombies->stillWalking()),
            'humanNumber' => $this->humans->countAlive(),
            'deadHumans' => count($this->humans->allWithHealth(HealthStatus::Dead)),
            'turnedHumans' => count($this->humans->allWithHealth(HealthStatus::Turned)),
            'allBites' => count($this->humanBites->all()),
            'allInjuries' => count($this->humanInjuries->all()),
        ];
    }
}
