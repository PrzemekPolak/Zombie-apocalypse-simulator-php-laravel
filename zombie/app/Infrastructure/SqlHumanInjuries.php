<?php

namespace App\Infrastructure;

use App\Application\HumanInjuries;
use App\Domain\HumanInjury;
use App\Models\HumanInjury as HumanInjuryModel;

class SqlHumanInjuries implements HumanInjuries
{
    public function add(HumanInjury $humanInjury): void
    {
        HumanInjuryModel::add(
            $humanInjury->humanId,
            $humanInjury->injuryCause,
            $humanInjury->turn
        );
    }

    public function fromTurn(int $turn): array
    {
        throw new \Exception('Not implemented!');
    }
}
