<?php

namespace SimulationTurnService;

use App\Application\Service\TurnActions\HealHumanInjuries;
use App\Domain\Enum\ResourceType;
use App\Services\ProbabilityService;
use App\Tests\MyTestCase;

class HealHumanInjuriesTest extends MyTestCase
{
    /** @test */
    public function humanGetsHealed(): void
    {
        $human = aHuman()->withInjury()->build();

        $fakeProbabilityService = $this->createStub(ProbabilityService::class);
        $fakeProbabilityService->method('willItHappen')->willReturn(true);

        $this->system()->hasHumans(
            $human
        );
        $this->system()->hasResources(
            aResource()->withType(ResourceType::Health)->withQuantity(100)->build(),
        );

        $this->healHumanInjuriesActionWith($fakeProbabilityService);

        assertThat($human->isHealthy(), is(equalTo(true)));
    }

    /** @test */
    public function humanIsNotHealedWhenThereIsNoChanceForIt(): void
    {
        $human = aHuman()->withInjury()->build();

        $fakeProbabilityService = $this->createStub(ProbabilityService::class);
        $fakeProbabilityService->method('willItHappen')->willReturn(false);

        $this->system()->hasHumans(
            $human
        );
        $this->system()->hasResources(
            aResource()->withType(ResourceType::Health)->withQuantity(100)->build(),
        );

        $this->healHumanInjuriesActionWith($fakeProbabilityService);

        assertThat($human->isInjured(), is(equalTo(true)));
    }

    /** @test */
    public function humanIsNotHealedWhenThereAreNoHealthResources(): void
    {
        $human = aHuman()->withInjury()->build();

        $fakeProbabilityService = $this->createStub(ProbabilityService::class);
        $fakeProbabilityService->method('willItHappen')->willReturn(true);

        $this->system()->hasHumans(
            $human
        );
        $this->system()->hasResources(
            aResource()->withType(ResourceType::Health)->withQuantity(0)->build(),
        );

        $this->healHumanInjuriesActionWith($fakeProbabilityService);

        assertThat($human->isInjured(), is(equalTo(true)));
    }

    /** @test */
    public function humanConsumesHealthResourceDuringHealing(): void
    {
        $human = aHuman()->withInjury()->build();
        $healthResources = aResource()->withType(ResourceType::Health)->withQuantity(1)->build();

        $fakeProbabilityService = $this->createStub(ProbabilityService::class);
        $fakeProbabilityService->method('willItHappen')->willReturn(true);

        $this->system()->hasHumans(
            $human
        );
        $this->system()->hasResources(
            $healthResources,
        );

        $this->healHumanInjuriesActionWith($fakeProbabilityService);

        assertThat($healthResources->getQuantity(), is(equalTo(0)));
    }

    private function healHumanInjuriesActionWith(ProbabilityService $probabilityService): void
    {
        (new HealHumanInjuries(
            $this->system()->humans(),
            $this->system()->resources(),
            $probabilityService,
        ))->execute();
    }
}
