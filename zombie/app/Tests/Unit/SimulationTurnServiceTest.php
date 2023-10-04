<?php

namespace Tests\Unit;

use App\Tests\MyTestCase;

require_once('App\Tests\functions.php');

class SimulationTurnServiceTest extends MyTestCase
{
    /** @test */
    public function humansEatFoodTest(): void
    {
        $this->system()->hasHumans(
            aHuman()->build(),
            aHuman()->build(),
        );
        $this->system()->hasResources(
            aFoodResource()->withQuantity(2)->build()
        );

        $this->simulationTurnService()->humansEatFood();

        $this->assertThat($this->foodQuantityInSystem(), self::equalTo(0));
    }

    private function foodQuantityInSystem(): int
    {
        return $this->system()->resources()->getByType('food')->getQuantity();
    }
}
