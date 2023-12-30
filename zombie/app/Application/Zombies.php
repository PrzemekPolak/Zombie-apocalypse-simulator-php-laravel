<?php

namespace App\Application;

use App\Domain\Zombie;

interface Zombies
{
    /** @param Zombie[] $zombies */
    public function save(array $zombies): void;

    /** @return Zombie[] */
    public function stillWalking(): array;

    /** @return Zombie[] */
    public function all(): array;

    /** @return Zombie[] */
    public function getNumberOfRandomStillWalkingZombies(int $count): array;

    public function removeAll(): void;
}
