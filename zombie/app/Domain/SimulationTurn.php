<?php

namespace App\Domain;

class SimulationTurn
{
    public function __construct(
        public readonly int    $turnNumber,
        public readonly string $status,
    )
    {
    }
}
