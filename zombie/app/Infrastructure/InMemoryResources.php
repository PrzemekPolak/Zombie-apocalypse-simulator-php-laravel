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
        return $this->resources[$type];
    }

    public function save(array $resources): void
    {
        foreach ($resources as $resource) {
            $this->resources[$resource->type] = $resource;
        }
    }

    public function all(): array
    {
        return $this->resources;
    }
}
