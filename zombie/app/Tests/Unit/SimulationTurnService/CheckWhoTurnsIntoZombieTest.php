<?php

namespace SimulationTurnService;

use App\Domain\Human;
use App\Domain\Zombie;
use App\Tests\MyTestCase;

class CheckWhoTurnsIntoZombieTest extends MyTestCase
{
    /** @test */
    public function humanHealthStatusGetsUpdatedToTurned(): void
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
        $human = aHuman()->build();

        $this->system()->hasHumans(
            $human,
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->build(),
        );

        $this->simulationTurnService()->checkWhoTurnIntoZombie();

        $this->assertThat($human->health, $this->equalTo('healthy'));
    }

    /** @test */
    public function humanCorrectlyTurnsIntoZombie(): void
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

        $this->assertThatHumanCorrectlyBecameZombie($this->getZombieFromSystem(), $human);
    }

    private function getZombieFromSystem(): Zombie
    {
        return $this->system()->getZombies()->stillWalking()[0];
    }

    private function assertThatHumanCorrectlyBecameZombie(Zombie $actual, Human $expected): void
    {
        $this->assertThat($actual->name, $this->equalTo($expected->name));
        $this->assertThat($actual->age, $this->equalTo($expected->age));
        $this->assertThat($actual->professionName(), $this->equalTo($expected->professionName()));
        $this->assertThat($actual->health, $this->equalTo('infected'));
    }
}
