<?php

namespace App\Infrastructure;

use App\Application\Resources;
use App\Domain\Enum\ResourceType;
use App\Domain\Resource;
use App\Models\Resource as ModelResource;
use Illuminate\Support\Facades\DB;

class SqlResources implements Resources
{
    public function getByType(ResourceType $type): Resource
    {
        return Resource::fromArray(ModelResource::where('type', $type->value)->first()->toArray());
    }

    public function save(array $resources): void
    {
        DB::transaction(function () use ($resources) {
            foreach ($resources as $resource) {
                ModelResource::updateOrCreate(
                    [
                        'type' => $resource->type->value
                    ],
                    [
                        'type' => $resource->type->value,
                        'quantity' => $resource->getQuantity(),
                    ]
                );
            }
        });
    }

    public function all(): array
    {
        return $this->mapToDomainResourcesArray(ModelResource::all()->toArray());
    }

    /** @return Resource[] */
    private function mapToDomainResourcesArray(array $dbArray): array
    {
        return array_map(static function ($resource) {
            return Resource::fromArray($resource);
        }, $dbArray);
    }
}
