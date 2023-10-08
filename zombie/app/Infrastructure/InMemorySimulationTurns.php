<?php

namespace App\Infrastructure;

use App\Application\SimulationTurns;
use App\Domain\SimulationTurn;

class InMemorySimulationTurns implements SimulationTurns
{
    /** @var SimulationTurn[] $simulationTurns */
    private array $simulationTurns = [];

    public function currentTurn(): int
    {
        return end($this->simulationTurns)->turnNumber;
    }

    public function createNewTurn(string $status = 'active'): void
    {
        $this->simulationTurns[] = new SimulationTurn(
            count($this->simulationTurns) + 1,
            $status,
        );
    }

    public function add(SimulationTurn $simulationTurn): void
    {
        $this->simulationTurns[] = $simulationTurn;
    }
}
