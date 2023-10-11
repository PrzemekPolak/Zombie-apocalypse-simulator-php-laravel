<?php

namespace App\Infrastructure;

use App\Application\HumanInjuries;
use App\Domain\HumanInjury;

class InMemoryHumanInjuries implements HumanInjuries
{
    /** @var HumanInjury[] $humanInjuries */
    private array $humanInjuries = [];

    public function add(int $humanId, string $injuryCause, int $turn): void
    {
        $this->humanInjuries[] = new HumanInjury(
            $turn,
            $injuryCause,
            $humanId,
        );
    }

    public function fromTurn(int $turn): array
    {
        $result = [];
        foreach ($this->humanInjuries as $humanInjury) {
            if ($humanInjury->injuredAt === $turn) {
                $result[] = $humanInjury;
            }
        }
        return $result;
    }
}
