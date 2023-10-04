<?php

use App\Tests\TestUtils\Builders\HumanBuilder;
use App\Tests\TestUtils\Builders\ResourceBuilder;

function aHuman(): HumanBuilder
{
    return HumanBuilder::default();
}

function aFoodResource(): ResourceBuilder
{
    return ResourceBuilder::default()->withType('food')->withProductionMultiplier(2);
}
