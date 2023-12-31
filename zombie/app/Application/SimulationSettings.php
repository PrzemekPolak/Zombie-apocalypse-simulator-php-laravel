<?php

namespace App\Application;

use App\Domain\Enum\SimulationSettingName;
use App\Domain\SimulationSetting;

interface SimulationSettings
{
    public function getEventChance(SimulationSettingName $eventName): int;

    /** @param SimulationSetting[] $simulationSettings */
    public function save(array $simulationSettings): void;

    /** @return SimulationSetting[] */
    public function all(): array;
}
