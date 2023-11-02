<?php

namespace App\Infrastructure;

use App\Application\Resources;
use App\Domain\Resource;
use App\Models\Resource as ResourceModel;
use Illuminate\Support\Facades\DB;

class SqlResources implements Resources
{
    public function getByType(string $type): Resource
    {
        return Resource::fromArray(ResourceModel::where('type', $type)->first()->toArray());
    }

    public function save(array $resources): void
    {
        DB::transaction(function () use ($resources) {
            foreach ($resources as $resource) {
                ResourceModel::updateOrCreate(
                    [
                        'type' => $resource->type
                    ],
                    [
                        'type' => $resource->type,
                        'quantity' => $resource->getQuantity(),
                    ]
                );
            }
        });
    }

    public function add(Resource $resource): void
    {
        throw new \Exception('Not implemented!');
    }

    public function all(): array
    {
        return $this->mapToDomainResourcesArray(ResourceModel::all()->toArray());
    }

    /** @return Resource[] */
    private function mapToDomainResourcesArray(array $dbArray): array
    {
        return array_map(static function ($resource) {
            return Resource::fromArray($resource);
        }, $dbArray);
    }
}
