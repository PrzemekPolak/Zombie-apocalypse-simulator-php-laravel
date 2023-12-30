<?php

namespace App\Infrastructure;

use App\Application\Resources;
use App\Domain\Enum\ResourceType;
use App\Domain\Resource;

class InMemoryResources implements Resources
{
    /** @var Resource[] $resources */
    private array $resources = [];

    public function getByType(ResourceType $type): Resource
    {
        return $this->resources[$type->value];
    }

    public function save(array $resources): void
    {
        foreach ($resources as $resource) {
            $this->resources[$resource->type->value] = $resource;
        }
    }

    public function all(): array
    {
        return $this->resources;
    }

    public function removeAll(): void
    {
        $this->resources = [];
    }
}
