<?php

namespace App\Application;

use App\Domain\SimulationTurn;

interface SimulationTurns
{
    public function currentTurn(): int;

    public function createNewTurn(string $status = 'active'): void;

    public function add(SimulationTurn $simulationTurn): void;

    /** @param SimulationTurn[] $simulationTurns */
    public function save(array $simulationTurns): void;

    /** @return SimulationTurn[] */
    public function all(): array;
}
