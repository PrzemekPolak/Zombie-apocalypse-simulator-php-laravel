<?php

namespace App\Tests\Acceptance;

use App\Domain\Enum\ResourceType;
use App\Tests\MyTestCase;
use App\Tests\TestUtils\Builders\ExampleRequest;
use Symfony\Component\HttpFoundation\Response;

class EndpointsAreWorkingCorrectlyTest extends MyTestCase
{
    /** @test */
    public function simulationExecutingEndpointCorrectlyRunTurn(): void
    {
        $this->populateWithPreliminaryData();

        $this->systemReceivesRequest(ExampleRequest::executeTurn());

        assertThat($this->responseStatusCode(), is(equalTo(Response::HTTP_OK)));
    }

    /** @test */
    public function correctlyClearsSimulationTables(): void
    {
        $this->populateWithPreliminaryData();

        $this->systemReceivesRequest(ExampleRequest::clearSimulationTables());

        assertThat($this->responseStatusCode(), is(equalTo(Response::HTTP_OK)));
        $this->assertThatAllTablesHasBeenCleared();
    }

    private function assertThatAllTablesHasBeenCleared(): void
    {
        assertThat(count($this->system()->humans()->all()), is(equalTo(0)));
        assertThat(count($this->system()->zombies()->all()), is(equalTo(0)));
        assertThat(count($this->system()->simulationTurns()->all()), is(equalTo(0)));
        assertThat(count($this->system()->resources()->all()), is(equalTo(0)));
        assertThat(count($this->system()->humanBites()->all()), is(equalTo(0)));
        assertThat(count($this->system()->humanInjuries()->all()), is(equalTo(0)));
    }

    private function populateWithPreliminaryData(): void
    {
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber(1)->build(),
        );
        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('chanceForBite')->withChance(50)->build(),
            aSimulationSetting()->withEvent('injuryChance')->withChance(50)->build(),
            aSimulationSetting()->withEvent('encounterChance')->withChance(50)->build(),
            aSimulationSetting()->withEvent('immuneChance')->withChance(10)->build(),
        );
        $this->system()->hasResources(
            aResource()->withType(ResourceType::Food)->withQuantity(100)->build(),
            aResource()->withType(ResourceType::Health)->withQuantity(100)->build(),
            aResource()->withType(ResourceType::Weapon)->withQuantity(100)->build(),
        );
        $this->system()->hasHumans(
            aHuman()->build(),
            aHuman()->build(),
            aHuman()->build(),
            aHuman()->build(),
            aHuman()->build(),
        );
        $this->system()->hasZombies(
            aZombie()->build(),
            aZombie()->build(),
            aZombie()->build(),
        );

        $this->system()->hasHumanBites(
            aHumanBite()->build(),
        );

        $this->system()->hasHumanInjuries(
            aHumanInjury()->build(),
        );
    }
}
