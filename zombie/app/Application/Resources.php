<?php

namespace App\Application;

use App\Domain\Enum\ResourceType;
use App\Domain\Resource;

interface Resources
{
    public function getByType(ResourceType $type): Resource;

    /** @param Resource[] $resources */
    public function save(array $resources): void;

    /** @return Resource[] */
    public function all(): array;
}
