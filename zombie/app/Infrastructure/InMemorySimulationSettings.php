<?php

namespace App\Infrastructure;

use App\Application\SimulationSettings;
use App\Domain\SimulationSetting;

class InMemorySimulationSettings implements SimulationSettings
{
    /** @var SimulationSetting[] $simulationSettings */
    private array $simulationSettings = [];

    public function getEventChance(string $eventName): int
    {
        foreach ($this->simulationSettings as $simulationSetting) {
            if ($simulationSetting->event === $eventName) {
                return $simulationSetting->chance;
            }
        }
    }

    public function add(SimulationSetting $simulationSetting): void
    {
        $this->simulationSettings[] = $simulationSetting;
    }
}
