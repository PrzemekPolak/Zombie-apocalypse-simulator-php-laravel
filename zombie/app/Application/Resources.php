<?php

namespace App\Application;

use App\Domain\Resource;

interface Resources
{
    public function getByType(string $type): Resource;

    /** @param Resource[] $resources */
    public function save(array $resources): void;

    /** @return Resource[] */
    public function all(): array;
}
