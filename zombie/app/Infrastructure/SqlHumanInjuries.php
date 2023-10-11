<?php

namespace App\Infrastructure;

use App\Application\HumanInjuries;
use App\Models\HumanInjury as HumanInjuryModel;

class SqlHumanInjuries implements HumanInjuries
{
    public function add(int $humanId, string $injuryCause, int $turn): void
    {
        HumanInjuryModel::add($humanId, $injuryCause, $turn);
    }

    public function fromTurn(int $turn): array
    {
        throw new \Exception('Not implemented!');
    }
}
