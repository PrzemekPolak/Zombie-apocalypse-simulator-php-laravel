<?php

namespace App\Infrastructure;

use App\Application\Humans;
use App\Domain\Human;

class InMemoryHumans implements Humans
{
    private array $humans = [];

    public function allAlive(): array
    {
        return $this->humans;
    }

    public function countAlive(): int
    {
        throw new \Exception('Not implemented!');
    }

    public function update(int $id, array $fields): void
    {
        throw new \Exception('Not implemented!');
    }

    public function saveFromArray(array $humans): void
    {
        // TODO: Do nothing looks bad, so find way to improve it
    }

    public function getNumberOfResourceProducers(string $resourceType): int
    {
        throw new \Exception('Not implemented!');
    }

    public function injured(): array
    {
        throw new \Exception('Not implemented!');
    }

    public function add(Human $human): void
    {
        $this->humans[] = $human;
    }
}
