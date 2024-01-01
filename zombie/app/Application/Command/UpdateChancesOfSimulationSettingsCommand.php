<?php

namespace App\Application\Command;

class UpdateChancesOfSimulationSettingsCommand
{
    public function __construct(
        /** @param int[] $newValuesOfChances */
        public readonly array $newValuesOfChances,
    )
    {
    }
}
