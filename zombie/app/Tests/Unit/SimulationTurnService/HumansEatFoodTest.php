<?php

namespace App\Tests\Unit\SimulationTurnService;

use App\Tests\MyTestCase;

class HumansEatFoodTest extends MyTestCase
{
    /** @test */
    public function foodResourcesDecreaseAfterHumansConsumeThem(): void
    {
        $this->systemIsOnTurn(1);
        $this->system()->hasHumans(
            aHuman()->build(),
            aHuman()->build(),
        );
        $this->systemHasFood(2);

        $this->simulationTurnService()->humansEatFood();

        assertThat($this->foodQuantityInSystem(), is(equalTo(0)));
    }

    /** @test */
    public function foodResourcesDontGoBelowZero(): void
    {
        $this->systemIsOnTurn(1);
        $this->system()->hasHumans(
            aHuman()->build(),
        );
        $this->systemHasFood(0);

        $this->simulationTurnService()->humansEatFood();

        assertThat($this->foodQuantityInSystem(), is(equalTo(0)));
    }


    /** @test */
    public function humanLastEatAtValueGetsUpdatedAfterEating(): void
    {
        $human = aHuman()->lastAteAt(0)->build();
        $currentTurn = 1;

        $this->systemIsOnTurn($currentTurn);
        $this->system()->hasHumans(
            $human,
        );
        $this->systemHasFood();

        $this->simulationTurnService()->humansEatFood();

        assertThat($this->turnHumanLastAteAt(), is(equalTo($currentTurn)));
    }

    /** @test */
    public function humanLastEatAtValueDontChangeIfThereIsNoFood(): void
    {
        $previousTurn = 1;
        $human = aHuman()->lastAteAt($previousTurn)->build();

        $this->systemIsOnTurn($previousTurn + 1);
        $this->system()->hasHumans(
            $human,
        );
        $this->systemHasFood(0);

        $this->simulationTurnService()->humansEatFood();

        assertThat($this->turnHumanLastAteAt(), is(equalTo($previousTurn)));
    }

    private function systemIsOnTurn(int $turnNumber): void
    {
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber($turnNumber)->build(),
        );
    }

    private function systemHasFood(int $quantity = 123): void
    {
        $this->system()->hasResources(
            aFoodResource()->withQuantity($quantity)->build()
        );
    }

    private function foodQuantityInSystem(): int
    {
        return $this->system()->resources()->getByType('food')->getQuantity();
    }

    private function turnHumanLastAteAt(): int
    {
        return $this->system()->humans()->allAlive()[0]->lastEatAt;
    }
}
