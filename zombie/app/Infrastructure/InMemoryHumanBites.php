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

    public function save(array $humanBites): void
    {
        foreach ($humanBites as $humanBite) {
            $this->humanBites[$humanBite->humanId . '-' . $humanBite->zombieId . '-' . $humanBite->turn] = $humanBite;
        }
    }

    public function all(): array
    {
        return $this->humanBites;
    }

    public function removeAll(): void
    {
        $this->humanBites = [];
    }
}
