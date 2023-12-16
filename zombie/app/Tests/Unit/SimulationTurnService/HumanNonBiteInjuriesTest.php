<?php

namespace SimulationTurnService;

use App\Application\Service\TurnActions\GenerateHumanNonBiteInjuries;
use App\Domain\Enum\HealthStatus;
use App\Tests\MyTestCase;

class HumanNonBiteInjuriesTest extends MyTestCase
{
    /** @test */
    public function humanGetsOnlyInjuredWhenHealthy(): void
    {
        $this->humanWillAlwaysGetInjured();
        $this->systemHasHumanAndTurn();

        $this->generateHumanNonBiteInjuries();

        assertThat($this->humanHealth(), is(equalTo(HealthStatus::Injured)));
    }

    /** @test */
    public function humanDiesIfAlreadyInjured(): void
    {
        $this->humanWillAlwaysGetInjured();
        $this->systemHasTurn();
        $this->system()->hasHumans(
            aHuman()->withInjury()->build(),
        );

        $this->generateHumanNonBiteInjuries();

        assertThat($this->humanHealth(), is(equalTo(HealthStatus::Dead)));
    }

    /** @test */
    public function humanDiesIfAlreadyInfected(): void
    {
        $this->humanWillAlwaysGetInjured();
        $this->systemHasTurn();
        $this->system()->hasHumans(
            aHuman()->withHealth(HealthStatus::Infected)->build(),
        );

        $this->generateHumanNonBiteInjuries();

        assertThat($this->humanHealth(), is(equalTo(HealthStatus::Dead)));
    }

    /** @test */
    public function deadHumansAreNotConsideredForCalculatingEventOccurrence(): void
    {
        $this->humanWillAlwaysGetInjured();
        $this->systemHasTurn();
        $this->system()->hasHumans(
            aHuman()->withHealth(HealthStatus::Dead)->build(),
        );

        $this->generateHumanNonBiteInjuries();

        assertThat($this->system()->humanInjuries()->all(), is(emptyArray()));
    }

    /** @test */
    public function turnedHumansAreNotConsideredForCalculatingEventOccurrence(): void
    {
        $this->humanWillAlwaysGetInjured();
        $this->systemHasTurn();
        $this->system()->hasHumans(
            aHuman()->withHealth(HealthStatus::Turned)->build(),
        );

        $this->generateHumanNonBiteInjuries();

        assertThat($this->system()->humanInjuries()->all(), is(emptyArray()));
    }

    /** @test */
    public function humanInjuryHistoryIsCreated(): void
    {
        $humanId = 1234;
        $turn = 1;

        $this->humanWillAlwaysGetInjured();
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber($turn)->build(),
        );
        $this->system()->hasHumans(
            aHuman()->withId($humanId)->build(),
        );

        $this->generateHumanNonBiteInjuries();

        assertThat($this->idOfHumanInjuredInTurn($turn), is(equalTo($humanId)));
    }

    /** @test */
    public function ifInjuryChanceIsZeroNothingHappens(): void
    {
        $this->humanWillNeverGetInjured();
        $this->systemHasHumanAndTurn();

        $this->generateHumanNonBiteInjuries();

        assertThat($this->humanHealth(), is(equalTo(HealthStatus::Healthy)));
    }

    private function generateHumanNonBiteInjuries(): void
    {
        (new GenerateHumanNonBiteInjuries(
            $this->system()->humans(),
            $this->system()->simulationTurns(),
            $this->system()->simulationSettings(),
            $this->system()->humanInjuries(),
        ))->execute();
    }

    private function humanHealth(): HealthStatus
    {
        return array_slice($this->system()->humans()->all(), 0, 1)[0]->health;
    }

    private function idOfHumanInjuredInTurn(int $turn): int
    {
        return $this->system()->humanInjuries()->fromTurn($turn)[0]->humanId;
    }

    private function humanWillAlwaysGetInjured(): void
    {
        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('injuryChance')->withChance(100)->build(),
        );
    }

    private function humanWillNeverGetInjured(): void
    {
        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('injuryChance')->withChance(0)->build(),
        );
    }

    private function systemHasTurn(): void
    {
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->build(),
        );
    }

    private function systemHasHumanAndTurn(): void
    {
        $this->systemHasTurn();
        $this->system()->hasHumans(
            aHuman()->build(),
        );
    }
}
