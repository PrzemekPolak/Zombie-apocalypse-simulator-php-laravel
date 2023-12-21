<?php

namespace App\Presentation\View;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\SimulationEndingService;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Domain\Enum\ResourceType;
use App\Domain\Human;
use App\Domain\Zombie;

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
        $currentTurn = $this->simulationTurns->currentTurn();

        return [
            'leftPanelData' => $this->leftPanelData(),
            'simulationStillOngoing' => $this->simulationEndingService->checkIfSimulationShouldEnd() === false,
            'currentTurn' => $this->simulationTurns->currentTurn(),
            'randomHumans' => array_map(
                static fn(Human $human) => HumanView::fromDto($human, $currentTurn),
                $this->humans->getRandomHumans(3)
            ),
            'randomZombies' => array_map(
                static fn(Zombie $zombie) => ZombieView::fromDto($zombie),
                $this->zombies->getNumberOfRandomStillWalkingZombies(3)
            ),
        ];
    }

    private function leftPanelData(): array
    {
        return [
            ['label' => 'Obecna tura', 'value' => $this->simulationTurns->currentTurn(), 'icon' => 'clock-solid.svg'],
            ['label' => 'Żywi ludzie', 'value' => count($this->humans->allAlive()), 'icon' => 'person-solid.svg'],
            ['label' => 'Zombie', 'value' => count($this->zombies->stillWalking()), 'icon' => 'biohazard-solid.svg'],
            ['label' => 'Jedzenie', 'value' => $this->resources->getByType(ResourceType::Food)->getQuantity(), 'icon' => 'utensils-solid.svg'],
            ['label' => 'Lekarstwa', 'value' => $this->resources->getByType(ResourceType::Health)->getQuantity(), 'icon' => 'briefcase-medical-solid.svg'],
            ['label' => 'Broń', 'value' => $this->resources->getByType(ResourceType::Weapon)->getQuantity(), 'icon' => 'gun-solid.svg'],
        ];
    }
}
