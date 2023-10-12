<?php

namespace App\Infrastructure;

use App\Application\Humans;
use App\Domain\Human;

class InMemoryHumans implements Humans
{
    /** @var Human[] $humans */
    private array $humans = [];

    public function allAlive(): array
    {
        return $this->humans;
    }

    public function countAlive(): int
    {
        $count = 0;
        foreach ($this->humans as $human) {
            if ($human->isAlive()) {
                $count += 1;
            }
        }
        return $count;
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
        $count = 0;
        foreach ($this->humans as $human) {
            if ($human->professionType() === $resourceType) {
                $count += 1;
            }
        }
        return $count;
    }

    public function injured(): array
    {
        throw new \Exception('Not implemented!');
    }

    public function add(Human $human): void
    {
        $this->humans[] = $human;
    }

    public function getRandomHumans(int $count): array
    {
        shuffle($this->humans);
        return array_slice($this->humans, 0, $count);
    }

    public function find(int $humanId): Human
    {
        foreach ($this->humans as $human) {
            if ($human->id === $humanId) {
                return $human;
            }
        }
    }
}
