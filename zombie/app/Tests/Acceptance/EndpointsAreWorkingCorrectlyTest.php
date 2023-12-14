<?php

namespace App\Tests\Acceptance;

use App\Tests\MyTestCase;
use Symfony\Component\HttpFoundation\Response;

class EndpointsAreWorkingCorrectlyTest extends MyTestCase
{
    /** @test */
    public function simulationExecutingEndpointCorrectlyRunTurn(): void
    {
        $this->populateWithPreliminaryData();

        $response = $this->json('POST', '/api/simulation_turn');

        assertThat($response->getStatusCode(), is(equalTo(Response::HTTP_OK)));
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
            aFoodResource()->withQuantity(100)->build(),
            aHealthResource()->withQuantity(100)->build(),
            aWeaponResource()->withQuantity(100)->build(),
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
    }
}
