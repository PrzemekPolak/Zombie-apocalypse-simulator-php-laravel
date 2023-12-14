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
        $this->currentlyThereAreNoResources();

        $this->generateResources();

        $this->assertResourcesAreGeneratedInRightQuantity();
    }

    /** @test */
    public function deadAndTurnedHumansDontProduceAnything(): void
    {
        $foodProducingProfession = 'farmer';

        $this->system()->hasHumans(
            aHuman()->withHealth('dead')->withProfession($foodProducingProfession)->build(),
            aHuman()->withHealth('turned')->withProfession($foodProducingProfession)->build(),
        );
        $this->currentlyThereAreNoResources();

        $this->generateResources();

        assertThat($this->resourceQuantityInSystem('food'), is(equalTo(0)));
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

    private function currentlyThereAreNoResources(): void
    {
        $this->system()->hasResources(
            aResource()->withType('food')->withQuantity(0)->build(),
            aResource()->withType('health')->withQuantity(0)->build(),
            aResource()->withType('weapon')->withQuantity(0)->build(),
        );
    }
}
