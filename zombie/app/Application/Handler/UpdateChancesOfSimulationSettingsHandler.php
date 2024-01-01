<?php

namespace App\Application\Handler;

use App\Application\Command\UpdateChancesOfSimulationSettingsCommand;
use App\Application\SimulationSettings;
use App\Domain\SimulationSetting;

class UpdateChancesOfSimulationSettingsHandler
{
    public function __construct(
        private readonly SimulationSettings $simulationSettings,
    )
    {
    }

    public function __invoke(UpdateChancesOfSimulationSettingsCommand $command): void
    {
        $this->simulationSettings->save($this->updatedSimulationSettings($command));
    }

    private function updatedSimulationSettings(UpdateChancesOfSimulationSettingsCommand $command): array
    {
        return array_map(
            function (SimulationSetting $simulationSetting) use ($command) {
                if (in_array($simulationSetting->settingName(), array_keys($command->newValuesOfChances))) {
                    $simulationSetting->setNewChance($command->newValuesOfChances[$simulationSetting->settingName()]);
                }

                return $simulationSetting;
            },
            $this->simulationSettings->all()
        );
    }
}
