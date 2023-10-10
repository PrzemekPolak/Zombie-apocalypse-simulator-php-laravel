<?php

namespace SimulationTurnService;

use App\Tests\MyTestCase;

class HumanNonBiteInjuriesTest extends MyTestCase
{
    /** @test */
    public function humanGetsOnlyInjuredWhenHealthy(): void
    {
        $human = aHuman()->build();

        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('injuryChance')->withChance(100)->build(),
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->build(),
        );
        $this->system()->hasHumans(
            $human,
        );

        $this->simulationTurnService()->humanNonBiteInjuries();

        $this->assertThat($this->humanHealth(), $this->equalTo('injured'));
    }

    /** @test */
    public function humanDiesWhenAlreadyInjured(): void
    {
        $human = aHuman()->withInjury()->build();

        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('injuryChance')->withChance(100)->build(),
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->build(),
        );
        $this->system()->hasHumans(
            $human,
        );

        $this->simulationTurnService()->humanNonBiteInjuries();

        $this->assertThat($this->humanHealth(), $this->equalTo('dead'));
    }

    /** @test */
    public function humanInjuryHistoryIsCreated(): void
    {

    }

    /** @test */
    public function ifInjuryChanceIsZeroNothingHappens(): void
    {
        $human = aHuman()->build();

        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('injuryChance')->withChance(0)->build(),
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->build(),
        );
        $this->system()->hasHumans(
            $human,
        );

        $this->simulationTurnService()->humanNonBiteInjuries();

        $this->assertThat($this->humanHealth(), $this->equalTo('healthy'));
    }

    public function humanHealth(): string
    {
        return $this->system()->humans()->allAlive()[0]->health;
    }
}
