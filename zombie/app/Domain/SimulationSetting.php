<?php

namespace App\Domain;

class SimulationSetting
{
    public function __construct(
        public readonly string $event,
        public readonly int    $chance,
        public readonly string $description,
    )
    {
    }

    public static function fromArray(array $simulationSetting): self
    {
        return new self(
            $simulationSetting['event'],
            $simulationSetting['chance'],
            $simulationSetting['description'],
        );
    }
}
