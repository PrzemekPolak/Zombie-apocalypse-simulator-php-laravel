<?php

namespace App\Application;

use App\Domain\Enum\HealthStatus;
use App\Domain\Enum\ResourceType;
use App\Domain\Human;

interface Humans
{
    /** @return Human[] */
    public function all(): array;

    /** @return Human[] */
    public function allAlive(): array;

    /** @return Human[] */
    public function allWithHealth(HealthStatus $health): array;

    /** @param $humans Human[] */
    public function save(array $humans): void;

    public function getNumberOfResourceProducers(ResourceType $resourceType): int;

    /** @return Human[] */
    public function getRandomHumans(int $count): array;

    public function find(int $humanId): Human;

    /** @return Human[] */
    public function whoLastAteAt(int $turn): array;
}
