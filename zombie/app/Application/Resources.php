<?php

namespace App\Application;

use App\Domain\Resource;

interface Resources
{
    public function getByType(string $type): Resource;

    public function save(Resource $resource): void;

    public function add(Resource $resource): void;
}
