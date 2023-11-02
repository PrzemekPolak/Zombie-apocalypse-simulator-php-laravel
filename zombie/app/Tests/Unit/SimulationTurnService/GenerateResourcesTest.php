<?php

namespace SimulationTurnService;

use App\Application\Service\TurnActions\GenerateResources;
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

        $this->generateResources();

        $this->assertResourcesAreGeneratedInRightQuantity();
    }

    private function generateResources(): void
    {
        (new GenerateResources(
            $this->system()->humans(),
            $this->system()->resources(),
        ))->execute();
    }

    private function assertResourcesAreGeneratedInRightQuantity(): void
    {
        assertThat($this->resourceQuantityInSystem('food'), is(equalTo(2)));
        assertThat($this->resourceQuantityInSystem('health'), is(equalTo(1)));
        assertThat($this->resourceQuantityInSystem('weapon'), is(equalTo(1)));
    }

    private function resourceQuantityInSystem(string $type): int
    {
        return $this->system()->resources()->getByType($type)->getQuantity();
    }
}
