<?php

namespace App\Application\Service\TurnActions;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\TurnAction;
use App\Domain\Enum\ResourceType;

class GenerateResources implements TurnAction
{
    public function __construct(
        private readonly Humans    $humans,
        private readonly Resources $resources,
    )
    {
    }

    public function execute(): void
    {
        $resourcesTypes = [ResourceType::Health, ResourceType::Food, ResourceType::Weapon];

        foreach ($resourcesTypes as $resourceType) {
            $resource = $this->resources->getByType($resourceType);
            $resource->produce($this->humans->getNumberOfResourceProducers($resourceType));
            $this->resources->save([$resource]);
        }
    }
}
