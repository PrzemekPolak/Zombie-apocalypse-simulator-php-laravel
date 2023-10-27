<?php

use App\Tests\TestUtils\Builders\HumanBiteBuilder;
use App\Tests\TestUtils\Builders\HumanBuilder;
use App\Tests\TestUtils\Builders\HumanInjuryBuilder;
use App\Tests\TestUtils\Builders\ResourceBuilder;
use App\Tests\TestUtils\Builders\SimulationSettingBuilder;
use App\Tests\TestUtils\Builders\SimulationTurnBuilder;
use App\Tests\TestUtils\Builders\ZombieBuilder;

function aHuman(): HumanBuilder
{
    return HumanBuilder::default();
}

function aFoodResource(): ResourceBuilder
{
    return ResourceBuilder::default()->withType('food')->withProductionMultiplier(2);
}

function aHealthResource(): ResourceBuilder
{
    return ResourceBuilder::default()->withType('health')->withProductionMultiplier(1);
}

function aWeaponResource(): ResourceBuilder
{
    return ResourceBuilder::default()->withType('weapon')->withProductionMultiplier(1);
}

function aSimulationTurn(): SimulationTurnBuilder
{
    return SimulationTurnBuilder::default();
}

function aSimulationSetting(): SimulationSettingBuilder
{
    return SimulationSettingBuilder::default();
}

function aHumanBite(): HumanBiteBuilder
{
    return HumanBiteBuilder::default();
}

function aHumanInjury(): HumanInjuryBuilder
{
    return HumanInjuryBuilder::default();
}

function aZombie(): ZombieBuilder
{
    return ZombieBuilder::default();
}
