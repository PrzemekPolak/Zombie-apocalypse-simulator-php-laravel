<?php

namespace App\Infrastructure;

use App\Application\HumanBites;
use App\Domain\HumanBite;

class InMemoryHumanBites implements HumanBites
{
    /** @var HumanBite[] $humanBites */
    private array $humanBites = [];

    public function fromTurn(int $turn): array
    {
        $result = [];
        foreach ($this->humanBites as $humanBite) {
            if ($humanBite->turn === $turn) {
                $result[] = $humanBite;
            }
        }
        return $result;
    }

    public function add(int $humanId, int $zombieId, int $turn): void
    {
        $this->humanBites[] = new HumanBite(
            $humanId,
            $zombieId,
            $turn,
        );
    }
}