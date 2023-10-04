<?php

namespace App\Infrastructure;

use App\Application\SimulationTurns;
use App\Models\SimulationTurn;

class SqlSimulationTurns implements SimulationTurns
{
    public function currentTurn(): int
    {
        return SimulationTurn::currentTurn();
    }
}
