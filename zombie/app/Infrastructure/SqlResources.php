<?php

namespace App\Infrastructure;

use App\Application\Resources;
use App\Domain\Resource;
use App\Models\Resource as ResourceModel;

class SqlResources implements Resources
{

    public function getByType(string $type): Resource
    {
        $resource = ResourceModel::where('type', $type)->first();
        return new Resource(
            $resource->type,
            $resource->quantity,
            $resource->type === 'food' ? 2 : 1,
        );
    }

    public function save(Resource $resource): void
    {
        ResourceModel::where('type', $resource->type)->update(['quantity' => $resource->getQuantity()]);
    }

    public function add(Resource $resource): void
    {
        throw new \Exception('Not implemented!');
    }
}
