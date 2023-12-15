<?php

namespace App\Application\Service\TurnActions;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\TurnAction;
use App\Application\SimulationTurns;
use App\Domain\Enum\ResourceType;

class HumansEatFood implements TurnAction
{
    public function __construct(
        private readonly Humans          $humans,
        private readonly Resources       $resources,
        private readonly SimulationTurns $simulationTurns,
    )
    {
    }

    public function execute(): void
    {
        $humans = $this->humans->allAlive();
        $food = $this->resources->getByType(ResourceType::Food);

        for ($i = 0; $i < count($humans); $i++) {
            if ($food->getQuantity() > 0) {
                $food->consume();
                $humans[$i]->ateFood($this->simulationTurns->currentTurn());
            }
        }
    }
}
