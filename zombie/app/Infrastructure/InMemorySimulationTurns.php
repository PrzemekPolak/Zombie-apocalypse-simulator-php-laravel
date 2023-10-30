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
        $newTurnNumber = count($this->simulationTurns) + 1;

        $this->simulationTurns[$newTurnNumber] = new SimulationTurn(
            $newTurnNumber,
            $status,
        );
    }

    public function add(SimulationTurn $simulationTurn): void
    {
        $this->simulationTurns[$simulationTurn->turnNumber] = $simulationTurn;
    }

    public function save(array $simulationTurns): void
    {
        foreach ($simulationTurns as $simulationTurn) {
            $this->simulationTurns[$simulationTurn->turnNumber] = $simulationTurn;
        }
    }

    public function all(): array
    {
        return $this->simulationTurns;
    }
}
