<?php

namespace App\Application;

use App\Domain\HumanInjury;

interface HumanInjuries
{
    /** @return HumanInjury[] */
    public function fromTurn(int $turn): array;

    /** @param HumanInjury[] $humanInjuries */
    public function save(array $humanInjuries): void;

    /** @return HumanInjury[] */
    public function all(): array;

    public function removeAll(): void;
}
