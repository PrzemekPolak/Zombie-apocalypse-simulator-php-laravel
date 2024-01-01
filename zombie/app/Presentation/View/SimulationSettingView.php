<?php

namespace App\Presentation\View;

use App\Domain\SimulationSetting;

class SimulationSettingView
{
    public function __construct(
        public readonly string $event,
        public readonly int    $chance,
        public readonly string $description,
    )
    {
    }

    public static function fromDto(SimulationSetting $simulationSetting): self
    {
        return new self(
            $simulationSetting->settingName(),
            $simulationSetting->chance(),
            $simulationSetting->description,
        );
    }
}
