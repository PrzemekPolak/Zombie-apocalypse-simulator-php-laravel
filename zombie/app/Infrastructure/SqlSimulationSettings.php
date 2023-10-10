<?php

namespace App\Infrastructure;

use App\Application\SimulationSettings;
use App\Domain\SimulationSetting;
use App\Models\SimulationSetting as ModelSimulationSetting;

class SqlSimulationSettings implements SimulationSettings
{

    public function getEventChance(string $eventName): int
    {
        return ModelSimulationSetting::getEventChance($eventName);
    }

    public function add(SimulationSetting $simulationSetting): void
    {
        throw new \Exception('Not implemented!');
    }
}
