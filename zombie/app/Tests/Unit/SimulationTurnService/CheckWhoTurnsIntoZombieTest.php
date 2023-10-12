<?php

namespace SimulationTurnService;

use App\Tests\MyTestCase;

class CheckWhoTurnsIntoZombieTest extends MyTestCase
{
    /** @test */
    public function humanHealthStatusGetsUpdated(): void
    {
        $humanId = 123456;
        $currentTurn = 2;

        $human = aHuman()->withId($humanId)->build();

        $this->system()->hasHumans(
            $human,
        );
        $this->system()->hasHumanBites(
            aHumanBite()->withHumanId($humanId)->withTurn($currentTurn - 1)->build(),
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber($currentTurn)->build(),
        );

        $this->simulationTurnService()->checkWhoTurnIntoZombie();

        $this->assertThat($human->health, $this->equalTo('turned'));
    }

    /** @test */
    public function healthyHumanDontTurnIntoZombie(): void
    {

    }
}
