<?php

namespace App\Application;

use App\Domain\Human;

interface Humans
{
    /** @return Human[] */
    public function allAlive(): array;

    public function countAlive(): int;

    public function update(int $id, array $fields): void;

    /** @param $humans Human[] */
    public function saveFromArray(array $humans): void;

    public function getNumberOfResourceProducers(string $resourceType): int;

    /** @return Human[] */
    public function injured(): array;

    /** @return Human[] */
    public function getRandomHumans(int $count): array;

    public function add(Human $human): void;
}
