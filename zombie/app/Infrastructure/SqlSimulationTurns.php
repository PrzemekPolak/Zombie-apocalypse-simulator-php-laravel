<?php

namespace App\Infrastructure;

use App\Application\SimulationTurns;
use App\Models\SimulationTurn;
use App\Domain\SimulationTurn as DomainSimulationTurn;

class SqlSimulationTurns implements SimulationTurns
{
    public function currentTurn(): int
    {
        return SimulationTurn::currentTurn();
    }

    public function createNewTurn(string $status = 'active'): void
    {
        SimulationTurn::createNewTurn();
    }

    public function add(DomainSimulationTurn $simulationTurn): void
    {
        $turn = new SimulationTurn();
        $turn->id = $simulationTurn->turnNumber;
        $turn->status = $simulationTurn->status;
        $turn->save();
    }
}
