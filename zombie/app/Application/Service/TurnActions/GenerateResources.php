<?php

namespace App\Application\Service\TurnActions;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\TurnAction;

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
        $resourcesTypes = ['health', 'food', 'weapon'];

        foreach ($resourcesTypes as $resourceType) {
            $resource = $this->resources->getByType($resourceType);
            $resource->produce($this->humans->getNumberOfResourceProducers($resourceType));
            $this->resources->save([$resource]);
        }
    }
}
