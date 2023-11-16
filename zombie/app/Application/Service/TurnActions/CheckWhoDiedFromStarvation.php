<?php

namespace App\Application\Service\TurnActions;

use App\Application\Humans;
use App\Application\Service\TurnAction;
use App\Application\SimulationTurns;

class CheckWhoDiedFromStarvation implements TurnAction
{
    public function __construct(
        private readonly Humans          $humans,
        private readonly SimulationTurns $simulationTurns,
    )
    {
    }

    public function execute(): void
    {
        $humans = $this->humans->whoLastAteAt($this->simulationTurns->currentTurn() - 3);

        foreach ($humans as $human) {
            if ($human->isAlive()) {
                $human->die('starvation');
            }
        }
    }
}
