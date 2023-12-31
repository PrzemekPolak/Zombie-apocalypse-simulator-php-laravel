<?php

namespace App\Domain\Enum;

enum SimulationSettingName: string
{
    case EncounterChance = 'encounterChance';
    case ChanceForBite = 'chanceForBite';
    case InjuryChance = 'injuryChance';
    case ImmuneChance = 'immuneChance';
}
