<?php

namespace App\Tests\Acceptance;

use App\Domain\Enum\ResourceType;
use App\Domain\Enum\SimulationSettingName;
use App\Tests\MyTestCase;
use App\Tests\TestUtils\Builders\ExampleRequest;

class SimulationSetupAcceptanceTest extends MyTestCase
{
    /** @test */
    public function initialDataIsCorrectlySetUpWhenUserStartsNewSimulation(): void
    {
        $humansCount = 10;
        $zombiesCount = 5;

        $this->systemReceivesRequest(ExampleRequest::setupSimulationWithHumansAndZombies($humansCount, $zombiesCount));

        assertThat($this->system()->resources()->getByType(ResourceType::Health)->getQuantity(), is(equalTo($humansCount)));
        assertThat($this->system()->resources()->getByType(ResourceType::Food)->getQuantity(), is(equalTo($humansCount * 10)));
        assertThat($this->system()->resources()->getByType(ResourceType::Weapon)->getQuantity(), is(equalTo($humansCount)));
        assertThat(count($this->system()->humans()->all()), is(equalTo($humansCount)));
        assertThat(count($this->system()->zombies()->all()), is(equalTo($zombiesCount)));
    }

    /** @test */
    public function dontSetUpInitialDataWhenSimulationIsAlreadyRunning(): void
    {
        $this->system()->hasSimulationTurns(aSimulationTurn()->build());

        $this->systemReceivesRequest(ExampleRequest::setupSimulation());

        assertThat(count($this->system()->humans()->all()), is(equalTo(0)));
        assertThat(count($this->system()->zombies()->all()), is(equalTo(0)));
    }

    /** @test */
    public function userCanChangeSimulationSettingsChances(): void
    {
        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent(SimulationSettingName::EncounterChance)->build(),
            aSimulationSetting()->withEvent(SimulationSettingName::ChanceForBite)->build(),
            aSimulationSetting()->withEvent(SimulationSettingName::InjuryChance)->build(),
            aSimulationSetting()->withEvent(SimulationSettingName::ImmuneChance)->build(),
        );

        $this->systemReceivesRequest(ExampleRequest::setupSimulationWithEventChances(60, 60, 20, 20));

        assertThat($this->system()->simulationSettings()->getEventChance(SimulationSettingName::EncounterChance), is(equalTo(60)));
        assertThat($this->system()->simulationSettings()->getEventChance(SimulationSettingName::ChanceForBite), is(equalTo(60)));
        assertThat($this->system()->simulationSettings()->getEventChance(SimulationSettingName::InjuryChance), is(equalTo(20)));
        assertThat($this->system()->simulationSettings()->getEventChance(SimulationSettingName::ImmuneChance), is(equalTo(20)));
    }
}
