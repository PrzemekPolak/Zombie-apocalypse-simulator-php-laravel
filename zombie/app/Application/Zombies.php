<?php

namespace App\Application;

use App\Domain\Zombie;

interface Zombies
{
    /** @param Zombie[] $zombies */
    public function save(array $zombies): void;

    public function add(Zombie $zombie): void;

    /** @return Zombie[] */
    public function stillWalking(): array;
}
