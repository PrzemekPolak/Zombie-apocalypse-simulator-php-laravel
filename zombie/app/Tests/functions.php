<?php

use App\Tests\TestUtils\Builders\HumanBuilder;
use App\Tests\TestUtils\Builders\ResourceBuilder;
use App\Tests\TestUtils\Builders\SimulationTurnBuilder;

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
