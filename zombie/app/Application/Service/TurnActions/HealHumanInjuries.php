<?php

namespace App\Application\Service\TurnActions;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\TurnAction;
use App\Services\ProbabilityService;

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
        $humans = $this->humans->injured();
        $healthItems = $this->resources->getByType('health');

        for ($i = 0; $i < count($humans); $i++) {
            if ($healthItems->getQuantity() > 0 && $this->probabilityService->willItHappen(25)) {
                $healthItems->consume();
                $humans[$i]->getsHealthy();
            }
        }
    }
}
