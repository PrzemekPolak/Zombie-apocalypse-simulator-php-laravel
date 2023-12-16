<?php

namespace SimulationTurnService;

use App\Application\Service\TurnActions\CheckWhoDiedFromStarvation;
use App\Domain\Enum\HealthStatus;
use App\Domain\Human;
use App\Tests\MyTestCase;

class CheckWhoDiedFromStarvationTest extends MyTestCase
{
    private const CURRENT_TURN = 4;

    public function setUp(): void
    {
        parent::setUp();

        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber(self::CURRENT_TURN)->build(),
        );
    }

    /** @test */
    public function onlyHumansWhoDidntEatForThreeTurnsDie(): void
    {
        $humanWhoDidntEat = aHuman()->lastAteAt(self::CURRENT_TURN - 3)->build();
        $humanWhoAte = aHuman()->lastAteAt(self::CURRENT_TURN)->build();

        $this->system()->hasHumans(
            $humanWhoDidntEat,
            $humanWhoAte,
        );

        $this->checkWhoDiedFromStarvation();

        assertThat($this->aliveHumansIds(), is(equalTo([$humanWhoAte->id])));
    }

    /** @test */
    public function humanWhoStarvedDiesWithCorrectDeathReason(): void
    {
        $humanWhoDidntEat = aHuman()->lastAteAt(self::CURRENT_TURN - 3)->build();

        $this->system()->hasHumans(
            $humanWhoDidntEat,
        );

        $this->checkWhoDiedFromStarvation();

        assertThat($humanWhoDidntEat->health, is(equalTo(HealthStatus::Dead)));
        assertThat($humanWhoDidntEat->getDeathCause(), is(equalTo('starvation')));
    }

    /** @test */
    public function turnedPeopleCanNoLongerDieFromStarvation(): void
    {
        $turnedHuman = aHuman()->lastAteAt(self::CURRENT_TURN - 3)->withHealth(HealthStatus::Turned)->build();

        $this->system()->hasHumans(
            $turnedHuman,
        );

        $this->checkWhoDiedFromStarvation();

        assertThat($turnedHuman->health, is(equalTo(HealthStatus::Turned)));
        assertThat($turnedHuman->getDeathCause(), is(not(equalTo('starvation'))));
    }

    /** @test */
    public function deadPeopleCanNoLongerDieFromStarvation(): void
    {
        $deadHuman = aHuman()->lastAteAt(self::CURRENT_TURN - 3)->withHealth(HealthStatus::Dead)->build();

        $this->system()->hasHumans(
            $deadHuman,
        );

        $this->checkWhoDiedFromStarvation();

        assertThat($deadHuman->health, is(equalTo(HealthStatus::Dead)));
        assertThat($deadHuman->getDeathCause(), is(not(equalTo('starvation'))));
    }

    private function checkWhoDiedFromStarvation(): void
    {
        (new CheckWhoDiedFromStarvation(
            $this->system()->humans(),
            $this->system()->simulationTurns(),
        ))->execute();
    }

    private function aliveHumansIds(): array
    {
        return array_map(
            static fn(Human $human) => $human->id,
            $this->system()->humans()->allAlive()
        );
    }
}
