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
        foreach ($zombies as $zombie) {
            $this->zombies[$zombie->id] = $zombie;
        }
    }

    public function stillWalking(): array
    {
        $result = [];
        foreach ($this->zombies as $zombie) {
            if ('dead' !== $zombie->health) {
                $result[] = $zombie;
            }
        }
        return $result;
    }

    public function all(): array
    {
        return $this->zombies;
    }

    public function getRandomZombies(int $count = 1, bool $returnAllStillWalking = false): array
    {
        shuffle($this->zombies);
        return array_slice($this->zombies, 0, $returnAllStillWalking ? count($this->zombies) : $count);
    }
}
