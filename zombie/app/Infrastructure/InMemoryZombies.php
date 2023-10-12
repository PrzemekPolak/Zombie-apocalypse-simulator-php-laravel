<?php

namespace App\Infrastructure;

use App\Application\Zombies;
use App\Domain\Zombie;

class InMemoryZombies implements Zombies
{
    /** @var Zombie[] $zombies */
    private array $zombies = [];

    public function save(array $zombies): void
    {
        // TODO: Do nothing looks bad, so find way to improve it
    }

    public function add(Zombie $zombie): void
    {
        $this->zombies[] = $zombie;
    }
}
