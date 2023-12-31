<?php

namespace App\Infrastructure;

use App\Application\SimulationSettings;
use App\Domain\Enum\SimulationSettingName;
use App\Domain\SimulationSetting;

class InMemorySimulationSettings implements SimulationSettings
{
    /** @var SimulationSetting[] $simulationSettings */
    private array $simulationSettings = [];

    public function getEventChance(SimulationSettingName $eventName): int
    {
        return $this->simulationSettings[$eventName->value]->chance;
    }

    public function save(array $simulationSettings): void
    {
        foreach ($simulationSettings as $simulationSetting) {
            $this->simulationSettings[$simulationSetting->event->value] = $simulationSetting;
        }
    }

    public function all(): array
    {
        return $this->simulationSettings;
    }
}
