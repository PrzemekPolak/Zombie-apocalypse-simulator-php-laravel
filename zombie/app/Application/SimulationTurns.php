<?php

namespace App\Application;

use App\Domain\SimulationTurn;

interface SimulationTurns
{
    public function currentTurn(): int;

    public function createNewTurn(string $status = 'active'): void;

    public function add(SimulationTurn $simulationTurn): void;
}
