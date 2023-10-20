<?php

namespace SimulationTurnService;

use App\Tests\MyTestCase;

class HumanNonBiteInjuriesTest extends MyTestCase
{
    /** @test */
    public function humanGetsOnlyInjuredWhenHealthy(): void
    {
        $this->humanWillAlwaysGetInjured();
        $this->systemHasHumanAndTurn();

        $this->simulationTurnService()->humanNonBiteInjuries();

        assertThat($this->humanHealth(), is(equalTo('injured')));
    }

    /** @test */
    public function humanDiesWhenAlreadyInjured(): void
    {
        $this->humanWillAlwaysGetInjured();
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->build(),
        );
        $this->system()->hasHumans(
            aHuman()->withInjury()->build(),
        );

        $this->simulationTurnService()->humanNonBiteInjuries();

        assertThat($this->humanHealth(), is(equalTo('dead')));
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

        $this->simulationTurnService()->humanNonBiteInjuries();

        assertThat($this->idOfHumanInjuredInTurn($turn), is(equalTo($humanId)));
    }

    /** @test */
    public function ifInjuryChanceIsZeroNothingHappens(): void
    {
        $this->humanWillNeverGetInjured();
        $this->systemHasHumanAndTurn();

        $this->simulationTurnService()->humanNonBiteInjuries();

        assertThat($this->humanHealth(), is(equalTo('healthy')));
    }

    private function humanHealth(): string
    {
        return $this->system()->humans()->all()[0]->health;
    }

    private function idOfHumanInjuredInTurn(int $turn): int
    {
        return $this->system()->getHumanInjuries()->fromTurn($turn)[0]->humanId;
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

    private function systemHasHumanAndTurn(): void
    {
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->build(),
        );
        $this->system()->hasHumans(
            aHuman()->build(),
        );
    }
}
