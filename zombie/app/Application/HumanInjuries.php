<?php

namespace App\Application;

use App\Domain\HumanInjury;

interface HumanInjuries
{
    public function add(HumanInjury $humanInjury): void;

    /** @return HumanInjury[] */
    public function fromTurn(int $turn): array;
}
