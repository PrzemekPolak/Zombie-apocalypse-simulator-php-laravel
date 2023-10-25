<?php

namespace App\Application;

use App\Domain\HumanBite;

interface HumanBites
{
    /** @return HumanBite[] */
    public function fromTurn(int $turn): array;

    public function add(HumanBite $humanBite): void;
}
