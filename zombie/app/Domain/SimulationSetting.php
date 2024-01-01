<?php

namespace App\Domain;

use App\Domain\Enum\SimulationSettingName;

class SimulationSetting
{
    public function __construct(
        private readonly SimulationSettingName $event,
        private int                            $chance,
        public readonly string                 $description,
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

    public function setNewChance(int $chance): void
    {
        $this->chance = $chance;
    }

    public function settingName(): string
    {
        return $this->event->value;
    }

    public function chance(): int
    {
        return $this->chance;
    }
}
