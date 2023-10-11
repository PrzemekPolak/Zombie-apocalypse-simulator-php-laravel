<?php

namespace App\Application;

use App\Domain\HumanInjury;

interface HumanInjuries
{
    public function add(int $humanId, string $injuryCause, int $turn): void;

    /** @return HumanInjury[] */
    public function fromTurn(int $turn): array;
}
