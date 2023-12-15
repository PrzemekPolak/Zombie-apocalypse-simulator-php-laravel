<?php

namespace SimulationTurnService;

use App\Application\Service\TurnActions\GenerateResources;
use App\Domain\Enum\ResourceType;
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

        assertThat($this->resourceQuantityInSystem(ResourceType::Food), is(equalTo(0)));
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
        assertThat($this->resourceQuantityInSystem(ResourceType::Food), is(equalTo(2)));
        assertThat($this->resourceQuantityInSystem(ResourceType::Health), is(equalTo(1)));
        assertThat($this->resourceQuantityInSystem(ResourceType::Weapon), is(equalTo(1)));
    }

    private function resourceQuantityInSystem(ResourceType $type): int
    {
        return $this->system()->resources()->getByType($type)->getQuantity();
    }

    private function currentlyThereAreNoResources(): void
    {
        $this->system()->hasResources(
            aResource()->withType(ResourceType::Food)->withQuantity(0)->build(),
            aResource()->withType(ResourceType::Health)->withQuantity(0)->build(),
            aResource()->withType(ResourceType::Weapon)->withQuantity(0)->build(),
        );
    }
}
