<?php

namespace App\Application;

use App\Domain\SimulationSetting;

interface SimulationSettings
{
    public function getEventChance(string $eventName): int;

    public function add(SimulationSetting $simulationSetting): void;

    /** @param SimulationSetting[] $simulationSettings */
    public function save(array $simulationSettings): void;

    /** @return SimulationSetting[] */
    public function all(): array;
}
