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
        $result = [];
        foreach ($this->humans as $human) {
            if ($human->isAlive()) {
                $result[] = $human;
            }
        }
        return $result;
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

    public function save(array $humans): void
    {
        foreach ($humans as $human) {
            $this->humans[$human->id] = $human;
        }
    }

    public function getNumberOfResourceProducers(string $resourceType): int
    {
        $count = 0;
        foreach ($this->humans as $human) {
            if ($human->professionType()->value === $resourceType && $human->isAlive()) {
                $count += 1;
            }
        }
        return $count;
    }

    public function injured(): array
    {
        $result = [];
        foreach ($this->humans as $human) {
            if ($human->isInjured()) {
                $result[] = $human;
            }
        }
        return $result;
    }

    public function getRandomHumans(int $count): array
    {
        shuffle($this->humans);
        return array_slice($this->allAlive(), 0, $count);
    }

    public function find(int $humanId): Human
    {
        foreach ($this->humans as $human) {
            if ($human->id === $humanId) {
                return $human;
            }
        }
    }

    public function all(): array
    {
        return $this->humans;
    }

    public function whoLastAteAt(int $turn): array
    {
        $result = [];
        foreach ($this->humans as $human) {
            if ($human->lastEatAt === $turn) {
                $result[] = $human;
            }
        }
        return $result;
    }

    public function allWithHealth(string $health): array
    {
        $result = [];
        foreach ($this->humans as $human) {
            if ($human->health === $health) {
                $result[] = $human;
            }
        }
        return $result;
    }
}
