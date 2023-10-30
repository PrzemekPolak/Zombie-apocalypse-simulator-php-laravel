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

    public static function fromArray(array $simulationTurn): self
    {
        return new self(
            $simulationTurn['id'],
            $simulationTurn['status'],
        );
    }
}
