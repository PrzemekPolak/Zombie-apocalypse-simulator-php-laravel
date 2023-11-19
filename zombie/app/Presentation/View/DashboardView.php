<?php

namespace App\Presentation\View;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\SimulationEndingService;
use App\Application\SimulationTurns;
use App\Application\Zombies;

class DashboardView
{
    public function __construct(
        private readonly Humans                  $humans,
        private readonly Resources               $resources,
        private readonly SimulationTurns         $simulationTurns,
        private readonly Zombies                 $zombies,
        private readonly SimulationEndingService $simulationEndingService
    )
    {
    }

    public function create(): array
    {
        return [
            'leftPanelData' => $this->leftPanelData(),
            'simulationStillOngoing' => $this->simulationEndingService->checkIfSimulationShouldEnd() === false,
            'currentTurn' => $this->simulationTurns->currentTurn(),
            'randomHumans' => $this->humans->getRandomHumans(3),
            'randomZombies' => $this->zombies->getRandomZombies(3),
        ];
    }

    private function leftPanelData(): array
    {
        return [
            ['label' => 'Obecna tura', 'value' => $this->simulationTurns->currentTurn(), 'icon' => 'clock-solid.svg'],
            ['label' => 'Żywi ludzie', 'value' => $this->humans->countAlive(), 'icon' => 'person-solid.svg'],
            ['label' => 'Zombie', 'value' => count($this->zombies->stillWalking()), 'icon' => 'biohazard-solid.svg'],
            ['label' => 'Jedzenie', 'value' => $this->resources->getByType('food')->getQuantity(), 'icon' => 'utensils-solid.svg'],
            ['label' => 'Lekarstwa', 'value' => $this->resources->getByType('health')->getQuantity(), 'icon' => 'briefcase-medical-solid.svg'],
            ['label' => 'Broń', 'value' => $this->resources->getByType('weapon')->getQuantity(), 'icon' => 'gun-solid.svg'],
        ];
    }
}
