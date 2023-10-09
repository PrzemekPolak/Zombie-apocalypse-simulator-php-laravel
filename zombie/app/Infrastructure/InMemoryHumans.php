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
        if ('health' === $resourceType) {
            return $this->countProducers(['doctor', 'nurse']);
        }
        if ('food' === $resourceType) {
            return $this->countProducers(['farmer', 'hunter']);
        }
        if ('weapon' === $resourceType) {
            return $this->countProducers(['engineer', 'mechanic']);
        }
    }

    public function injured(): array
    {
        throw new \Exception('Not implemented!');
    }

    public function add(Human $human): void
    {
        $this->humans[] = $human;
    }

    private function countProducers(array $professions): int
    {
        $count = 0;
        foreach ($this->humans as $human) {
            if (in_array($human->profession, $professions)) {
                $count += 1;
            }
        }
        return $count;
    }
}
