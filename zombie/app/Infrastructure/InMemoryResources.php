<?php

namespace App\Infrastructure;

use App\Application\Resources;
use App\Domain\Resource;

class InMemoryResources implements Resources
{
    /** @var Resource[] $resources */
    private array $resources = [];

    public function getByType(string $type): Resource
    {
        foreach ($this->resources as $resource) {
            if ($resource->type === $type) {
                return $resource;
            }
        }
    }

    public function save(Resource $resource): void
    {
        // TODO: Do nothing looks bad, so find way to improve it
    }

    public function add(Resource $resource): void
    {
        $this->resources[] = $resource;
    }
}
