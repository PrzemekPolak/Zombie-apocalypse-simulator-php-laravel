<?php

namespace SimulationTurnService;

use App\Tests\MyTestCase;

class GenerateResourcesTest extends MyTestCase
{
    /** @test */
    public function resourcesAreCorrectlyGenerated(): void
    {
        $foodProducingProfession = 'farmer';
        $healthProducingProfession = 'doctor';
        $weaponProducingProfession = 'engineer';

        $this->system()->hasHumans(
            aHuman()->withProfession($foodProducingProfession)->build(),
            aHuman()->withProfession($healthProducingProfession)->build(),
            aHuman()->withProfession($weaponProducingProfession)->build(),
            aHuman()->build(),
        );
        $this->system()->hasResources(
            aFoodResource()->withQuantity(0)->build(),
            aHealthResource()->withQuantity(0)->build(),
            aWeaponResource()->withQuantity(0)->build(),
        );

        $this->simulationTurnService()->generateResources();

        $this->assertResourcesAreGeneratedInRightQuantity();
    }

    private function assertResourcesAreGeneratedInRightQuantity(): void
    {
        $this->assertThat($this->resourceQuantityInSystem('food'), self::equalTo(2));
        $this->assertThat($this->resourceQuantityInSystem('health'), self::equalTo(1));
        $this->assertThat($this->resourceQuantityInSystem('weapon'), self::equalTo(1));
    }

    private function resourceQuantityInSystem(string $type): int
    {
        return $this->system()->resources()->getByType($type)->getQuantity();
    }
}
