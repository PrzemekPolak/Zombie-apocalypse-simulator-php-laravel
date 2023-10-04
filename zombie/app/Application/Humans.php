<?php

namespace App\Application;

use App\Domain\Human;
use App\Domain\Human as DomainHuman;

interface Humans
{
    /** @return Human[] */
    public function allAlive(): array;

    public function countAlive(): int;

    public function update(int $id, array $fields): void;

    /** @param $humans DomainHuman[] */
    public function saveFromArray(array $humans): void;
}
