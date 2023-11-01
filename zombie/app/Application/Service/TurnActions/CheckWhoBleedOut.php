<?php

namespace App\Application\Service\TurnActions;

use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Service\TurnAction;
use App\Application\SimulationTurns;

class CheckWhoBleedOut implements TurnAction
{
    public function __construct(
        private readonly Humans          $humans,
        private readonly SimulationTurns $simulationTurns,
        private readonly HumanInjuries   $humanInjuries,
    )
    {
    }

    public function execute(): void
    {
        $humanInjuries = $this->humanInjuries->fromTurn($this->simulationTurns->currentTurn() - 2);

        foreach ($humanInjuries as $humanInjury) {
            $human = $this->humans->find($humanInjury->humanId);
            if ($human->isInjured()) {
                $human->die($humanInjury->injuryCause);
            }
        }
    }
}
