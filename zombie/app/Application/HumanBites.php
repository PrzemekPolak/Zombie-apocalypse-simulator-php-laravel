<?php

namespace App\Application;

use App\Domain\HumanBite;

interface HumanBites
{
    /** @return HumanBite[] */
    public function fromTurn(int $turn): array;

    public function add(int $humanId, int $zombieId, int $turn): void;
}
