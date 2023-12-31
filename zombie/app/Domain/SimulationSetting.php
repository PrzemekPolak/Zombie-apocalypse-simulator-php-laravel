<?php

namespace App\Domain;

use App\Domain\Enum\SimulationSettingName;

class SimulationSetting
{
    public function __construct(
        public readonly SimulationSettingName $event,
        public readonly int                   $chance,
        public readonly string                $description,
    )
    {
    }

    public static function fromArray(array $simulationSetting): self
    {
        return new self(
            SimulationSettingName::from($simulationSetting['event']),
            $simulationSetting['chance'],
            $simulationSetting['description'],
        );
    }
}
