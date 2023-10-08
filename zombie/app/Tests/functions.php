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

function aSimulationTurn(): SimulationTurnBuilder
{
    return SimulationTurnBuilder::default();
}
