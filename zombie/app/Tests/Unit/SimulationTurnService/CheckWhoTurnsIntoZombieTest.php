<?php

namespace SimulationTurnService;

use App\Application\Service\TurnActions\CheckWhoTurnsIntoZombie;
use App\Domain\Enum\HealthStatus;
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

        $this->checkWhoTurnsIntoZombie();

        assertThat($human->health, is(equalTo(HealthStatus::Turned)));
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

        $this->checkWhoTurnsIntoZombie();

        assertThat($human->health, is(equalTo(HealthStatus::Healthy)));
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

        $this->checkWhoTurnsIntoZombie();

        $this->assertThatHumanCorrectlyBecameZombie($this->getZombieFromSystem(), $human);
    }

    private function checkWhoTurnsIntoZombie(): void
    {
        (new CheckWhoTurnsIntoZombie(
            $this->system()->humans(),
            $this->system()->simulationTurns(),
            $this->system()->humanBites(),
            $this->system()->zombies(),
        ))->execute();
    }

    private function getZombieFromSystem(): Zombie
    {
        return $this->system()->zombies()->stillWalking()[0];
    }

    private function assertThatHumanCorrectlyBecameZombie(Zombie $actual, Human $expected): void
    {
        assertThat($actual->name, is(equalTo($expected->name)));
        assertThat($actual->age, is(equalTo($expected->age)));
        assertThat($actual->professionName(), is(equalTo($expected->professionName())));
        assertThat($actual->health, is(equalTo(HealthStatus::Turned)));
    }
}
