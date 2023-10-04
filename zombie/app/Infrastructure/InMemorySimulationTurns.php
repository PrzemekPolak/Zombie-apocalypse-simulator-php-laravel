<?php

namespace App\Infrastructure;

use App\Application\SimulationTurns;

class InMemorySimulationTurns implements SimulationTurns
{

    public function currentTurn(): int
    {
        return 1;
    }
}
