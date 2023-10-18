<?php

namespace SimulationTurnService;

use App\Domain\Human;
use App\Tests\MyTestCase;

class CheckWhoDiedFromStarvationTest extends MyTestCase
{
    /** @test */
    public function onlyHumansWhoDidntEatForThreeTurnsDie(): void
    {
        $currentTurn = 4;
        $humanWhoDidntEat = aHuman()->lastAteAt($currentTurn - 3)->build();
        $humanWhoAte = aHuman()->lastAteAt($currentTurn)->build();

        $this->system()->hasHumans(
            $humanWhoDidntEat,
            $humanWhoAte,
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber($currentTurn)->build(),
        );

        $this->simulationTurnService()->checkWhoDiedFromStarvation();

        $this->assertThat($this->aliveHumansIds(), $this->equalTo([$humanWhoAte->id]));
    }

    /** @test */
    public function humanWhoStarvedDiesWithCorrectDeathReason(): void
    {
        $currentTurn = 4;
        $humanWhoDidntEat = aHuman()->lastAteAt($currentTurn - 3)->build();

        $this->system()->hasHumans(
            $humanWhoDidntEat,
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber($currentTurn)->build(),
        );

        $this->simulationTurnService()->checkWhoDiedFromStarvation();

        $this->assertThat($humanWhoDidntEat->health, $this->equalTo('dead'));
        $this->assertThat($humanWhoDidntEat->getDeathCause(), $this->equalTo('starvation'));
    }

    private function aliveHumansIds(): array
    {
        return array_map(
            static fn(Human $human) => $human->id,
            $this->system()->humans()->allAlive()
        );
    }
}