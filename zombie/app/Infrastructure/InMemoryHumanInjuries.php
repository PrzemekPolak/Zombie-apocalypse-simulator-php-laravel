<?php

namespace App\Infrastructure;

use App\Application\HumanInjuries;
use App\Domain\HumanInjury;

class InMemoryHumanInjuries implements HumanInjuries
{
    /** @var HumanInjury[] $humanInjuries */
    private array $humanInjuries = [];

    public function add(HumanInjury $humanInjury): void
    {
        $this->humanInjuries[$humanInjury->humanId . '-' . $humanInjury->turn] = $humanInjury;
    }

    public function fromTurn(int $turn): array
    {
        $result = [];
        foreach ($this->humanInjuries as $humanInjury) {
            if ($humanInjury->turn === $turn) {
                $result[] = $humanInjury;
            }
        }
        return $result;
    }

    public function save(array $humanInjuries): void
    {
        foreach ($humanInjuries as $humanInjury) {
            $this->humanInjuries[$humanInjury->humanId . '-' . $humanInjury->turn] = $humanInjury;
        }
    }

    public function all(): array
    {
        return $this->humanInjuries;
    }
}
