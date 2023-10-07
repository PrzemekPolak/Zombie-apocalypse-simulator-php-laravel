<?php

namespace App\Tests\SyntacticSugar;

use App\Application\Humans;
use App\Application\Resources;
use App\Domain\Human;
use App\Domain\Resource;

class System
{
    public function __construct(
        private readonly Humans    $humans,
        private readonly Resources $resources,
    )
    {
    }

    public function humans(): Humans
    {
        return $this->humans;
    }

    public function resources(): Resources
    {
        return $this->resources;
    }

    public function hasHumans(Human ...$humans): void
    {
        foreach ($humans as $human) {
            $this->humans->add($human);
        }
    }

    public function hasResources(Resource ...$resources)
    {
        foreach ($resources as $resource) {
            $this->resources->add($resource);
        }
    }
}
