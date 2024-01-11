<?php

namespace App\Application\Service\TurnActions;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\ProbabilityService;
use App\Application\Service\TurnAction;
use App\Domain\Enum\HealthStatus;
use App\Domain\Enum\ResourceType;

class HealHumanInjuries implements TurnAction
{
    public function __construct(
        private readonly Humans             $humans,
        private readonly Resources          $resources,
        private readonly ProbabilityService $probabilityService,
    )
    {
    }

    public function execute(): void
    {
        $healthItems = $this->resources->getByType(ResourceType::Health);

        foreach ($this->humans->allWithHealth(HealthStatus::Injured) as $human) {
            if ($healthItems->getQuantity() > 0 && $this->probabilityService->willItHappen(25)) {
                $healthItems->consume();
                $human->getsHealthy();
            }
        }
    }
}
