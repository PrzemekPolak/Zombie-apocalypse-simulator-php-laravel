<?php

namespace App\Application;

use App\Domain\HumanBite;

interface HumanBites
{
    /** @return HumanBite[] */
    public function fromTurn(int $turn): array;

    public function add(HumanBite $humanBite): void;

    /** @param HumanBite[] $humanBites */
    public function save(array $humanBites): void;

    /** @return HumanBite[] */
    public function all(): array;
}
