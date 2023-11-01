<?php

namespace SimulationTurnService;

use App\Application\Service\TurnActions\CheckWhoBleedOut;
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

        assertThat($humanWithInjury->health, is(equalTo('dead')));
        assertThat($humanWithInjury->getDeathCause(), is(equalTo($injuryCause)));
    }

    /** @test */
    public function healthyHumanDoesntBleedOutAfterTwoTurns(): void
    {
        $healthyHuman = aHuman()->build();

        $this->systemHasHumanInjuredTwoTurnsAgo($healthyHuman);

        $this->checkWhoBleedOut();

        assertThat($healthyHuman->health, is(equalTo('healthy')));
    }

    /** @test */
    public function infectedHumanDoesntBleedOutAfterTwoTurns(): void
    {
        $infectedHuman = aHuman()->withHealth('infected')->build();

        $this->systemHasHumanInjuredTwoTurnsAgo($infectedHuman);

        $this->checkWhoBleedOut();

        assertThat($infectedHuman->health, is(equalTo('infected')));
    }

    /** @test */
    public function turnedHumanDoesntBleedOutAfterTwoTurns(): void
    {
        $turnedHuman = aHuman()->withHealth('turned')->build();

        $this->systemHasHumanInjuredTwoTurnsAgo($turnedHuman);

        $this->checkWhoBleedOut();

        assertThat($turnedHuman->health, is(equalTo('turned')));
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
