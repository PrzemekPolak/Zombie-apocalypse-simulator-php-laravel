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

function aResource(): ResourceBuilder
{
    return ResourceBuilder::default();
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
