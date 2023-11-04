<?php

namespace App\Tests\Acceptance;

use App\Tests\MyTestCase;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

class EndpointsAreWorkingCorrectlyTest extends MyTestCase
{
    /** @test */
    public function simulationExecutingEndpointCorrectlyRedirectsToDashboard(): void
    {
        $this->populateWithPreliminaryData();

        $response = $this->json('POST', '/simulation_turn');

        assertThat($response->getStatusCode(), is(equalTo(Response::HTTP_FOUND)));
        assertThat($this->wasRedirectedToDashboard($response), is(equalTo(true)));
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

    private function wasRedirectedToDashboard(TestResponse $response): bool
    {
        return str_contains($response->content(), 'Redirecting to http://localhost/dashboard');
    }
}
