<?php

namespace App\Application;

interface SimulationTurns
{
    public function currentTurn(): int;
}
