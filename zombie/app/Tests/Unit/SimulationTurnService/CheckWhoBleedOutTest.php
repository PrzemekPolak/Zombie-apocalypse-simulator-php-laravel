<?php

namespace SimulationTurnService;

use App\Application\Service\TurnActions\CheckWhoBleedOut;
use App\Domain\Enum\HealthStatus;
use App\Domain\Human;
use App\Tests\MyTestCase;

class CheckWhoBleedOutTest extends MyTestCase
{
    /** @test */
    public function humanBleedOutAfterTwoTurns(): void
    {
        $humanWithInjury = aHuman()->withInjury()->build();
        $injuryCause = 'Tripped';

        $this->systemHasHumanInjuredTwoTurnsAgo($humanWithInjury, $injuryCause);

        $this->checkWhoBleedOut();

        assertThat($humanWithInjury->health, is(equalTo(HealthStatus::Dead)));
        assertThat($humanWithInjury->getDeathCause(), is(equalTo($injuryCause)));
    }

    /** @test */
    public function healthyHumanDoesntBleedOutAfterTwoTurns(): void
    {
        $healthyHuman = aHuman()->build();

        $this->systemHasHumanInjuredTwoTurnsAgo($healthyHuman);

        $this->checkWhoBleedOut();

        assertThat($healthyHuman->health, is(equalTo(HealthStatus::Healthy)));
    }

    /** @test */
    public function infectedHumanDoesntBleedOutAfterTwoTurns(): void
    {
        $infectedHuman = aHuman()->withHealth(HealthStatus::Infected)->build();

        $this->systemHasHumanInjuredTwoTurnsAgo($infectedHuman);

        $this->checkWhoBleedOut();

        assertThat($infectedHuman->health, is(equalTo(HealthStatus::Infected)));
    }

    /** @test */
    public function turnedHumanDoesntBleedOutAfterTwoTurns(): void
    {
        $turnedHuman = aHuman()->withHealth(HealthStatus::Turned)->build();

        $this->systemHasHumanInjuredTwoTurnsAgo($turnedHuman);

        $this->checkWhoBleedOut();

        assertThat($turnedHuman->health, is(equalTo(HealthStatus::Turned)));
    }

    private function checkWhoBleedOut(): void
    {
        (new CheckWhoBleedOut(
            $this->system()->humans(),
            $this->system()->simulationTurns(),
            $this->system()->humanInjuries(),
        ))->execute();
    }

    private function systemHasHumanInjuredTwoTurnsAgo(Human $human, string $injuryCause = 'Default injury'): void
    {
        $currentTurn = 4;

        $this->system()->hasHumans(
            $human,
        );
        $this->system()->hasHumanInjuries(
            aHumanInjury()
                ->atTurn($currentTurn - 2)
                ->injuredHumanId($human->id)
                ->injuryCause($injuryCause)
                ->build(),
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber($currentTurn)->build(),
        );
    }
}
