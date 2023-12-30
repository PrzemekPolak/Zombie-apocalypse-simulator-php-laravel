<?php

namespace App\Application;

use App\Domain\SimulationTurn;

interface SimulationTurns
{
    public function currentTurn(): int;

    public function createNewTurn(string $status = 'active'): void;

    /** @param SimulationTurn[] $simulationTurns */
    public function save(array $simulationTurns): void;

    /** @return SimulationTurn[] */
    public function all(): array;

    public function removeAll(): void;
}
